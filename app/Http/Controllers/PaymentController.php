<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout($id)
    {
        $package = \App\Models\ServicePackage::findOrFail($id);

        // Parse amount (convert to paise for Razorpay)
        $amountStr = preg_replace('/[^0-9.]/', '', $package->amount);
        $amount = (float) ($amountStr ?: 0);
        $amountInPaise = (int)($amount * 100);

        $user = auth()->user();

        // Create pending payment record first
        $payment = \App\Models\Payment::create([
            'user_id' => $user->id,
            'service_package_id' => $package->id,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        // Create Razorpay Order
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $razorpayOrder = $api->order->create([
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => 'payment_' . $payment->id,
                'notes' => [
                    'payment_id' => $payment->id,
                    'user_id' => $user->id,
                ]
            ]);

            // Store Razorpay order ID
            $payment->update(['razorpay_order_id' => $razorpayOrder->id]);

        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            $payment->delete();
            return back()->with('error', 'Failed to initiate payment. Please try again.');
        }

        return view('payment.checkout', [
            'package' => $package,
            'payment' => $payment,
            'orderId' => $razorpayOrder->id,
            'packagePrice' => $amount,
            'userName' => $user->name,
            'userEmail' => $user->email,
        ]);
    }

    /**
     * Verify payment after Razorpay checkout callback
     */
    public function verify(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        // Verify the payment signature
        try {
            $attributes = [
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $e) {
            Log::error('Razorpay signature verification failed: ' . $e->getMessage());
            return redirect()->route('payment.failed')->with('error', 'Payment verification failed.');
        }

        // Find the payment record by order ID
        $payment = \App\Models\Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();

        if ($payment && $payment->status !== 'success') {
            $payment->update([
                'status'           => 'success',
                'transaction_id'   => $request->razorpay_payment_id,
                'payment_method'   => 'razorpay',
            ]);

            // Mark user as paid
            $user = $payment->user;
            if ($user) {
                $user->is_paid = true;
                
                // Fetch phone from Razorpay if not set
                if (empty($user->phone) && $request->razorpay_payment_id) {
                    try {
                        $rpPayment = $api->payment->fetch($request->razorpay_payment_id);
                        if (isset($rpPayment->contact)) {
                            $user->phone = $rpPayment->contact;
                        }
                    } catch (\Exception $e) {
                        Log::error("Could not fetch razorpay payment contact: " . $e->getMessage());
                    }
                }
                
                $user->save();

                // Generate PDF Invoice
                try {
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payment.invoice', [
                        'payment' => $payment,
                        'user'    => $user,
                        'package' => \App\Models\ServicePackage::find($payment->service_package_id)
                    ]);
                    \Illuminate\Support\Facades\Storage::put('invoices/invoice_' . $payment->id . '.pdf', $pdf->output());
                } catch (\Exception $e) {
                    Log::error("Invoice generation failed for payment {$payment->id}: " . $e->getMessage());
                }
            }
        }

        // Always return JSON for AJAX requests, otherwise redirect
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Payment successful! Welcome to your Premium Dashboard.');
    }

    public function success(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Read parameters sent by Razorpay
        $paymentId = $request->input('razorpay_payment_id');
        $signature = $request->input('razorpay_signature');

        Log::info('Razorpay success redirect called', [
            'user_id' => $user->id,
            'razorpay_payment_id' => $paymentId,
        ]);

        if ($paymentId) {
            // Verify that this payment wasn't already successfully recorded
            $alreadyProcessed = \App\Models\Payment::where('transaction_id', $paymentId)
                                ->where('status', 'success')
                                ->exists();

            if (!$alreadyProcessed) {
                try {
                    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                    $paymentDetails = $api->payment->fetch($paymentId);

                    // Check if payment is successfully completed
                    if ($paymentDetails && in_array($paymentDetails->status, ['captured', 'authorized'])) {
                        
                        // Mark user as paid
                        $user->is_paid = true;
                        $user->save();

                        // Find the latest pending payment for this user
                        $payment = \App\Models\Payment::where('user_id', $user->id)
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->first();

                        if ($payment) {
                            $payment->update([
                                'status' => 'success',
                                'transaction_id' => $paymentId,
                                'payment_method' => $paymentDetails->method ?? 'razorpay',
                            ]);

                            // Generate PDF Invoice
                            try {
                                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payment.invoice', [
                                    'payment' => $payment,
                                    'user'    => $user,
                                    'package' => \App\Models\ServicePackage::find($payment->service_package_id)
                                ]);
                                \Illuminate\Support\Facades\Storage::put('invoices/invoice_' . $payment->id . '.pdf', $pdf->output());
                            } catch (\Exception $e) {
                                Log::error("Invoice generation failed: " . $e->getMessage());
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error verifying Razorpay payment: ' . $e->getMessage());
                }
            } else {
                // If already processed, make sure user is paid
                $user->is_paid = true;
                $user->save();
            }
        }

        // Always redirect to dashboard
        if ($user->is_paid) {
            return redirect()->route('dashboard')->with('success', 'Payment successful!');
        }

        return redirect()->route('packages')->with('error', 'Payment could not be verified.');
    }

    public function failed()
    {
        return view('payment.failed');
    }

    public function downloadInvoice($id)
    {
        $payment = \App\Models\Payment::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        
        if ($payment->status !== 'success') {
            return back()->with('error', 'Invoice is only available for successful payments.');
        }

        $path = 'invoices/invoice_' . $payment->id . '.pdf';

        if (!\Illuminate\Support\Facades\Storage::exists($path)) {
            // If not found, regenerate
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payment.invoice', [
                'payment' => $payment,
                'user' => $payment->user,
                'package' => \App\Models\ServicePackage::find($payment->service_package_id)
            ]);
            \Illuminate\Support\Facades\Storage::put($path, $pdf->output());
        }

        return \Illuminate\Support\Facades\Storage::download($path, 'Invoice_' . ($payment->transaction_id ?? $payment->id) . '.pdf');
    }

    public function webhook(Request $request)
    {
        // Razorpay Webhook Endpoint
        $payload = $request->getContent();
        $sigHeader = $request->header('X-Razorpay-Signature');
        $secret = config('services.razorpay.webhook_secret');

        if ($secret && $sigHeader) {
            $expectedSig = hash_hmac('sha256', $payload, $secret);
            if (!hash_equals($expectedSig, $sigHeader)) {
                Log::warning('Invalid Razorpay webhook signature');
                return response('Invalid signature', 400);
            }
        }

        $data = json_decode($payload, true);
        $event = $data['event'] ?? '';

        if (in_array($event, ['payment.captured', 'payment.authorized'])) {
            $paymentEntity = $data['payload']['payment']['entity'] ?? null;

            if ($paymentEntity) {
                $notes = $paymentEntity['notes'] ?? [];
                $paymentId = $notes['payment_id'] ?? null;

                if ($paymentId) {
                    $payment = \App\Models\Payment::find($paymentId);
                    if ($payment && $payment->status !== 'success') {
                        $payment->update([
                            'status' => 'success',
                            'transaction_id' => $paymentEntity['id'] ?? null,
                            'payment_method' => $paymentEntity['method'] ?? 'razorpay',
                        ]);

                        $user = $payment->user;
                        if ($user) {
                            $user->is_paid = true;
                            $user->save();
                            
                            // Generate invoice
                            try {
                                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payment.invoice', [
                                    'payment' => $payment,
                                    'user' => $user,
                                    'package' => \App\Models\ServicePackage::find($payment->service_package_id)
                                ]);
                                \Illuminate\Support\Facades\Storage::put('invoices/invoice_' . $payment->id . '.pdf', $pdf->output());
                            } catch (\Exception $e) {
                                Log::error("Invoice generation failed: " . $e->getMessage());
                            }
                        }
                    }
                }
            }
        }

        if (in_array($event, ['payment.failed'])) {
            $paymentEntity = $data['payload']['payment']['entity'] ?? null;
            if ($paymentEntity) {
                $notes = $paymentEntity['notes'] ?? [];
                $paymentId = $notes['payment_id'] ?? null;
                if ($paymentId) {
                    $payment = \App\Models\Payment::find($paymentId);
                    if ($payment && $payment->status === 'pending') {
                        $payment->update(['status' => 'failed']);
                    }
                }
            }
        }

        return response('OK', 200);
    }
}
