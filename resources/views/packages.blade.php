@extends('layouts.app')

@section('title', 'Packages & Pricing — Medical Studio NEET-PG Counselling Plans')
@section('meta_description', 'Choose your Medical Studio package. All exams now available under our universal ₹1,499 package. Includes seat matrix, rank prediction, and expert support.')

@section('content')

{{-- Page Hero --}}
<section class="inner-hero" style="border-bottom: 1px solid var(--border);">
    <div style="position:absolute;inset:0;z-index:0;overflow:hidden;">
        <img src="{{ asset('images/pkg_hero.png') }}" alt="" style="width:100%;height:100%;object-fit:cover;opacity:0.04; filter: invert(1);">
    </div>
    <div class="container" style="position:relative;z-index:1;">
        <span class="eyebrow" style="color:var(--blue);">Simple Pricing</span>
        <h1 class="display-xl" style="color:var(--ink); margin-top:0.75rem;">Big On Data.<br>Light On Your Pocket.</h1>
        <p style="color:var(--muted);font-size:1.05rem;margin:1rem auto 0;max-width:500px;line-height:1.75;">
            Access all the data you need without overpaying for it. Cancel anytime. No hidden fees.
        </p>
        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;margin-top:2rem;">
            <div style="display:flex;align-items:center;gap:0.5rem;color:var(--ink-3);font-size:0.82rem;font-weight:600;">
                <i class="fa-solid fa-circle-check" style="color:var(--blue);"></i> Instant Access
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;color:var(--ink-3);font-size:0.82rem;font-weight:600;">
                <i class="fa-solid fa-circle-check" style="color:var(--blue);"></i> No Auto-Renewal
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;color:var(--ink-3);font-size:0.82rem;font-weight:600;">
                <i class="fa-solid fa-circle-check" style="color:var(--blue);"></i> Secure Payment
            </div>
        </div>
    </div>
</section>

{{-- ALL PACKAGES GRID --}}
<section class="section" style="background:var(--bg-soft);">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow">Our Plans</span>
            <h2 class="section-title">Choose Your Package</h2>
            <p style="color:var(--muted);font-size:1rem;margin-top:0.75rem;max-width:520px;margin-left:auto;margin-right:auto;">
                Every package gives you complete data coverage and tools for your specific counselling exam.
            </p>
        </div>

        @php
        // UI mappings for packages (can be extended if more packages are added later)
        $colors = ['#1d4ed8', '#0891b2', '#7c3aed'];
        $images = ['pkg_1.png', 'pkg_2.png', 'pkg_3.png'];
        @endphp

        {{-- Cards Grid --}}
        <div class="row justify-content-center g-4">
            @foreach($packages as $index => $plan)
            @php
                $color = $colors[$index % count($colors)];
                $image = $plan->image ? $plan->image : $images[$index % count($images)];
                $isFeatured = $index === 0; // Highlight the first one
            @endphp
            <div class="col-12 col-md-6">
            <div class="pkg-plan-card {{ $isFeatured ? 'featured' : '' }} h-100 d-flex flex-column" style="{{ $isFeatured ? 'border-color:'.$color.';box-shadow:0 8px 32px rgba(29,78,216,0.12);' : '' }} padding: 1.5rem; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;">

                {{-- Card Header: Title and Price next to each other to save space --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        {{-- Badge --}}
                        @if($isFeatured)
                        <span style="display:inline-block;background:{{ $color }};color:#fff;font-size:0.6rem;font-weight:700;padding:2px 8px;border-radius:999px;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:0.5rem;">
                            Best Value
                        </span>
                        @endif
                        <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--ink);letter-spacing:-0.01em;margin-bottom:0.25rem;line-height:1.3;">
                            {{ $plan->name }}
                        </h3>
                    </div>
                    
                    {{-- Price --}}
                    <div style="text-align:right;">
                        @if($plan->amount === 'Free' || $plan->amount == 0)
                            <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--green);letter-spacing:-0.025em;line-height:1;">Free</div>
                        @else
                            @if($plan->actual_amount)
                                <div style="font-size:0.85rem;color:var(--muted-lt);text-decoration:line-through;margin-bottom:2px;">₹{{ rtrim(rtrim($plan->actual_amount, '0'), '.') }}</div>
                            @endif
                            <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--ink);letter-spacing:-0.025em;line-height:1;">₹{{ rtrim(rtrim($plan->amount, '0'), '.') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Card Image (Full banner format) --}}
                <div style="height:140px; margin-bottom:1rem; position:relative; border-radius:8px; overflow:hidden; background:var(--bg-soft); display:flex; align-items:center; justify-content:center;">
                    @php
                        $objPos = 'center';
                        if ($image == 'pkg_1.png') $objPos = '50% 75%';
                        elseif ($image == 'pkg_2.png') $objPos = '50% 60%';
                        elseif ($image == 'pkg_3.png') $objPos = '50% 50%';
                    @endphp
                    <img src="{{ asset('images/'.$image) }}" alt="{{ $plan->name }}"
                         style="width:100%; height:100%; object-fit:cover; object-position:{{ $objPos }};"
                         onerror="this.parentElement.style.background='linear-gradient(135deg,#f0f9ff,#e0f2fe)'">
                    {{-- Exam label --}}
                    <div style="position:absolute;bottom:0.5rem;left:0.5rem;">
                        <span style="font-size:0.65rem;font-weight:700;color:rgba(255,255,255,0.9);letter-spacing:0.08em;text-transform:uppercase;background:rgba(0,0,0,0.5);padding:2px 6px;border-radius:4px;">All Exams</span>
                    </div>
                </div>

                {{-- Features --}}
                <style>
                    .package-features-{{$index}} ul { list-style: none; padding-left: 0; display: grid; grid-template-columns: 1fr; gap: 0.4rem; margin-bottom: 0; }
                    .package-features-{{$index}} li { display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.75rem; color: var(--ink-3); line-height: 1.3; }
                    .package-features-{{$index}} li::before { content: "\f058"; font-family: "Font Awesome 6 Free"; font-weight: 900; color: {{ $isFeatured ? $color : 'var(--blue)' }}; margin-top: 1px; flex-shrink: 0; font-size: 0.75rem; }
                    @media(min-width: 768px) {
                        .package-features-{{$index}} ul { grid-template-columns: 1fr 1fr; }
                    }
                </style>
                <div class="package-features-{{$index}} flex-grow-1" style="margin-bottom:1.5rem;">
                    {!! $plan->description !!}
                </div>

                {{-- CTA --}}
                <div class="mt-auto">
                    <a href="{{ auth()->check() ? route('checkout', $plan->id) : route('register') }}"
                       class="btn btn-block w-100"
                       style="background:{{ $isFeatured ? $color : 'var(--ink)' }};color:#fff;border-radius:8px;font-weight:600;padding:0.6rem;margin-bottom:0.5rem;box-shadow:{{ $isFeatured ? '0 6px 20px rgba(29,78,216,0.25)' : '0 4px 12px rgba(15,23,42,0.15)' }}; font-size: 0.9rem;">
                        <i class="fa-solid fa-rocket"></i> Buy Now
                    </a>
                    <p style="text-align:center;font-size:0.7rem;color:var(--muted-lt);margin-bottom:0;">
                        <i class="fa-solid fa-lock" style="color:var(--green);"></i>
                        Secure · Instant access
                    </p>
                </div>

            </div>
            </div>
            @endforeach
        </div>
        </div>

        {{-- Note --}}
        <div class="alert alert-info" style="max-width:800px;margin:2.5rem auto 0;">
            <i class="fa-solid fa-circle-info"></i>
            <div>
                <strong>Note:</strong> All packages include base platform access for the corresponding counselling type.
                The Expert Guidance add-on provides truly unlimited, dedicated 1-on-1 phone calls and email support from our NEET counselling specialists.
            </div>
        </div>
    </div>
</section>


{{-- CTA Section --}}
<section style="background:linear-gradient(135deg,var(--ink) 0%,#1e3a8a 100%);padding:5rem 0;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse at center,rgba(96,165,250,0.1) 0%,transparent 65%);pointer-events:none;"></div>
    <div class="container" style="position:relative;z-index:1;">
        <h2 style="font-family:var(--font-display);font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:#fff;letter-spacing:-0.025em;margin-bottom:1rem;">
            Not Sure Which Plan?
        </h2>
        <p style="color:rgba(255,255,255,0.65);font-size:1rem;max-width:480px;margin:0 auto 2rem;line-height:1.75;">
            Talk to our counselling experts for free. We'll guide you to the right plan based on your exam and goals.
        </p>
        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" class="btn btn-white btn-lg">
                <i class="fa-solid fa-phone"></i> Talk to an Expert
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,0.3);color:#fff;">
                <i class="fa-solid fa-rocket"></i> Start Free
            </a>
        </div>
    </div>
</section>

@endsection
