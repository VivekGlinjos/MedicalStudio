@extends('layouts.app')

@section('title', 'Privacy Policy — Medical Studio')
@section('meta_description', 'Privacy Policy for Medical Studio')

@section('content')
<section class="page-hero" style="padding: 5rem 0 3rem; background: var(--off-white); border-bottom: 1px solid var(--border);">
    <div class="container text-center">
        <h1 class="page-hero-title" style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--ink);">Privacy Policy</h1>
        <p class="body-md" style="color: var(--muted);">Last updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="section" style="padding: 4rem 0;">
    <div class="container" style="max-width: 800px; font-size: 0.95rem; line-height: 1.8; color: var(--muted);">
        
        <h3 style="color: var(--ink); margin-bottom: 1rem;">Our Privacy Policy</h3>
        <p style="margin-bottom: 1.5rem;">We, at <strong>"MEDSTUDIO CAREER SOLUTIONS LLP"</strong> are committed to respecting your online privacy and recognize your need for appropriate protection and management of any "Personal Information" you share with us. Should we ask you to provide certain information by which you can be identified when using our website, mobile site, mobile app etc. (hereinafter ‘Platforms’), then you can be assured that it will only be used in accordance with this privacy statement. By using the Platforms, you indicate that you understand, agree and consent to this Privacy Policy. This Policy is subject to the ‘Terms and Conditions’ of the Platforms.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">The types of Personal Information that we collect and hold</h3>
        <p style="margin-bottom: 1.5rem;">As a visitor, you can browse our platforms to view the content on various exams, details of schools/colleges/institutes without providing any Personal Information. However, we collect personal information about you to provide the services you request, to improve our platforms, and to communicate with you.</p>

        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
            <li style="margin-bottom: 0.5rem;">Contact Information (Name, Email, Phone number, Location)</li>
            <li style="margin-bottom: 0.5rem;">Academic details (Scores, Exam details, Course preferences)</li>
            <li style="margin-bottom: 0.5rem;">Device and usage information</li>
        </ul>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">How we use your Personal Information</h3>
        <p style="margin-bottom: 1.5rem;">We may use the information we collect for various purposes, including:</p>
        <ul style="margin-bottom: 1.5rem; padding-left: 1.5rem;">
            <li style="margin-bottom: 0.5rem;">To personalize your experience on our platform</li>
            <li style="margin-bottom: 0.5rem;">To improve our platform, products, and services</li>
            <li style="margin-bottom: 0.5rem;">To respond to your queries, support requests, and admission guidance</li>
            <li style="margin-bottom: 0.5rem;">To send you promotional messages, updates, and news (which you can opt out of)</li>
        </ul>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">Security</h3>
        <p style="margin-bottom: 1.5rem;">We are committed to ensuring that your information is secure. In order to prevent unauthorized access or disclosure, we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</p>

        <h3 style="color: var(--ink); margin-top: 2rem; margin-bottom: 1rem;">Changes to this Privacy Policy</h3>
        <p style="margin-bottom: 1.5rem;">We may change this policy from time to time by updating this page. You should check this page periodically to ensure that you are happy with any changes.</p>

        <p style="margin-top: 3rem;">If you have any questions or concerns regarding this privacy policy, please contact us at <a href="mailto:info@medicalstudio.in" style="color: var(--teal); text-decoration: underline;">info@medicalstudio.in</a>.</p>

    </div>
</section>
@endsection
