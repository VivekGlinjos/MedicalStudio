@extends('layouts.app')

@section('title', 'Expert Hands-On Services — Registration, Documentation & NRI/OCI Support | Medical Studio')
@section('meta_description', 'Expert NEET-PG counselling services: Error-free MCC registration, document verification, NRI/OCI support, PwD certification, and pre-reporting audit by Medical Studio experts.')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero">
    <div class="container">
        <span class="section-eyebrow section-eyebrow-dark">Expert Services</span>
        <h1 class="page-hero-title">The Human Touch</h1>
        <p class="page-hero-desc">Technology is powerful. But when it comes to your career, you also need an expert in your corner. Our concierge team handles every detail so you never miss a step.</p>
    </div>
</section>

{{-- ============================================================
     EXPERT REGISTRATION SUPPORT + DOCUMENT CONCIERGE
     ============================================================ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Hands-On Expert Services</span>
            <h2 class="section-title">Your Personal<br><span class="text-red">Counselling Concierge</span></h2>
        </div>

        <div class="grid-2">
            <div class="card-feature reveal reveal-delay-1" style="padding:2rem;">
                <div class="icon-circle"><i class="fa-solid fa-user-check"></i></div>
                <h3 style="margin-bottom:1rem;">Expert Registration Support</h3>
                <p style="margin-bottom:1.5rem;color:var(--color-body);">
                    We oversee your MCC and Deemed University portal entries to ensure all data is factual and self-certified. Preventing elimination from the allotment process before it begins.
                </p>
                <div class="check-list">
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Error-Free Submissions</h4>
                            <p>Step-by-step MCC portal guidance ensuring data accuracy at every field.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Debarment Prevention</h4>
                            <p>Prevent duplicate registrations or incorrect entries that lead to immediate elimination from the allotment process.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Pre-Lock Review</h4>
                            <p>Comprehensive choice list review before final submission — choices once locked cannot be modified.</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" style="margin-top:1.5rem;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div><strong>Critical:</strong> Choices once locked cannot be modified. One typo can cost you your dream branch permanently.</div>
                </div>
            </div>

            <div class="card-feature reveal reveal-delay-2" style="padding:2rem;">
                <div class="icon-circle"><i class="fa-solid fa-file-shield"></i></div>
                <h3 style="margin-bottom:1rem;">Document &amp; Verification Concierge</h3>
                <p style="margin-bottom:1.5rem;color:var(--color-body);">
                    Zero-rejection review. Manual certificate verification against MCC proformas (Annexure 3-5) to ensure you aren't rejected at the college gate on reporting day.
                </p>
                <div class="check-list">
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Specialized Status Support</h4>
                            <p>Expert guidance for complex NRI/OCI documentation, category conversions (ST/SC/OBC/EWS), and Minority quota navigation.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>PwD Certification Support</h4>
                            <p>End-to-end support for obtaining online disability certificates from designated MCC centers per NMC norms.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Pre-Reporting Audit</h4>
                            <p>Manual verification of SC/ST/OBC/EWS/PwD certificates against MCC proformas before you step into the college.</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning" style="margin-top:1.5rem;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div><strong>Warning:</strong> Failure to produce valid Annexure 3-5 documents at the time of admission results in immediate seat cancellation and forfeiture of all fees.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     NRI / OCI DOCUMENTATION
     ============================================================ --}}
<section id="nri-oci" class="section section-bg">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">NRI / OCI Support</span>
            <h2 class="section-title">NRI &amp; OCI<br><span class="text-red">Documentation Guide</span></h2>
            <p class="section-desc">Based on Chapter 4.1 of the MCC Bulletin — ensure these documents are ready for status conversion and counselling participation.</p>
        </div>

        <div class="grid-2" style="align-items:start;gap:3rem;">
            <div class="reveal">
                <div class="card" style="border:none;">
                    <h3 style="font-size:1.1rem;margin-bottom:1.5rem;">
                        <i class="fa-solid fa-folder-open" style="color:var(--color-red);margin-right:0.5rem;"></i>
                        Required Documents Checklist
                    </h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        @php
                        $docs = [
                            ['NEET-PG Admit Card & Score Card', 'fa-file-alt', 'Mandatory'],
                            ['Passport & Visa of Sponsor', 'fa-passport', 'Valid Passport, Visa/Residence/Work Permit'],
                            ['NRI Certificate (Sponsorship Status)', 'fa-certificate', 'Issued by Embassy/Indian Consulate'],
                            ['Family Tree Certificate', 'fa-sitemap', 'Issued by Revenue Authority — proves relationship'],
                            ['NRE Bank Account Pass Book', 'fa-piggy-bank', 'Non-Resident External Account'],
                            ['OCI Card / PIO Card', 'fa-id-card', 'If applicable'],
                            ['10th & 12th Marksheets + Certificates', 'fa-graduation-cap', 'Both Board Marksheets and Passing Certificate'],
                        ];
                        @endphp
                        @foreach($docs as $i => $doc)
                        <div style="display:flex;align-items:flex-start;gap:1rem;padding:0.75rem;background:var(--color-bg-soft);border-radius:var(--radius-md);">
                            <div style="width:32px;height:32px;border-radius:50%;background:var(--color-red-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa-solid {{ $doc[1] }}" style="color:var(--color-red);font-size:0.8rem;"></i>
                            </div>
                            <div>
                                <div style="font-family:var(--font-heading);font-weight:600;font-size:0.9rem;color:var(--color-heading);">{{ $i+1 }}. {{ $doc[0] }}</div>
                                <div style="font-size:0.8rem;color:var(--color-body);margin-top:2px;">{{ $doc[2] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="card" style="border:none;margin-bottom:1.5rem;">
                    <h3 style="font-size:1.1rem;margin-bottom:1rem;">
                        <i class="fa-solid fa-gavel" style="color:var(--color-red);margin-right:0.5rem;"></i>
                        OCI Eligibility — Supreme Court Ruling
                    </h3>
                    <p style="font-size:0.9rem;color:var(--color-body);margin-bottom:1.25rem;line-height:1.7;">
                        <strong>The "Anushka Rengunthwar" Ruling</strong> — Per the Supreme Court order dated <strong>03.02.2023</strong>:
                    </p>
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div style="background:#F0FDF4;border:1px solid #86EFAC;border-radius:var(--radius-md);padding:1rem;">
                            <div style="font-weight:700;color:#15803D;margin-bottom:0.25rem;">
                                <i class="fa-solid fa-circle-check" style="margin-right:0.5rem;"></i>
                                OCI Status BEFORE 04.03.2021
                            </div>
                            <p style="font-size:0.85rem;color:#14532D;line-height:1.6;">Treated at par with Indian citizens. Eligible for <strong>UR (General) seats AND NRI seats</strong> for the 2026 cycle.</p>
                        </div>
                        <div style="background:#FEF9C3;border:1px solid #FDE047;border-radius:var(--radius-md);padding:1rem;">
                            <div style="font-weight:700;color:#A16207;margin-bottom:0.25rem;">
                                <i class="fa-solid fa-triangle-exclamation" style="margin-right:0.5rem;"></i>
                                OCI Status AFTER 04.03.2021
                            </div>
                            <p style="font-size:0.85rem;color:#78350F;line-height:1.6;">Restricted to <strong>NRI seats only</strong> — not eligible for UR (General) category seats.</p>
                        </div>
                    </div>
                </div>

                <div class="card" style="border:none;">
                    <h3 style="font-size:1.1rem;margin-bottom:1rem;">
                        <i class="fa-solid fa-place-of-worship" style="color:var(--color-red);margin-right:0.5rem;"></i>
                        Minority Reservations
                    </h3>
                    <p style="font-size:0.9rem;color:var(--color-body);margin-bottom:1rem;line-height:1.7;">
                        We provide dedicated data for <strong>Jain</strong> and <strong>Muslim Minority quotas</strong> in Deemed Universities.
                    </p>
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <div><strong>Important:</strong> You cannot claim both Minority and NRI status simultaneously. Choose the quota that optimizes your rank advantage.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     PWD CERTIFICATION
     ============================================================ --}}
<section class="section">
    <div class="container">
        <div class="grid-2" style="align-items:center;gap:4rem;">
            <div class="reveal">
                <span class="section-eyebrow">PwD Certification</span>
                <h2 class="section-title">Online Disability<br><span class="text-red">Certificate Guide</span></h2>
                <p style="margin-bottom:1.5rem;color:var(--color-body);line-height:1.8;">
                    PwD candidates must obtain certificates from designated MCC centres via the online mode only. Medical Studio provides end-to-end support for this process as per NMC norms.
                </p>
                <div class="alert alert-danger" style="margin-bottom:1.5rem;">
                    <i class="fa-solid fa-ban"></i>
                    <div>
                        <strong>Critical Note:</strong> Only certificates generated through the MCC portal are valid. Physical/offline certificates will be rejected at the reporting stage without exception.
                    </div>
                </div>
                <div class="check-list">
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Designated MCC Centres</h4>
                            <p>VMMC, Safdarjung Hospital (SJH), ABVIMS &amp; RML, and other NMC-approved centers.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>5% Horizontal Reservation</h4>
                            <p>Applied horizontally across all categories — UR, SC, ST, OBC, EWS.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>End-to-End Support</h4>
                            <p>We guide you through the online portal appointment, documentation requirements, and certificate validation timeline.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="card" style="border:none;background:var(--color-bg-soft);">
                    <h3 style="font-size:1.1rem;margin-bottom:1.5rem;">Reservation Reference Table</h3>
                    <div class="reservation-table-wrap">
                        <table class="ms-table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Reservation %</th>
                                    <th>Certificate Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-navy">SC</span></td>
                                    <td style="font-weight:700;color:var(--color-red);">15%</td>
                                    <td style="font-size:0.85rem;">Central SC Certificate</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-navy">ST</span></td>
                                    <td style="font-weight:700;color:var(--color-red);">7.5%</td>
                                    <td style="font-size:0.85rem;">Central ST Certificate</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-navy">OBC-NCL</span></td>
                                    <td style="font-weight:700;color:var(--color-red);">27%</td>
                                    <td style="font-size:0.85rem;">Central OBC (Non-Creamy Layer)</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-navy">EWS</span></td>
                                    <td style="font-weight:700;color:var(--color-red);">10%</td>
                                    <td style="font-size:0.85rem;">Govt. Income &amp; Asset Certificate</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-navy">PwD</span></td>
                                    <td style="font-weight:700;color:var(--color-red);">5% (H)</td>
                                    <td style="font-size:0.85rem;">MCC Online Portal Certificate</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p style="font-size:0.8rem;color:var(--color-body);margin-top:1rem;">(H) = Horizontal reservation applied across all categories.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BOND-STIPEND TRACKER --}}
<section class="section section-bg">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Institutional Intelligence</span>
            <h2 class="section-title">Bond-Stipend Tracker &<br><span class="text-red">Clinical Constraints</span></h2>
            <p class="section-desc">While the MCC bulletin takes no responsibility for fee errors (Chapter 2.9), Medical Studio cross-references institutional websites and state DME circulars for guaranteed accuracy.</p>
        </div>

        <div class="grid-3">
            <div class="card reveal reveal-delay-1">
                <div class="icon-circle"><i class="fa-solid fa-coins"></i></div>
                <h4>Annual Fee Structure</h4>
                <p>Full breakdown of Government vs. Management/NRI fees. Avoid financial surprises that derail your counselling strategy.</p>
            </div>
            <div class="card reveal reveal-delay-2">
                <div class="icon-circle"><i class="fa-solid fa-money-bill-wave"></i></div>
                <h4>Monthly Stipend Details</h4>
                <p>Real-time remuneration figures for the stipend provided during your residency — institute by institute, branch by branch.</p>
            </div>
            <div class="card reveal reveal-delay-3">
                <div class="icon-circle"><i class="fa-solid fa-link"></i></div>
                <h4>Compulsory Bond Years</h4>
                <p>Clear data on rural, tribal, or clinical service bond years and exact penalty amounts. Penalty Calculator shows your financial liability.</p>
            </div>
            <div class="card reveal reveal-delay-1">
                <div class="icon-circle"><i class="fa-solid fa-hospital"></i></div>
                <h4>Bed Count & Infrastructure</h4>
                <p>Transparency on hospital size, specialty constraints, and clinical exposure quality. Judge the "learning value" of each institute.</p>
            </div>
            <div class="card reveal reveal-delay-2">
                <div class="icon-circle"><i class="fa-solid fa-chart-bar"></i></div>
                <h4>Historical Ranks</h4>
                <p>Detailed opening and closing rank trends from previous years for every clinical and non-clinical branch across all institutes.</p>
            </div>
            <div class="card reveal reveal-delay-3">
                <div class="icon-circle"><i class="fa-solid fa-stethoscope"></i></div>
                <h4>Clinical Constraints</h4>
                <p>Access data on Case Load, specialty-specific constraints (e.g., lack of specific MRI/CT facilities) and rural service flags.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="container" style="position:relative;z-index:1;">
        <h2 class="cta-banner-title">Ready for Zero-Rejection Support?</h2>
        <p class="cta-banner-desc">Book a personal expert today. Our team handles every detail — from registration to joining — so you can focus on what matters.</p>
        <a href="{{ route('contact') }}" class="btn btn-lg btn-rounded" style="background:#ffffff;color:var(--color-red);font-weight:700;">
            <i class="fa-solid fa-calendar-check"></i>
            Book a Personal Consultant
        </a>
    </div>
</section>

@endsection
