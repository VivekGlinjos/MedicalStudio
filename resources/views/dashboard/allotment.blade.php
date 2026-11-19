@extends('layouts.dashboard')

@section('title', 'Allotment Mapping - Coming Soon | Medical Studio')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; text-align: center; padding: 3rem 1rem;">
    <!-- Coming Soon Badge -->
    <div style="display: inline-block; background: rgba(139, 92, 246, 0.1); color: #8b5cf6; font-size: 0.85rem; font-weight: 700; padding: 0.5rem 1.25rem; border-radius: 99px; border: 1px solid rgba(139, 92, 246, 0.2); margin-bottom: 1.5rem; letter-spacing: 0.05em; text-transform: uppercase;">
        <i class="fa-solid fa-rocket me-2"></i> Coming Soon
    </div>

    <!-- Main Title -->
    <h1 class="display-lg" style="color: var(--ink); margin-bottom: 1rem; font-weight: 800; font-size: 3rem;">
        Allotment Mapping
    </h1>
    
    <p style="color: var(--muted); font-size: 1.2rem; line-height: 1.6; max-width: 700px; margin: 0 auto 3rem auto;">
        We are building the most advanced real-time seat tracking system. See exactly who joined where, and discover hidden virtual vacancies before anyone else does.
    </p>

    <!-- Features Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; text-align: left; margin-bottom: 4rem;">
        
        <!-- Feature 1 -->
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-users-viewfinder"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--ink); margin-bottom: 0.75rem;">Track Candidate Movement</h3>
            <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.5; margin: 0;">
                Monitor the exact flow of students between colleges across different counselling rounds. Know exactly which seats are locked and which are floating.
            </p>
        </div>

        <!-- Feature 2 -->
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-ghost"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--ink); margin-bottom: 0.75rem;">Spot Phantom Vacancies</h3>
            <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.5; margin: 0;">
                Identify seats held by candidates who are likely to upgrade. Spot these "virtual vacancies" early and target ambitious colleges with confidence.
            </p>
        </div>

        <!-- Feature 3 -->
        <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">
                <i class="fa-solid fa-chess-knight"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--ink); margin-bottom: 0.75rem;">Stray Round Strategy</h3>
            <p style="color: var(--muted); font-size: 0.95rem; line-height: 1.5; margin: 0;">
                Eliminate the offline black box. Map exactly which seats will drop to the stray vacancy round so you can make highly strategic choices.
            </p>
        </div>
        
    </div>

    <!-- Notify Me Section -->
    <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 20px; padding: 3rem 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--ink); margin-bottom: 1rem;">Want early access?</h2>
        <p style="color: var(--muted); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
            We are rolling out Allotment Mapping to premium users first. We'll notify you the moment this feature goes live in your dashboard.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 99px; font-weight: 600; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);">
            Return to Dashboard
        </a>
    </div>

</div>
@endsection
