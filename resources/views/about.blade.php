@extends('layouts.app')

@section('title', 'About Medical Studio — Mission, Brand Values & Expert Team')
@section('meta_description', 'Learn about Medical Studio\'s mission to power residency decisions with data-driven precision. Discover our brand pillars, target audience personas, and counselling expertise.')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero" style="position: relative; background-image: url('{{ asset('images/team_office.png') }}'); background-size: cover; background-position: center; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(248,250,252,0.95) 100%); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span class="eyebrow-dim reveal" style="margin-bottom:.75rem;">About Us</span>
        <h1 class="page-hero-title reveal reveal-d1">
            Powering Residency<br>with <span style="color:var(--teal);">Data & Precision</span>
        </h1>
        <p class="page-hero-desc reveal reveal-d2">
            Medical Studio transforms the ambiguity of medical admissions into a science of success — for both NEET-UG (MBBS/BDS) and NEET-PG aspirants, from score to joining letter.
        </p>
    </div>
</section>

{{-- MISSION --}}
<section class="section" style="border-bottom:1px solid var(--border-d);">
    <div class="container">
        <div class="grid-2" style="align-items:center;gap:4rem;">
            <div class="reveal">
                <span class="eyebrow">Our Mission</span>
                <div class="section-title" style="margin-top:.5rem;">
                    Data-Driven Precision.<br><span class="text-teal">Strategic Certainty.</span>
                </div>
                <p style="font-size:.95rem;color:var(--text-dim, #64748b);line-height:1.8;margin-top:1.25rem;margin-bottom:1.5rem;">
                    Medical Studio: Powering Your Residency with Data-Driven Precision and Strategic Certainty. We transform the ambiguity of medical admissions into a science of success.
                </p>
                <p style="color:var(--text-dim, #64748b);line-height:1.8;margin-bottom:1.5rem;font-size:.9rem;">
                    By synthesizing complex MCC regulations and historical allotment trends into high-fidelity intelligence, we ensure every doctor navigates the "maze" with clinical-grade accuracy and the confidence of a seasoned mentor.
                </p>
                <div class="alert alert-info">
                    <i class="fa-solid fa-shield-halved"></i>
                    <div>All communications are cross-verified with official <strong>MCC (mcc.nic.in)</strong> and <strong>NBE sources</strong>. Medical Studio warns users against fraudulent agents — admission is strictly merit-based through the online portal.</div>
                </div>
            </div>

            <div class="reveal reveal-d2">
                <div class="grid-2" style="gap:1px;background:var(--border-d);">
                    @php
                    $metrics = [
                        ['5,000+', 'Successful Allotments', 'fa-trophy'],
                        ['98.7%',  'Prediction Accuracy',   'fa-bullseye'],
                        ['24/7',   'Expert Support Hours',  'fa-headset'],
                        ['1,892',  'Institutes Monitored',  'fa-hospital'],
                    ];
                    @endphp
                    @foreach($metrics as $m)
                    <div style="background:var(--bg, #ffffff);padding:2rem;text-align:center;">
                        <div style="width:48px;height:48px;background:var(--teal-dim);border:1px solid rgba(13,148,136,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;border-radius:50%;">
                            <i class="fa-solid {{ $m[2] }}" style="color:var(--teal);font-size:1rem;"></i>
                        </div>
                        <div style="font-family:var(--font-display);font-size:2.5rem;color:var(--text-main, #0f172a);line-height:1;margin-bottom:.35rem;">{{ $m[0] }}</div>
                        <div style="font-size:.7rem;color:var(--text-dim, #64748b);text-transform:uppercase;letter-spacing:.08em;">{{ $m[1] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BRAND PILLARS --}}
<section class="section" style="border-bottom:1px solid var(--border-d);">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow-dim reveal">Brand Pillars</span>
            <div class="section-title reveal reveal-d1">Our Tone &<br><span class="text-teal">Voice Guidelines</span></div>
        </div>

        <div class="reservation-table-wrap reveal" style="max-width:960px;margin:0 auto;">
            <table class="ms-table">
                <thead>
                    <tr>
                        <th>Brand Pillar</th>
                        <th>Definition</th>
                        <th style="color:#059669;">✓ We Say</th>
                        <th style="color:#dc2626;">✗ We Never Say</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $pillars = [
                        ['Authoritative','Ultimate source for MCC/NBE clarity','"Per the Hon\'ble Supreme Court ruling..."','"We believe rules might change soon..."'],
                        ['Reliable','Fact-checked, cross-verified data streams','"Cross-verified with 3200-point roster data."','"Rumors suggest a rank shift..."'],
                        ['Empathetic','Reassuring during peak stress','"We guide every critical If/Then scenario."','"Just follow the flowchart instructions."'],
                        ['Analytical','Decisions rooted in trends, not luck','"Strategy based on 100% accurate Allotment Map."','"Try your luck in the Stray Round."'],
                        ['Transparent','Zero tolerance for misinformation','"Merit is the only gateway; direct entry does not exist."','"Guaranteed seats in top-tier colleges."'],
                    ];
                    @endphp
                    @foreach($pillars as $p)
                    <tr>
                        <td><span class="badge badge-teal">{{ $p[0] }}</span></td>
                        <td style="font-size:.875rem;">{{ $p[1] }}</td>
                        <td style="font-size:.8rem;color:#059669;font-weight:500;font-style:italic;">{{ $p[2] }}</td>
                        <td style="font-size:.8rem;color:#dc2626;font-weight:500;font-style:italic;">{{ $p[3] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- TARGET AUDIENCE --}}
<section class="section" style="border-bottom:1px solid var(--border-d);">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow-dim reveal">Who We Serve</span>
            <div class="section-title reveal reveal-d1">Our Three<br><span class="text-teal">Candidate Personas</span></div>
        </div>

        <div class="grid-3">
            @php
            $personas = [
                ['fa-crosshairs','The High-Rank Strategist','High achievers chasing competitive clinical branches — Radio-Diagnosis, Dermatology, Ophthalmology. They require surgical precision in closing rank data to avoid losing a "dream seat" to minor rank inflation of even 50 ranks.',['Radio-Diagnosis','Dermatology','Ophthalmology'],'badge-teal'],
                ['fa-scale-balanced','The Mid-Rank Optimizer','Candidates balancing branch preference against college quality and high fees. They rely on "Value Prediction" to find the best possible institute across AIQ, DNB, and State quotas.',['AIQ Balance','DNB Options','State Quota'],'badge-yellow'],
                ['fa-passport','The NRI/OCI Applicant','Global applicants navigating complex documentation hurdles — Family Tree certificates, NRE accounts, Sponsorship status. They need absolute legal clarity on eligibility.',['OCI Eligible','NRI Quota','Legal Clarity'],'badge-blue'],
            ];
            @endphp
            @foreach($personas as $i => $p)
            <div class="card-feature reveal reveal-delay-{{ $i+1 }}" style="padding:2rem;">
                <div class="icon-circle"><i class="fa-solid {{ $p[0] }}"></i></div>
                <h4>{{ $p[1] }}</h4>
                <p>{{ $p[2] }}</p>
                <div style="margin-top:1rem;display:flex;flex-wrap:wrap;gap:.5rem;">
                    @foreach($p[3] as $tag)<span class="badge {{ $p[4] }}">{{ $tag }}</span>@endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ABBREVIATIONS --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="eyebrow-dim reveal">Technical Reference</span>
            <div class="section-title reveal reveal-d1">Abbreviation<br><span class="text-teal">Quick Reference</span></div>
        </div>
        <div class="reservation-table-wrap reveal" style="max-width:800px;margin:0 auto;">
            <table class="ms-table">
                <thead><tr><th>Abbreviation</th><th>Full Form</th></tr></thead>
                <tbody>
                    @php
                    $abbr=[['ABVIMS','Atal Bihari Vajpayee Institute of Medical Sciences'],['AIQ','All India Quota'],['AMU','Aligarh Muslim University'],['BHU','Banaras Hindu University'],['DGHS','Directorate General of Health Services'],['DU','Delhi University'],['EWS','Economically Weaker Section'],['MCC','Medical Counseling Committee'],['MCI','Medical Council of India'],['MoHFW','Ministry of Health & Family Welfare'],['NBE','National Board of Examination'],['NEET','National Eligibility-cum-Entrance Test'],['NMC','National Medical Commission'],['OBC','Other Backward Class'],['PG','Post Graduate'],['PwD','Persons with Benchmark Disabilities'],['RML','Ram Manohar Lohia'],['SC','Scheduled Caste'],['SJH','Safdarjung Hospital'],['ST','Scheduled Tribe'],['UR','Unreserved Category'],['VMMC','Vardhaman Mahavir Medical College']];
                    @endphp
                    @foreach($abbr as $a)
                    <tr>
                        <td><strong style="color:var(--teal);">{{ $a[0] }}</strong></td>
                        <td>{{ $a[1] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
