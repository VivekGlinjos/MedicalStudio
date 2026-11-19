@extends('layouts.app')

@section('title', 'Payment Success | Medical Studio')

@section('content')
<section class="section" style="min-height:70vh; display:flex; align-items:center;">
    <div class="container text-center" style="max-width:500px;">
        <div style="background:var(--bg-soft); padding:3rem; border-radius:var(--r-xl); border:1px solid var(--border);">
            <div style="width:80px; height:80px; background:var(--green); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 1.5rem;">
                <i class="fa-solid fa-check"></i>
            </div>
            
            <h1 class="display-sm" style="color:var(--ink); margin-bottom:1rem;">Payment Successful!</h1>
            
            <p style="color:var(--muted); margin-bottom:2rem; line-height:1.6;">
                Thank you for your purchase. Your payment has been verified, and you now have full access to your subscribed features.
            </p>
            
            <div style="display:flex; flex-direction:column; gap:1rem; align-items:center;">
                @if(isset($payment) && $payment)
                    <a href="{{ route('payment.invoice', $payment->id) }}" class="btn btn-outline" style="padding:0.75rem 2rem; border-radius:999px;">
                        <i class="fa-solid fa-file-pdf" style="margin-right:0.5rem; color:var(--red);"></i> Download Invoice
                    </a>
                @endif
                <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding:1rem 2rem; border-radius:999px;">
                    Go to Dashboard <i class="fa-solid fa-arrow-right" style="margin-left:0.5rem;"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
