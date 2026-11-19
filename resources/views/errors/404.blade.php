@extends('layouts.app')
@section('title', '404 — Page Not Found | Medical Studio')
@section('content')
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;">
    <div>
        <div style="font-family:var(--font-heading);font-size:8rem;font-weight:900;color:var(--color-red);line-height:1;margin-bottom:1rem;">404</div>
        <h1 style="font-size:2rem;margin-bottom:1rem;color:var(--color-heading);">Page Not Found</h1>
        <p style="color:var(--color-body);margin-bottom:2rem;max-width:400px;">This route seems to have a negative shift. Let's navigate you back to the right place.</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
            <i class="fa-solid fa-house"></i> Back to Home
        </a>
    </div>
</section>
@endsection
