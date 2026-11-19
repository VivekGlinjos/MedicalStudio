@extends('layouts.app')

@section('title', $data['name'] . ' Counselling 2026 — Medical Studio')

@section('content')

<section class="inner-hero" style="background:linear-gradient(135deg,{{ $data['color'] }}22 0%,var(--bg-soft) 60%);">
    <div class="container">
        <div style="display:inline-flex;align-items:center;gap:0.5rem;background:{{ $data['color'] }}22;border:1px solid {{ $data['color'] }}44;border-radius:var(--r-full);padding:5px 14px;font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:{{ $data['color'] }};margin-bottom:1.5rem;">
            <i class="fa-solid {{ $data['icon'] }}"></i> {{ $data['name'] }} 2026
        </div>
        <h1 class="display-xl text-ink" style="max-width:700px;margin:0 auto 1rem;">{{ $data['tagline'] }}</h1>
        <p style="color:var(--muted);max-width:560px;margin:0 auto 2rem;font-size:1rem;line-height:1.75;">{{ $data['desc'] }}</p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('packages') }}" class="btn btn-red btn-lg">
                <i class="fa-solid fa-crown"></i> Get {{ $data['name'] }} Package — {{ $data['price'] }}
            </a>
            <a href="{{ route('seat-predictor') }}" class="btn btn-outline-white btn-lg">
                <i class="fa-solid fa-chart-bar"></i> Seat Predictor
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:4rem;align-items:start;">
            <div class="reveal">
                <span class="eyebrow">Counselling Rounds</span>
                <h2 class="display-md" style="margin:0.75rem 0 1.5rem;">The {{ $data['name'] }}<br>Counselling Process</h2>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @foreach($data['rounds'] as $i => $round)
                    <div style="display:flex;align-items:flex-start;gap:1rem;padding:1.25rem;background:var(--bg-soft);border-radius:var(--r-lg);border:1px solid var(--border);">
                        <div style="width:36px;height:36px;border-radius:50%;background:{{ $data['color'] }};color:white;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;flex-shrink:0;font-size:0.9rem;">{{ $i+1 }}</div>
                        <div>
                            <div style="font-family:var(--font-display);font-weight:700;color:var(--ink);">{{ $round }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="reveal reveal-d2">
                <span class="eyebrow">{{ $data['name'] }} Coverage</span>
                <h2 class="display-md" style="margin:0.75rem 0 1.5rem;">What's Included<br>in Your Package</h2>
                <div class="card" style="border:none;background:var(--bg-soft);">
                    <div style="display:flex;gap:2rem;margin-bottom:1.5rem;flex-wrap:wrap;">
                        <div>
                            <div style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--ink);">{{ $data['seats'] }}</div>
                            <div style="font-size:0.8rem;color:var(--muted);">Seats covered</div>
                        </div>
                        <div>
                            <div style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--ink);">{{ $data['institutes'] }}</div>
                            <div style="font-size:0.8rem;color:var(--muted);">Institutes</div>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:0.75rem;">
                        @foreach($data['features'] as $feat)
                        <div style="display:flex;align-items:center;gap:0.75rem;font-size:0.9rem;color:var(--body-text);">
                            <i class="fa-solid fa-circle-check" style="color:var(--green);flex-shrink:0;"></i>
                            {!! $feat !!}
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top:2rem;">
                        <a href="{{ route('packages') }}" class="btn btn-red btn-block btn-lg">
                            <i class="fa-solid fa-rocket"></i> Get Started — {{ $data['price'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
