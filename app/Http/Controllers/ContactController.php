<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'message' => 'nullable|string|max:1000',
        ]);

        // Determine enquiry_for from either field
        $enquiryFor = $request->enquiry_for ?? $request->exam ?? $request->course ?? 'General Enquiry';

        // Get email from form or from authenticated user
        $email = $request->email ?? auth()->user()?->email ?? '';

        \App\Models\Enquiry::create([
            'name'        => $request->name,
            'email'       => $email,
            'phone'       => $request->phone,
            'enquiry_for' => $enquiryFor,
            'location'    => $request->location ?? '',
            'message'     => $request->message ?? '',
        ]);

        if ($enquiryFor === 'NEET PG Predictor Alert') {
            return back()->with('pg_alert', 'You will be notified as soon as the predictor is live!');
        }

        if ($request->has('is_quick_form')) {
            return back()->with([
                'success' => 'Thank you! Our expert will contact you within 24 hours.',
                'quick_form' => true
            ]);
        }

        return back()->with('success', 'Thank you! Our expert will contact you within 24 hours.');
    }
}
