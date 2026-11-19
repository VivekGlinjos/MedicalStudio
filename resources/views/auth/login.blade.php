@extends('layouts.auth')

@section('title', 'Login')

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
            <h1 style="font-family:var(--font-display);font-size:2.5rem;font-weight:800;line-height:1.1;color:white;margin-bottom:1rem;">Welcome<br>Back.</h1>
            <p style="color:rgba(255,255,255,0.55);font-size:1rem;line-height:1.7;">Access your NEET-PG counselling dashboard, rank predictions, allotment maps, and choice lists.</p>

            <div class="auth-left-features">
                @foreach([
                    ['fa-chart-line', 'Rank Scan & Prediction', 'Clinical-grade admission probability engine'],
                    ['fa-map', 'Live Allotment Mapping', 'Real-time seat vacancy tracking'],
                    ['fa-list-check', 'Choice List Builder', 'Build & optimize your preference list'],
                    ['fa-headset', '24/7 Expert Support', 'Personal counselling helpline'],
                ] as $f)
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fa-solid {{ $f[0] }}"></i>
                    </div>
                    <div>
                        <div style="color:white;font-weight:600;font-size:0.95rem;">{{ $f[1] }}</div>
                        <div style="color:rgba(255,255,255,0.45);font-size:0.8rem;">{{ $f[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="auth-right">
        <div class="auth-box">
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--ink);margin-bottom:0.5rem;">Sign In</h2>
            <p style="color:var(--muted);font-size:0.9rem;margin-bottom:2rem;">Don't have an account? <a href="{{ route('register') }}" style="color:var(--blue);font-weight:600;">Create one free</a></p>

            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom:1.5rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="doctor@email.com" required autofocus>
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">
                        Password
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="float:right;color:var(--blue);font-size:0.8rem;font-weight:600;text-transform:none;">Forgot password?</a>
                        @endif
                    </label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;">
                    <input type="checkbox" id="remember_me" name="remember" style="width:16px;height:16px;accent-color:var(--blue);">
                    <label for="remember_me" style="font-size:0.875rem;color:var(--body-text);">Remember me</label>
                </div>

                <button type="submit" class="btn btn-teal btn-lg btn-block" style="margin-bottom:1rem;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
                </button>
            </form>

            <div style="position:relative;text-align:center;margin:1.5rem 0;">
                <div style="position:absolute;inset:0;display:flex;align-items:center;">
                    <div style="width:100%;border-top:1px solid var(--border);"></div>
                </div>
                <span style="position:relative;background:white;padding:0 0.75rem;font-size:0.8rem;color:var(--muted);">Or</span>
            </div>

            <a href="{{ route('home') }}" class="btn btn-outline btn-lg btn-block">
                <i class="fa-solid fa-house"></i> Back to Home
            </a>

            <p style="text-align:center;font-size:0.8rem;color:var(--muted);margin-top:2rem;">
                <i class="fa-solid fa-lock" style="color:var(--green);"></i>
                Secured &amp; encrypted. Medical Studio never shares your data.
            </p>
        </div>
    </div>
</div>
@endsection
