@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<div class="auth-page">
    {{-- Left Panel --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;">
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;margin-bottom:2.5rem;text-decoration:none;">
                <span style="font-family:var(--font-display);font-size:1.4rem;font-weight:800;letter-spacing:-0.03em;">
                    <span style="color:#60a5fa;">MEDICAL</span><span style="color:white;"> STUDIO</span>
                </span>
            </a>
            <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:800;line-height:1.1;color:white;margin-bottom:1rem;">Navigate with<br>Confidence.</h1>
            <p style="color:rgba(255,255,255,0.55);font-size:1rem;line-height:1.7;margin-bottom:2rem;">Join 5,000+ doctors who made data-driven NEET-PG counselling decisions. Free to start.</p>

            @foreach([
                ['✅', 'Free Seat Predictor — estimate your choices instantly'],
                ['📊', 'Access basic institute database — 1,100+ colleges'],
                ['🚀', 'Upgrade anytime for full Rank Scan, Allotment Mapping &amp; Choice Builder'],
                ['👨‍⚕️', 'Expert helpline available during all counselling rounds'],
            ] as $f)
            <div style="display:flex;align-items:flex-start;gap:0.75rem;margin-bottom:1rem;">
                <span style="font-size:1.1rem;flex-shrink:0;">{{ $f[0] }}</span>
                <span style="color:rgba(255,255,255,0.65);font-size:0.875rem;line-height:1.5;">{!! $f[1] !!}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="auth-right">
        <div class="auth-box">
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--ink);margin-bottom:0.5rem;">Create Account</h2>
            <p style="color:var(--muted);font-size:0.9rem;margin-bottom:2rem;">Already registered? <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Sign in</a></p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" placeholder="Dr. / Candidate Name" required autofocus>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="doctor@email.com" required>
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Min. 8 characters" required>
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
                </div>

                <button type="submit" class="btn btn-teal btn-lg btn-block" style="margin-bottom:1rem;">
                    <i class="fa-solid fa-rocket"></i> Create My Account
                </button>

                <p style="font-size:0.8rem;color:var(--muted);text-align:center;margin-bottom:1rem;">
                    By registering, you agree to our
                    <a href="#" style="color:var(--blue);">Terms of Service</a> &
                    <a href="#" style="color:var(--blue);">Privacy Policy</a>.
                </p>
            </form>

            <a href="{{ route('home') }}" class="btn btn-outline btn-lg btn-block">
                <i class="fa-solid fa-house"></i> Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
