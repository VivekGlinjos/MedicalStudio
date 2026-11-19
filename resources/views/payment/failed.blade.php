@extends('layouts.app')

@section('title', 'Payment Failed | Medical Studio')

@section('content')
<section class="section" style="min-height:70vh; display:flex; align-items:center;">
    <div class="container text-center" style="max-width:500px;">
        <div style="background:var(--bg-soft); padding:3rem; border-radius:var(--r-xl); border:1px solid var(--border);">
            <div style="width:80px; height:80px; background:var(--red); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; margin:0 auto 1.5rem;">
                <i class="fa-solid fa-xmark"></i>
            </div>
            
            <h1 class="display-sm" style="color:var(--ink); margin-bottom:1rem;">Payment Denied</h1>
            
            <p style="color:var(--muted); margin-bottom:2rem; line-height:1.6;">
                We're sorry, but your payment was declined or could not be processed at this time. Please try again or contact support if the issue persists.
            </p>
            
            <a href="{{ route('packages') }}" class="btn btn-red" style="padding:1rem 2rem; border-radius:999px;">
                <i class="fa-solid fa-rotate-right" style="margin-right:0.5rem;"></i> Try Again
            </a>
        </div>
    </div>
</section>
@endsection
