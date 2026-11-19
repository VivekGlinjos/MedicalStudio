@extends('layouts.app')

@section('title', 'Refund Policy — Medical Studio')
@section('meta_description', 'Refund Policy for Medical Studio')

@section('content')
<section class="page-hero" style="padding: 5rem 0 3rem; background: var(--off-white); border-bottom: 1px solid var(--border);">
    <div class="container text-center">
        <h1 class="page-hero-title" style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--ink);">Refund Policy</h1>
        <p class="body-md" style="color: var(--muted);">Last updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="section" style="padding: 4rem 0;">
    <div class="container" style="max-width: 800px; font-size: 0.95rem; line-height: 1.8; color: var(--muted);">
        
        <h3 style="color: var(--ink); margin-bottom: 1rem;">Cancellation & Refund Policy</h3>
        <p style="margin-bottom: 1.5rem;">For all packages and consulting services offered by MEDSTUDIO CAREER SOLUTIONS LLP ("Medical Studio"):</p>

        <p style="margin-bottom: 1.5rem;">1. Please carefully review your chosen service/package before making the payment. Once the payment has been processed and your account or service has been activated, we are unable to process any refunds.</p>

        <p style="margin-bottom: 1.5rem;">2. Our services, which involve real-time data access, personal counselling sessions, and digital admission tools, are considered "used" the moment they are provisioned to your account. Therefore, under no circumstances will the service fee be refunded.</p>

        <p style="margin-bottom: 1.5rem;">3. In the event of a double payment or technical failure during checkout where your account was debited multiple times for a single package, please contact our support team within 48 hours of the transaction. Such cases will be reviewed and if validated, the excess amount will be refunded to the original payment method within 7-10 working days.</p>

        <p style="margin-bottom: 1.5rem;">4. We reserve the right to cancel any consultation or service package at our sole discretion. In such rare instances where the cancellation is initiated by us without any fault or violation of terms from the user, a full refund will be processed.</p>

        <p style="margin-top: 3rem;">If you have any payment-related queries, please contact us at <a href="mailto:info@medicalstudio.in" style="color: var(--teal); text-decoration: underline;">info@medicalstudio.in</a>.</p>

    </div>
</section>
@endsection
