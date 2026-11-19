@extends('layouts.app')

@section('title', 'Checkout | Medical Studio')

@section('content')
<section class="section" style="min-height:80vh; display:flex; align-items:center; background:var(--bg-soft);">
    <div class="container text-center" style="max-width:600px;">
        <div style="background:#fff; padding:3.5rem; border-radius:24px; border:1px solid var(--border); box-shadow:0 12px 40px rgba(0,0,0,0.06);">
            
            <div style="margin-bottom:1.5rem; display:inline-block; padding:1rem; border-radius:50%; background:var(--blue-light); color:var(--blue);">
                <i class="fa-solid fa-cart-shopping fa-2xl"></i>
            </div>
            
            <h1 class="display-sm" style="color:var(--ink); margin-bottom:1rem; font-weight:800; letter-spacing:-0.02em;">Order Summary</h1>
            
            <div style="background:var(--bg-soft); border-radius:16px; padding:1.5rem; margin-bottom:2rem; text-align:left;">
                <div style="display:flex; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px dashed var(--border-dark);">
                    <span style="color:var(--muted); font-weight:600;">Package</span>
                    <span style="color:var(--ink); font-weight:700;">{{ $package->name }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:1rem; padding-bottom:1rem; border-bottom:1px dashed var(--border-dark);">
                    <span style="color:var(--muted); font-weight:600;">User Email</span>
                    <span style="color:var(--ink); font-weight:700;">{{ $userEmail }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="color:var(--muted); font-weight:600;">Total Amount</span>
                    <span style="color:var(--ink); font-size:1.5rem; font-weight:800;">₹{{ number_format($payment->amount, 2) }}</span>
                </div>
            </div>
            
            {{-- Proceed to Pay Button --}}
            <div style="margin: 2rem 0; display: flex; justify-content: center; width: 100%;">
                {!! $package->payment_button_link !!}
            </div>
            
            <div style="margin-top:2rem; font-size:0.85rem; color:var(--muted-lt); display:flex; justify-content:center; align-items:center; gap:0.5rem;">
                <img src="https://razorpay.com/assets/razorpay-logo.svg" alt="Razorpay" style="height:20px; opacity:0.6;">
                <span>100% Secure Payment Processing</span>
            </div>
        </div>
    </div>
</section>
@endsection
