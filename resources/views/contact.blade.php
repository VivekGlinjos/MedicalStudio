@extends('layouts.app')

@section('title', 'Contact Medical Studio — Book a NEET-PG Counselling Consultant')
@section('meta_description', 'Contact Medical Studio to book a personal NEET-PG counselling expert. Get data-driven guidance for rank strategy, document verification, and choice list building.')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero" style="position: relative; background-image: url('{{ asset('images/expert_counsellor.png') }}'); background-size: cover; background-position: center; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(248,250,252,0.95) 100%); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span class="eyebrow-dim reveal">Book Your Consultation</span>
        <h1 class="page-hero-title reveal reveal-d1">
            Talk to an<br><span style="color:var(--teal);">Expert Today</span>
        </h1>
        <p class="page-hero-desc reveal reveal-d2">
            Our Admissions counselling specialists are ready. Tell us your situation, and we'll guide you through every step.
        </p>
    </div>
</section>

<section class="section" style="border-top:1px solid var(--border-d);">
    <div class="container">
        <div class="contact-section">

            {{-- CONTACT INFO --}}
            <div class="contact-left reveal">
                <span class="eyebrow">How to Reach Us</span>
                <div class="section-title" style="margin-top:.5rem;">
                    Let's Build Your<br><span class="text-teal">Admission Strategy</span>
                </div>
                <p style="color:var(--text-dim, #64748b);font-size:.9rem;line-height:1.8;margin-top:1rem;max-width:340px;">
                    Fill in your details and our expert will contact you within 24 hours — no cost, no obligation.
                </p>

                <div style="margin-top:2.5rem;display:flex;flex-direction:column;gap:1.25rem;">
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:42px;height:42px;background:var(--teal-dim);border:1px solid rgba(13,148,136,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-phone" style="color:var(--teal);font-size:.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:var(--text-dim, #94a3b8);font-weight:600;margin-bottom:.2rem;">Phone / WhatsApp</div>
                            <a href="tel:+919747500002" style="font-weight:700;color:var(--text-main, #0f172a);" class="hover-underline">+91 97475 00002 / +91 97475 00003</a>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:42px;height:42px;background:var(--teal-dim);border:1px solid rgba(13,148,136,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-envelope" style="color:var(--teal);font-size:.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:var(--text-dim, #94a3b8);font-weight:600;margin-bottom:.2rem;">Email</div>
                            <a href="mailto:info@medicalstudio.in" style="font-weight:700;color:var(--text-main, #0f172a);" class="hover-underline">info@medicalstudio.in</a>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:42px;height:42px;background:var(--teal-dim);border:1px solid rgba(13,148,136,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-brands fa-whatsapp" style="color:var(--teal);font-size:.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:.62rem;text-transform:uppercase;letter-spacing:.12em;color:var(--text-dim, #94a3b8);font-weight:600;margin-bottom:.2rem;">WhatsApp Direct</div>
                            <a href="https://wa.me/919747500002?text=Hello%2C%20I%20need%20guidance%20for%20NEET-PG%20counselling." target="_blank" style="font-weight:700;color:var(--teal);">Chat on WhatsApp →</a>
                        </div>
                    </div>
                </div>

                <div style="margin-top:2rem;border:1px solid var(--border-d);padding:1.5rem;">
                    <div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.12em;color:var(--text-dim, #94a3b8);font-weight:700;margin-bottom:1rem;">What Happens Next?</div>
                    @foreach(['Our expert reviews your rank, category, and preferences.','We call/WhatsApp you within 24 hours with a personalised strategy.','We guide you through every round — from registration to joining.'] as $i => $step)
                    <div style="display:flex;align-items:flex-start;gap:.75rem;margin-bottom:.75rem;">
                        <div style="width:24px;height:24px;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;border-radius:50%;">{{ $i+1 }}</div>
                        <p style="font-size:.85rem;color:var(--text-dim, #64748b);line-height:1.65;">{{ $step }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="alert alert-warning" style="margin-top:1.5rem;">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div><strong>Authenticity Disclaimer:</strong> Medical Studio warns users against fraudulent agents. Admission is strictly merit-based through the online MCC portal. We provide data and strategy — not "guaranteed seats."</div>
                </div>
            </div>

            {{-- CONTACT FORM --}}
            <div class="contact-right reveal reveal-d2">
                @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:1.5rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                <div style="background:var(--bg-soft, #f8fafc);border:1px solid var(--border, #e2e8f0);padding:2.5rem;border-radius:12px;">
                    <div style="font-family:var(--font-heading);font-size:1.1rem;font-weight:800;color:var(--text-main, #0f172a);margin-bottom:1.5rem;">Book a Personal Consultant</div>
                    <form action="{{ route('contact.submit') }}" method="POST" style="display:flex;flex-direction:column;">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-input" placeholder="Dr. / Candidate Name" value="{{ old('name') }}" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="course">Target Branch / Course</label>
                            <input type="text" id="course" name="course" class="form-input" placeholder="e.g. MBBS, BDS, MD Radiology, MS Surgery" value="{{ old('course') }}">
                            @error('course') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone / WhatsApp Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="+91 XXXXX XXXXX" value="{{ old('phone') }}" required maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                            @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message">Your Situation / Query</label>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Tell us your NEET rank, category, preferred states and courses.">{{ old('message') }}</textarea>
                            @error('message') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-teal btn-lg" style="margin-top:1.25rem;border-radius:0;justify-content:center;">
                            <i class="fa-solid fa-paper-plane"></i> Request Callback Now
                        </button>
                        <p style="font-size:.75rem;color:var(--text-dim, #94a3b8);margin-top:.75rem;text-align:center;">
                            <i class="fa-solid fa-lock" style="color:var(--teal);"></i>
                            Your information is 100% private. We never spam or share your data.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
