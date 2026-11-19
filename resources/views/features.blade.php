@extends('layouts.app')

@section('title', 'Advanced Analytics Tools — Rank Scan, Allotment Mapping, Seat Matrix | Medical Studio')
@section('meta_description', 'Explore Medical Studio\'s advanced analytics: Rank Scan prediction engine, Allotment Mapping, Seat Matrix dashboard, and Choice List Builder for NEET-PG counselling.')

@section('content')

{{-- PAGE HERO --}}
<section class="page-hero" style="position: relative; background-image: url('{{ asset('images/expert_data_analyst.png') }}'); background-size: cover; background-position: center; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(248,250,252,0.95) 100%); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span class="section-eyebrow section-eyebrow-dark">Advanced Analytics</span>
        <h1 class="page-hero-title">Intelligence Suite</h1>
        <p class="page-hero-desc">Clinical-grade data tools that transform counselling complexity into strategic certainty. Your edge in the NEET-PG maze.</p>
    </div>
</section>

{{-- ============================================================
     RANK SCAN
     ============================================================ --}}
<section id="rank-scan" class="section">
    <div class="container">
        <div class="grid-2" style="align-items:center;gap:4rem;">
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                    <div class="icon-circle"><i class="fa-solid fa-chart-line"></i></div>
                    <div>
                        <span class="section-eyebrow" style="margin:0;display:block;">Tool 01</span>
                        <h2 style="font-size:2rem;margin:0;">Rank Scan & Prediction Engine</h2>
                    </div>
                </div>
                <p style="margin-bottom:1.5rem;color:var(--color-body);line-height:1.8;">
                    The Medical Studio Rank Scan is a clinical-grade prediction engine. It utilizes exhaustive historical data from the 3200-point roster to forecast your admission probability across 50% AIQ, 100% Deemed Universities, and State quotas. We don't just show numbers — we show your future.
                </p>

                <div class="check-list" style="margin-bottom:2rem;">
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Identify 'Negative Shifts' Early</h4>
                            <p>Spot rank inflation patterns before they derail your strategy, ensuring you don't lose your security deposit in Round 2.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Targeted Probability Analysis</h4>
                            <p>Filter by 40+ state and central categories (GEN, OBC, SC, ST, EWS, EZ, MU, LA, etc.) and state quota to see exactly where your merit meets opportunity.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Comprehensive All-India Coverage</h4>
                            <p>Full scope: MD, MS, DNB, NEET-PG, NEET-UG, NEET-SS, and NEET-MDS across all quotas.</p>
                        </div>
                    </div>
                </div>

                <div style="background:var(--color-bg-soft);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:1.5rem;">
                    <h4 style="margin-bottom:1rem;">Strategic Advice: How to Interpret Results</h4>
                    <ol style="padding-left:1.5rem;display:flex;flex-direction:column;gap:0.5rem;">
                        <li style="color:var(--color-body);font-size:0.9rem;line-height:1.7;"><strong>Verify the Inflation:</strong> Compare this year's "Safe" ranks against last year's trends to identify rank-shift patterns.</li>
                        <li style="color:var(--color-body);font-size:0.9rem;line-height:1.7;"><strong>Categorize Your List:</strong> Group results into "Safe," "Moderate," and "Ambitious" to build a balanced choice list.</li>
                        <li style="color:var(--color-body);font-size:0.9rem;line-height:1.7;"><strong>Check Virtual Vacancies:</strong> Use with Allotment Mapping to see if "Ambitious" targets might open in Round 2.</li>
                    </ol>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="card" style="border:none;background:var(--color-bg-soft);">
                    <h3 style="margin-bottom:1.5rem;font-size:1.1rem;">Result Interpretation System</h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.5rem;">
                        <div class="alert alert-success">
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>High Probability</strong><br>
                                <span style="font-size:0.85rem;">This seat was historically allotted within your rank range. Safe to prioritize.</span>
                            </div>
                        </div>
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>
                                <strong>Ambitious Choice</strong><br>
                                <span style="font-size:0.85rem;">Historically, this branch closes above your rank. Consider as an 'Upgradation' target.</span>
                            </div>
                        </div>
                        <div class="alert" style="background:var(--color-bg-soft);border-left:4px solid #9CA3AF;color:var(--color-body);">
                            <i class="fa-solid fa-circle-info" style="color:#6B7280;margin-top:2px;flex-shrink:0;"></i>
                            <div>
                                <strong>No Matches Found</strong><br>
                                <span style="font-size:0.85rem;">Try expanding your 'State Preference' to see broader opportunities.</span>
                            </div>
                        </div>
                    </div>
                    <hr class="divider">
                    <h4 style="font-size:1rem;margin-bottom:1rem;">Strategic Filters Available</h4>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--color-body);">
                            <i class="fa-solid fa-filter" style="color:var(--color-red);font-size:0.8rem;"></i>
                            All India Rank (AIR)
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--color-body);">
                            <i class="fa-solid fa-filter" style="color:var(--color-red);font-size:0.8rem;"></i>
                            Category Selection
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--color-body);">
                            <i class="fa-solid fa-filter" style="color:var(--color-red);font-size:0.8rem;"></i>
                            State Preference
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--color-body);">
                            <i class="fa-solid fa-filter" style="color:var(--color-red);font-size:0.8rem;"></i>
                            Branch Specialization
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     ALLOTMENT MAPPING
     ============================================================ --}}
<section id="allotment-mapping" class="section section-bg">
    <div class="container">
        <div class="grid-2" style="align-items:start;gap:4rem;">
            <div class="card reveal" style="border:none;">
                <h3 style="margin-bottom:1.5rem;">Vacancy Intelligence Dashboard</h3>
                <div style="display:flex;flex-direction:column;gap:1.5rem;margin-bottom:1.5rem;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                            <h4 style="font-size:1rem;">Clear-Cut Vacancies</h4>
                            <span class="badge badge-green">AVAILABLE</span>
                        </div>
                        <p style="font-size:0.9rem;color:var(--color-body);">Verified seats that remain unallotted from previous rounds. Immediately accessible based on merit rank.</p>
                    </div>
                    <hr class="divider" style="margin:0;">
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                            <h4 style="font-size:1rem;">Virtual Vacancies</h4>
                            <span class="badge badge-yellow">POTENTIAL</span>
                        </div>
                        <p style="font-size:0.9rem;color:var(--color-body);">Seats occupied by candidates who opted for Upgradation. Only become available if the current holder moves to a higher preference.</p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fa-solid fa-lightbulb"></i>
                        <div><strong>Pro Tip:</strong> Virtual vacancies are your secret weapon in Round 2. They represent the potential 'Rank Shift' that static PDFs cannot show.</div>
                    </div>
                </div>
                <h4 style="font-size:1rem;margin-bottom:1rem;">Sample Data Preview</h4>
                <div class="reservation-table-wrap">
                    <table class="ms-table">
                        <thead>
                            <tr><th>Institute</th><th>Course</th><th>Type</th><th>Seats</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight:600;">VMMC, Delhi</td>
                                <td>MD Gen Med</td>
                                <td><span class="badge badge-green">Clear-cut</span></td>
                                <td style="font-weight:700;">02</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600;">BHU, Varanasi</td>
                                <td>MS Ortho</td>
                                <td><span class="badge badge-yellow">Virtual</span></td>
                                <td style="font-weight:700;">04</td>
                            </tr>
                            <tr>
                                <td style="font-weight:600;">AMU, Aligarh</td>
                                <td>MD Paeds</td>
                                <td><span class="badge badge-yellow">Virtual</span></td>
                                <td style="font-weight:700;">02</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                    <div class="icon-circle"><i class="fa-solid fa-map"></i></div>
                    <div>
                        <span class="section-eyebrow" style="margin:0;display:block;">Tool 02</span>
                        <h2 style="font-size:2rem;margin:0;">Allotment Mapping &amp; Analytics</h2>
                    </div>
                </div>
                <p style="margin-bottom:1.5rem;color:var(--color-body);line-height:1.8;">
                    Our Allotment Mapping system provides a real-time window into the competition. It tracks "who joined where," revealing actual candidate movements. Per the Dar-us Slam ruling, we help you navigate the now-mandatory Online Stray Vacancy Round, eliminating the "black box" of offline seat management.
                </p>

                <div class="check-list" style="margin-bottom:2rem;">
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Spot Phantom Opportunities</h4>
                            <p>Identify seats held by candidates who opted for upgradation and predict likelihood of opening during Round 2 to Round 3 shift.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Conversion Intelligence</h4>
                            <p>Leverage Round 3 conversion algorithm (ST to SC, SC to UR) to find seats that others overlook entirely.</p>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon"><i class="fa-solid fa-check"></i></div>
                        <div class="check-text">
                            <h4>Miracle Allotments in Stray Rounds</h4>
                            <p>Secure unexpected seats in Online Stray Rounds when the process moves online — data is king, and others are guessing.</p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fa-solid fa-star"></i>
                    <div>
                        <strong>The "Miracle" Angle:</strong> Medical Studio users identify vacant seats that others overlook. By tracking real-time joining status, you can strategize for miracle allotments in top-tier institutes during final rounds.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SEAT MATRIX
     ============================================================ --}}
<section id="live-matrix" class="section section-dark">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow section-eyebrow-dark">Tool 03</span>
            <h2 class="section-title section-title-white">Seat Matrix<br>Dashboard</h2>
            <p class="section-desc section-desc-muted">
                Consolidated real-time dashboard integrating updates from AIQ, Central Universities (BHU, AMU, DU), and DNB. Dynamic monitoring of vacancies the moment they are released.
            </p>
        </div>

        <div class="reveal" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:var(--radius-xl);padding:2rem;overflow:hidden;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
                <h3 style="color:#ffffff;font-size:1.25rem;">All-India Seat Availability</h3>
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.85rem;color:rgba(255,255,255,0.5);">
                    <span style="width:8px;height:8px;border-radius:50%;background:#22C55E;display:inline-block;animation:pulse-dot 2s infinite;"></span>
                    Updated 2 minutes ago
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="ms-table ms-table-dark" style="min-width:600px;">
                    <thead>
                        <tr>
                            <th>Institute Name</th>
                            <th>Course</th>
                            <th>Category</th>
                            <th>Vacancy Type</th>
                            <th>Seats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>VMMC, New Delhi</td>
                            <td>MD Gen Medicine</td>
                            <td>UR</td>
                            <td><span class="badge badge-green">Clear-cut</span></td>
                            <td style="font-weight:700;color:#ffffff;">02</td>
                        </tr>
                        <tr>
                            <td>ABVIMS &amp; RML, Delhi</td>
                            <td>MD Gen Medicine</td>
                            <td>UR</td>
                            <td><span class="badge badge-yellow">Virtual</span></td>
                            <td style="font-weight:700;color:#ffffff;">04</td>
                        </tr>
                        <tr>
                            <td>BHU, Varanasi</td>
                            <td>MS Orthopaedics</td>
                            <td>OBC</td>
                            <td><span class="badge badge-green">Clear-cut</span></td>
                            <td style="font-weight:700;color:#ffffff;">01</td>
                        </tr>
                        <tr>
                            <td>AMU, Aligarh</td>
                            <td>MD Paediatrics</td>
                            <td>SC</td>
                            <td><span class="badge badge-yellow">Virtual</span></td>
                            <td style="font-weight:700;color:#ffffff;">02</td>
                        </tr>
                        <tr>
                            <td>JIPMER, Puducherry</td>
                            <td>MD Radio Diagnosis</td>
                            <td>UR</td>
                            <td><span class="badge badge-green">Clear-cut</span></td>
                            <td style="font-weight:700;color:#ffffff;">01</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="grid-3" style="margin-top:2rem;gap:1rem;">
                <div style="background:var(--bg-soft, #f8fafc);border:1px solid var(--border, #e2e8f0);border-radius:var(--radius-lg);padding:1.25rem;text-align:center;">
                    <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:var(--ink, #0f172a);">234</div>
                    <div style="font-size:0.8rem;color:var(--muted, #64748b);margin-top:0.25rem;font-weight:600;">Total Clear-cut Vacancies</div>
                </div>
                <div style="background:var(--bg-soft, #f8fafc);border:1px solid var(--border, #e2e8f0);border-radius:var(--radius-lg);padding:1.25rem;text-align:center;">
                    <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:var(--ink, #0f172a);">567</div>
                    <div style="font-size:0.8rem;color:var(--muted, #64748b);margin-top:0.25rem;font-weight:600;">Potential Virtual Vacancies</div>
                </div>
                <div style="background:var(--bg-soft, #f8fafc);border:1px solid var(--border, #e2e8f0);border-radius:var(--radius-lg);padding:1.25rem;text-align:center;">
                    <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:var(--ink, #0f172a);">1,892</div>
                    <div style="font-size:0.8rem;color:var(--muted, #64748b);margin-top:0.25rem;font-weight:600;">Total Institutes Monitored</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CHOICE LIST BUILDER
     ============================================================ --}}
<section id="choice-builder" class="section section-bg">
    <div class="container">
        <div class="grid-2" style="align-items:start;gap:4rem;">
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                    <div class="icon-circle"><i class="fa-solid fa-list-check"></i></div>
                    <div>
                        <span class="section-eyebrow" style="margin:0;display:block;">Tool 04</span>
                        <h2 style="font-size:2rem;margin:0;">Choice List Builder</h2>
                    </div>
                </div>
                <p style="margin-bottom:1.5rem;color:var(--color-body);line-height:1.8;">
                    Positioned as a Counselling Simulation, this tool allows you to build and refine your preference list before the official MCC portal opens. One wrong entry on the MCC site can cost you a year — refine it here first with zero risk.
                </p>

                <div style="margin-bottom:2rem;">
                    <h3 style="font-size:1.1rem;margin-bottom:1.25rem;">The 'Simulate-Analyze-Lock' Workflow</h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-red);color:#ffffff;display:flex;align-items:center;justify-content:center;font-family:var(--font-heading);font-weight:700;flex-shrink:0;">1</div>
                            <div>
                                <h4 style="font-size:1rem;margin-bottom:0.25rem;">Simulate</h4>
                                <p style="font-size:0.9rem;color:var(--color-body);">Drag and drop institutes into your virtual list based on branch and state preferences.</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-red);color:#ffffff;display:flex;align-items:center;justify-content:center;font-family:var(--font-heading);font-weight:700;flex-shrink:0;">2</div>
                            <div>
                                <h4 style="font-size:1rem;margin-bottom:0.25rem;">Analyze</h4>
                                <p style="font-size:0.9rem;color:var(--color-body);">Our logic engine audits your list for financial and legal risks — high-fee traps, bond liabilities, and category mismatches.</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:1rem;">
                            <div style="width:36px;height:36px;border-radius:50%;background:var(--color-red);color:#ffffff;display:flex;align-items:center;justify-content:center;font-family:var(--font-heading);font-weight:700;flex-shrink:0;">3</div>
                            <div>
                                <h4 style="font-size:1rem;margin-bottom:0.25rem;">Lock</h4>
                                <p style="font-size:0.9rem;color:var(--color-body);">Export your optimized blueprint, ready for error-free entry on the official MCC portal.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background:var(--color-bg-soft);border-radius:var(--radius-lg);padding:1.25rem;">
                    <h4 style="font-size:1rem;margin-bottom:0.75rem;">Data-Filtered Sorting Options</h4>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                        @foreach(['Monthly Stipend','Bond Duration','Total Fees','Historical Ranks'] as $filter)
                        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;color:var(--color-body);">
                            <i class="fa-solid fa-circle-check" style="color:var(--color-success);font-size:0.8rem;"></i>
                            {{ $filter }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="card" style="border:none;">
                    <h3 style="font-size:1.1rem;margin-bottom:1.5rem;">Smart Optimization Alerts</h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div class="alert alert-danger">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>
                                <strong>High-Fee Alert</strong><br>
                                <span style="font-size:0.85rem;">This Deemed University's fee structure is 40% above the national average. Verify your budget before locking.</span>
                            </div>
                        </div>
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-link"></i>
                            <div>
                                <strong>Bond Warning</strong><br>
                                <span style="font-size:0.85rem;">This institute carries a 10-year Rural/Tribal service bond with a ₹50 Lakh penalty. Is this worth your career trajectory?</span>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fa-solid fa-circle-check"></i>
                            <div>
                                <strong>Optimized Order</strong><br>
                                <span style="font-size:0.85rem;">Your list is strategically balanced with Safe, Moderate, and Ambitious choices.</span>
                            </div>
                        </div>
                    </div>
                    <hr class="divider">
                    <div class="alert alert-success">
                        <i class="fa-solid fa-shield-halved"></i>
                        <div>
                            <strong>Pre-Lock Review Available:</strong> Our experts review your final list before you submit to the MCC portal — your last safety net against permanent mistakes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="container" style="position:relative;z-index:1;">
        <h2 class="cta-banner-title">Start Using Analytics Tools Today</h2>
        <p class="cta-banner-desc">Build My Choice List — Explore Allotment Maps — Verify My Documentation</p>
        <a href="{{ route('contact') }}" class="btn btn-lg btn-rounded" style="background:#ffffff;color:var(--color-red);font-weight:700;">
            <i class="fa-solid fa-rocket"></i>
            Get Started Now
        </a>
    </div>
</section>

@endsection
