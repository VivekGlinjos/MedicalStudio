@extends('layouts.app')

@section('title', 'Secure Checkout — Medical Studio Premium')

@section('content')
<section class="section" style="background:var(--bg-soft); min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card" style="padding: 2rem; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: none;">
                    
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <span style="display:inline-block;background:rgba(29,78,216,0.1);color:#1d4ed8;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:999px;text-transform:uppercase;margin-bottom:1rem;">Checkout</span>
                        <h2 style="font-family: var(--font-display); font-size: 1.75rem; font-weight: 800; color: var(--ink);">Premium Package</h2>
                        <p style="color: var(--muted); font-size: 0.9rem; margin-top: 0.5rem;">Unlock Rank Scan, Seat Matrix, Allotment Mapping & Choice List Builder.</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--ink); font-weight: 600;">
                            <span>{{ $package->name }}</span>
                            <span>₹{{ number_format($packagePrice, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: var(--muted); font-size: 0.85rem; margin-bottom: 1rem;">
                            <span>Taxes</span>
                            <span>Included</span>
                        </div>
                        <hr class="divider">
                        <div style="display: flex; justify-content: space-between; color: var(--ink); font-weight: 800; font-size: 1.25rem;">
                            <span>Total</span>
                            <span>₹{{ number_format($packagePrice, 2) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('payment.verify') }}" method="POST" id="razorpay-form">
                        @csrf
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $orderId }}">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                        
                        <button type="button" id="pay-btn" class="btn btn-block" style="background: var(--blue); color: white; border-radius: 12px; font-weight: 700; padding: 1rem; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(29, 78, 216, 0.25); cursor: pointer; border: none;">
                            Pay ₹{{ number_format($packagePrice, 2) }} Securely
                        </button>
                    </form>

                    <div style="text-align: center; margin-top: 1.5rem; color: var(--muted-lt); font-size: 0.8rem;">
                        <i class="fa-solid fa-lock" style="color: var(--green);"></i> Payments processed securely by Razorpay
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ (int)($packagePrice * 100) }}", 
        "currency": "INR",
        "name": "Medical Studio",
        "description": "{{ $package->name }}",
        "image": "{{ asset('images/logo.png') }}",
        "order_id": "{{ $orderId }}",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ auth()->user()->name }}",
            "email": "{{ auth()->user()->email }}"
        },
        "theme": {
            "color": "#1d4ed8"
        },
        "modal": {
            "ondismiss": function(){

            }
        }
    };
    
    var rzp = new Razorpay(options);
    
    document.getElementById('pay-btn').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
</script>
@endsection
