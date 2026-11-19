@extends('layouts.app')

@section('title', 'Terms & Conditions — Medical Studio')
@section('meta_description', 'Terms & Conditions for Medical Studio')

@section('content')
<section class="page-hero" style="padding: 5rem 0 3rem; background: var(--off-white); border-bottom: 1px solid var(--border);">
    <div class="container text-center">
        <h1 class="page-hero-title" style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--ink);">Terms & Conditions</h1>
        <p class="body-md" style="color: var(--muted);">Last updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="section" style="padding: 4rem 0;">
    <div class="container" style="max-width: 800px; font-size: 0.95rem; line-height: 1.8; color: var(--muted);">
        
        <h3 style="color: var(--ink); margin-bottom: 1rem;">Terms and Conditions</h3>
        <p style="margin-bottom: 1.5rem;">Welcome to Medical Studio. These Terms and Conditions outline the rules and regulations for the use of MEDSTUDIO CAREER SOLUTIONS LLP's Website and Platforms.</p>

        <p style="margin-bottom: 1.5rem;">By accessing this website we assume you accept these terms and conditions. Do not continue to use Medical Studio if you do not agree to take all of the terms and conditions stated on this page.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">1. Services Overview</h3>
        <p style="margin-bottom: 1.5rem;">Medical Studio provides data-driven admissions counselling, predictive tools, and guidance for medical aspirants across India. While we strive to provide the most accurate predictions and information based on historical data and current seat matrices, our predictions do not guarantee admission. Admissions depend on various dynamic factors and authorities' decisions.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">2. User Responsibilities</h3>
        <p style="margin-bottom: 1.5rem;">You must provide accurate and complete information when utilizing our services or communicating with our counsellors. The misuse of our platform, including automated scraping of our data, is strictly prohibited.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">3. Intellectual Property Rights</h3>
        <p style="margin-bottom: 1.5rem;">Other than the content you own, under these Terms, MEDSTUDIO CAREER SOLUTIONS LLP and/or its licensors own all the intellectual property rights and materials contained in this Website.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">4. Limitation of Liability</h3>
        <p style="margin-bottom: 1.5rem;">In no event shall MEDSTUDIO CAREER SOLUTIONS LLP, nor any of its officers, directors, and employees, be held liable for anything arising out of or in any way connected with your use of this Website or the outcome of your medical admission process.</p>

        <p style="margin-top: 3rem;">If you have any questions or concerns regarding our terms and conditions, please contact us at <a href="mailto:info@medicalstudio.in" style="color: var(--teal); text-decoration: underline;">info@medicalstudio.in</a>.</p>

    </div>
</section>
@endsection
