@extends('layouts.app')

@section('title', 'Secure Checkout...')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--bg-soft, #f8fafc);">
    <div style="text-align: center;">
        <!-- Loading Spinner -->
        <div style="display: inline-block; width: 3rem; height: 3rem; border: 4px solid rgba(29, 78, 216, 0.2); border-top-color: var(--blue, #1d4ed8); border-radius: 50%; animation: spin 1s linear infinite; margin-bottom: 1.5rem;"></div>
        
        <h2 style="color: var(--ink, #0f172a); font-weight: 800; font-size: 1.5rem; margin-bottom: 0.5rem;">Opening Secure Payment Gateway...</h2>
        <p style="color: var(--muted, #64748b); font-size: 1rem;">Please do not refresh or close this window.</p>
        
        <div id="rzp-container" style="display: none;">
            {!! $link !!}
        </div>
    </div>
</div>

<style>
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Look for the Razorpay button injected by their script and click it automatically
    let attempts = 0;
    const interval = setInterval(() => {
        const rzpBtn = document.querySelector('.razorpay-payment-button');
        if (rzpBtn) {
            clearInterval(interval);
            rzpBtn.click();
        }
        
        attempts++;
        // If it takes more than 5 seconds to load, show the button as a fallback
        if (attempts > 50) { 
            clearInterval(interval);
            document.getElementById('rzp-container').style.display = 'block';
        }
    }, 100);
});
</script>
@endsection
