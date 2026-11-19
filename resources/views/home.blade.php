@extends('layouts.app')

@section('title', 'Medical Studio — Expert Medical Admissions Counselling | NEET PG · UG · MBBS · MD')
@section('meta_description', 'Medical Studio: India\'s trusted medical admissions platform. Expert guidance for NEET-PG, NEET-UG, MBBS, MD, MS, BDS, MDS. Kerala · Karnataka · Tamil Nadu.')

@section('content')

{{-- ============================================================
     SECTION 1: HERO — DARK FULL-BLEED + MASSIVE HEADLINE
     (PotShow: "DIVE INTO OUR PODVERSE")
     ============================================================ --}}
<section class="potshow-hero" style="position:relative;">
    {{-- Hero background image --}}
    <div style="position:absolute;inset:0;z-index:0;overflow:hidden;">
        <img src="{{ asset('images/white_hero.png') }}" alt="" style="width:100%;height:100%;object-fit:cover;object-position:center;" loading="eager">
        <div style="position:absolute;inset:0;background:linear-gradient(to right,rgba(255,255,255,0.94) 0%,rgba(255,255,255,0.78) 55%,rgba(255,255,255,0.08) 100%);"></div>
    </div>

    <div class="potshow-hero-inner">
        {{-- Eyebrow --}}
        <div class="potshow-hero-eyebrow">
            <span class="live-dot"></span>
            <span style="color:var(--muted);">NEET UG &nbsp;·&nbsp; NEET PG &nbsp;·&nbsp; MBBS &nbsp;·&nbsp; MD &nbsp;·&nbsp; MS &nbsp;·&nbsp; BDS &nbsp;·&nbsp; MDS</span>
        </div>

        {{-- MASSIVE HEADLINE --}}
        <div class="potshow-hero-title">
            YOUR PATH<br>
            TO <em>MEDICINE</em><br>
            STARTS HERE
        </div>

        {{-- Subtitle + CTA Row --}}
        <div class="potshow-hero-subtitle-row">
            <p class="potshow-hero-sub">
                India's trusted partner for medical admissions. Expert counselling for MBBS, MD, MS, BDS &amp; MDS — from NEET score to dream college seat.
            </p>
            <div class="potshow-hero-actions">
                <a href="{{ route('contact') }}" class="btn btn-teal btn-lg">
                    <i class="fa-solid fa-rocket"></i>&nbsp; Free Consultation
                </a>
                <a href="{{ route('seat-predictor') }}" class="btn btn-outline-white btn-lg">
                    <i class="fa-solid fa-chart-bar"></i>&nbsp; Seat Predictor
                </a>
            </div>
        </div>

        {{-- Platform / Authority logos bar --}}
        <div class="platform-bar">
            <div class="platform-bar-label">Trusted Across India's Medical Ecosystem</div>
            <div class="platform-logos">
                <div class="platform-logo-item">
                    <i class="fa-solid fa-hospital"></i>
                    <span>MCC India</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-microscope"></i>
                    <span>AIIMS</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span>NEET-PG</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>NEET-UG</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-tooth"></i>
                    <span>NEET-MDS</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>INICET</span>
                </div>
                <div class="platform-logo-item">
                    <i class="fa-solid fa-file-medical"></i>
                    <span>DNB-PDCET</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 2: MARQUEE TRUST BAR
     ============================================================ --}}
<div class="marquee-bar">
    <div class="marquee-track">
        @php
        $items = ['5,000+ Admissions Guided','MBBS · Kerala · Karnataka · TN','NEET-PG Counselling','MD · MS · MDS Admissions','19+ Years of Expertise','BDS Admissions','INICET · DNB-PDCET','1,892+ Institutes Covered','NEET-UG Expert Guidance','98.7% Prediction Accuracy','NEET SS Guidance','Expert Counsellors On Call'];
        $doubled = array_merge($items,$items);
        @endphp
        @foreach($doubled as $item)
        <div class="marquee-item">
            <span class="sep"></span>
            {{ $item }}
        </div>
        @endforeach
    </div>
</div>

{{-- ============================================================
     SECTION 3: TRENDING SERVICES — Card Strip
     (PotShow: "Trending Episodes")
     ============================================================ --}}
<section class="section">
    <div class="container">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2.5rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <span class="eyebrow reveal">Our Counselling Services</span>
                <div class="display-lg reveal reveal-d1" style="margin-top:0.5rem;color:var(--ink);">Trending<br>Admissions</div>
            </div>
            <a href="{{ route('packages') }}" class="btn btn-teal reveal" style="flex-shrink:0;">
                All Packages <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="ep-grid reveal">
            @php
            $services = [
                ['card_neet_pg.png',  'NEET PG',  'Most Popular', 'MD / MS admissions across AIQ, State & Deemed universities.'],
                ['card_neet_mds.png', 'NEET MDS', 'Growing Fast',  'BDS & MDS admissions with expert seat prediction.'],
                ['card_neet_ug.png',  'NEET UG',  'New Batch',     'MBBS admissions for freshers — 1st year & lateral entry.'],
                ['card_inicet.png',   'INICET',   'Free Advice',   'AIIMS PG admissions and JIPMER guidance by experts.'],
            ];
            @endphp
            @foreach($services as $s)
            <div class="ep-card">
                <div class="ep-card-bg" style="background:#111;">
                    <img src="{{ asset('images/'.$s[0]) }}" alt="{{ $s[1] }}" style="width:100%;height:100%;object-fit:cover;opacity:1;position:absolute;inset:0;" loading="lazy">
                </div>
                <div class="ep-card-play"><i class="fa-solid fa-arrow-right"></i></div>
                <div class="ep-card-overlay">
                    <div class="ep-card-tag">{{ $s[2] }}</div>
                    <div class="ep-card-title">{{ $s[1] }} Counselling</div>
                    <div class="ep-card-sub">{{ $s[3] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 4: EPIC HEADLINES — Two-column editorial
     (PotShow: "Epic Headlines, Always Fresh, Always Here")
     ============================================================ --}}
<section style="border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="editorial-split">
            {{-- Left --}}
            <div class="editorial-left">
                <span class="eyebrow reveal">Why Medical Studio</span>
                <div class="display-xl reveal reveal-d1" style="color:var(--ink);margin-top:0.6rem;">
                    Expert Guidance.<br>
                    Always Accurate.<br>
                    <span style="color:var(--blue);">Always Here.</span>
                </div>
                <p class="body-md reveal reveal-d2" style="margin-top:1.5rem;max-width:400px;">
                    We combine 19+ years of hands-on experience with cutting-edge data tools to give you India's most accurate medical admissions counselling.
                </p>

                {{-- Inline Stats --}}
                <div class="stats-inline stagger reveal reveal-d3">
                    <div class="stat-inline-item">
                        <div class="stat-inline-num" data-target="{{ $studentCount + 5000 }}">0<span>+</span></div>
                        <div class="stat-inline-lbl">Admissions Guided</div>
                    </div>
                    <div class="stat-inline-item">
                        <div class="stat-inline-num" data-target="{{ $courseCount }}">0<span>+</span></div>
                        <div class="stat-inline-lbl">Courses Available</div>
                    </div>
                    <div class="stat-inline-item">
                        <div class="stat-inline-num" data-target="{{ $collegeCount }}">0</div>
                        <div class="stat-inline-lbl">Institutes Covered</div>
                    </div>
                </div>

                <div style="margin-top:2.5rem;" class="reveal reveal-d4">
                    <a href="{{ route('about') }}" class="btn btn-teal">
                        Our Story <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                {{-- Partner / Trust row --}}
                <div style="margin-top:2.5rem;padding-top:2.5rem;border-top:1px solid var(--border);" class="reveal">
                    <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:var(--muted);margin-bottom:1rem;">Our Expert Partners</div>
                    <div style="display:flex;gap:2rem;flex-wrap:wrap;align-items:center;">
                        @foreach(['NEET Experts','MCC Counsellors','Hospital Faculty','Rank Analysts'] as $p)
                        <div style="font-size:0.85rem;font-weight:700;color:var(--muted);letter-spacing:0.04em;">{{ $p }}</div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: Image with stats overlay --}}
            <div class="editorial-right reveal" style="display:flex;flex-direction:column;justify-content:center;">
                <div style="position:relative;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.1);">
                    <img src="{{ asset('images/team_office.png') }}" alt="Medical Studio Expert Team"
                         style="width:100%;height:420px;object-fit:cover;display:block;"
                         onerror="this.src='{{ asset('images/white_hero.png') }}'">
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(15,23,42,0.7) 0%,transparent 60%);"></div>
                    {{-- Stats overlay --}}
                    <div style="position:absolute;bottom:0;left:0;right:0;padding:1.75rem;display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
                        @foreach([['5,000+','Admissions'],['19+','Years Exp.'],['98.7%','Accuracy']] as $s)
                        <div style="text-align:center;">
                            <div style="font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:#fff;line-height:1;">{{ $s[0] }}</div>
                            <div style="font-size:0.65rem;color:rgba(255,255,255,0.7);margin-top:2px;text-transform:uppercase;letter-spacing:0.08em;font-weight:600;">{{ $s[1] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Trust tags --}}
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:1.25rem;">
                    @foreach(['NEET PG Experts','MCC Counsellors','Hospital Faculty','Rank Analysts'] as $tag)
                    <span style="background:var(--blue-dim);color:var(--blue);font-size:0.72rem;font-weight:600;padding:4px 12px;border-radius:999px;border:1px solid rgba(29,78,216,0.15);">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 5: EXPERT TEAM — "United Voices, Limitless Stories"
     (PotShow: hosts gallery)
     ============================================================ --}}
<section class="section">
    <div class="container">
        <style>
            .experts-grid {
                display: grid;
                grid-template-columns: 1fr 2fr;
                gap: 4rem;
                align-items: center;
            }
            @media (max-width: 768px) {
                .experts-grid {
                    grid-template-columns: 1fr !important;
                    gap: 2rem !important;
                }
            }
        </style>
        <div class="experts-grid">
            <div class="reveal">
                <span class="eyebrow">Our Experts</span>
                <div class="display-lg" style="color:var(--ink);margin-top:0.6rem;">Real Doctors.<br>Limitless<br><span style="color:var(--blue);">Guidance.</span></div>
                <p style="font-size:0.95rem;color:var(--muted);line-height:1.75;margin-top:1rem;max-width:300px;">No AI. No bots. Real medical professionals and verified counsellors answering your questions.</p>
                <a href="{{ route('contact') }}" class="btn btn-teal" style="margin-top:2rem;">
                    Talk to an Expert <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="host-grid reveal reveal-d2">
                @php
                $experts = [
                    ['expert_counsellor.png',    'NEET-PG Counsellor',  'Ex-MCC Advisor'],
                    ['expert_doctor_female.png', 'MD / MS Specialist',   '12+ Yrs Experience'],
                    ['expert_data_analyst.png',  'NEET MDS Expert',      'BDS Admissions Specialist'],
                    ['expert_counsellor.png',    'INICET Advisor',        'AIIMS & JIPMER Guidance'],
                    ['expert_doctor_female.png', 'Hospital Liaison',      'Clinical Exposure Analyst'],
                    ['expert_data_analyst.png',  'Data Analyst',          'Seat Prediction Engine'],
                ];
                @endphp
                @foreach($experts as $i => $e)
                <div class="host-card">
                    <div class="host-card-bg" style="background:#111;padding:0;">
                        <img src="{{ asset('images/'.$e[0]) }}" alt="{{ $e[1] }}" style="width:100%;height:100%;object-fit:cover;object-position:top center;position:absolute;inset:0;" loading="lazy">
                    </div>
                    <div class="host-card-info">
                        <div class="host-name">{{ $e[1] }}</div>
                        <div class="host-role">{{ $e[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 6: DARK CTA — "What Do You Want to Hear Today?"
     (PotShow: dark subscribe section)
     ============================================================ --}}
<section class="dark-cta-section">
    <div class="container">
        <div class="dark-cta-inner">
            <span class="eyebrow-dark reveal">Start Your Journey</span>
            <div class="dark-cta-title reveal reveal-d1">
                What Specialty<br>
                Do You Want<br>
                <em>To Achieve?</em>
            </div>
            <p style="color:rgba(255,255,255,0.45);font-size:1rem;line-height:1.7;" class="reveal reveal-d2">
                Share your NEET score and desired branch. We'll analyse your best options — instantly, personally, accurately.
            </p>

            @if(session('success') && session('quick_form'))
                <div style="color: var(--teal-light); background: rgba(20, 184, 166, 0.1); border: 1px solid var(--teal-light); padding: 0.75rem 1rem; border-radius: 8px; margin-top: 1rem; font-size: 0.9rem; font-weight: 600; text-align: center;">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contact.submit') }}" method="POST" class="consult-form reveal reveal-d3" id="quickForm" style="margin-top: 1rem;">
                @csrf
                <input type="hidden" name="name" value="Quick Callback Request">
                <input type="hidden" name="enquiry_for" value="Talk to an Expert">
                <input type="hidden" name="is_quick_form" value="1">
                <input type="tel" name="phone" class="consult-input" placeholder="Enter your phone number..." required maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                <button type="submit" class="consult-btn">
                    Get Free Call <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            <p style="color:rgba(255,255,255,0.25);font-size:0.75rem;margin-top:1rem;" class="reveal reveal-d4">
                Or call us directly: &nbsp;<a href="tel:+919747500002" style="color:var(--teal-light);font-weight:700;">+91 97475 00002</a> / <a href="tel:+919747500003" style="color:var(--teal-light);font-weight:700;">+91 97475 00003</a>
            </p>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 7: WHY SETTLE — Services list
     (PotShow: "Why Settle? Join the Podcast Masters")
     ============================================================ --}}
<section style="border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="why-section">
            <div class="why-left">
                <span class="eyebrow reveal">Our Tools</span>
                <div class="display-lg reveal reveal-d1" style="color:var(--black);margin-top:0.6rem;">
                    Why Settle?<br>Get Expert<br><span style="color:var(--teal);">Admission<br>Guidance.</span>
                </div>
                <p class="body-md reveal reveal-d2" style="margin-top:1.25rem;max-width:360px;">
                    Access the most powerful medical admissions toolkit in India — combining real data with real human expertise.
                </p>

                {{-- Preview-style info card --}}
                <div style="margin-top:2.5rem;border:1px solid var(--border);padding:1.5rem;" class="reveal reveal-d3">
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted);margin-bottom:1rem;">
                        Insights Dashboard
                    </div>
                    @foreach(['Rank Scan Engine','Allotment Mapping','Seat Matrix','Choice List Builder'] as $tool)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:0.7rem 0.875rem;border:1px solid var(--border);margin-bottom:0.5rem;background:var(--off-white);font-size:0.85rem;font-weight:600;transition:background 0.2s;" onmouseover="this.style.background='var(--teal-soft)'" onmouseout="this.style.background='var(--off-white)'">
                        {{ $tool }}
                        <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;color:var(--teal);"></i>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="why-right">
                <div class="why-items reveal">
                    @php
                    $whys = [
                        ['01','Rank Scan Engine',       'Clinical-grade prediction across 3,200+ roster data points. Forecast your admission across AIQ, Deemed & State quotas.'],
                        ['02','Allotment Mapping',      'Track who joined where. Reveal virtual vacancies and strategic seat opportunities across all counselling rounds.'],
                        ['03','Seat Matrix',       'Real-time seat dashboard across 1,892+ institutes — updated as soon as MCC releases new data.'],
                        ['04','Choice List Builder',    'Build and simulate your MCC preference list before you submit. Zero risk, zero mistakes.'],
                        ['05','Institutes Database',    '1,100+ verified college profiles — fees, bonds, stipends, bed counts, and specialty constraints.'],
                        ['06','24/7 Expert Support',    'Real doctors and experienced counsellors — no AI, no bots — available through every counselling round.'],
                    ];
                    @endphp
                    @foreach($whys as $w)
                    <div class="why-item">
                        <div class="why-item-num">{{ $w[0] }}</div>
                        <div class="why-item-content">
                            <div class="why-item-title">{{ $w[1] }}</div>
                            <div class="why-item-desc">{{ $w[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:1.5rem;" class="reveal">
                    <a href="{{ route('login') }}" class="btn btn-teal btn-lg">
                        Access All Tools <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 8: TESTIMONIALS — "Shine Bright, Speak Loud"
     (PotShow: "Testimonials Take Flight")
     ============================================================ --}}
<section class="section section-off">
    <div class="container">
        <div class="text-center" style="margin-bottom:3.5rem;">
            <span class="eyebrow reveal">Success Stories</span>
            <div class="display-xl reveal reveal-d1" style="color:var(--black);margin-top:0.6rem;">
                Shine Bright, Speak Loud:<br>
                <span style="color:var(--teal);">Testimonials Take Flight</span>
            </div>
        </div>

        <div class="testimonial-strip reveal">
            @php
            $testimonials = [
                ['FK','Dr. Fabi Karim','MD Ophthalmology','Kodagu Institute',"Medical Studio's data gave me confidence to wait until the Stray Round. They predicted a seat would open — and it did. Life-changing guidance."],
                ['AT','Dr. Athul','MD DCH','Area Hospital Amalapuram',"Medical Studio warned me about a 'negative shift' in Round 3. I joined in Round 2 and retained my seat. Their advice saved my career."],
                ['MO','Dr. Monika','MS OBGY','CMC Vellore',"As an OCI cardholder I was confused about eligibility. Medical Studio clarified everything and I got into CMC through government quota."],
                ['RP','Dr. Rohit','MD Psychiatry','Vedanta Institute',"Never thought I'd get a clinical branch with AIR 68,497. Medical Studio showed me invisible opportunities. The Allotment Mapping was a game-changer."],
                ['SK','Dr. Siddhant','MD Radiology','K S Hegde Hospital',"My son got his dream branch — Radio Diagnosis — in Round 1. Medical Studio's prompt support and accuracy is unmatched anywhere in India."],
                ['WD','Dr. Wricheek','MS Surgery','Bankura Medical College',"The rank inflation was terrifying but Medical Studio's data gave me confidence to wait for Round 2. Their predictions were spot-on."],
            ];
            @endphp
            @foreach($testimonials as $t)
            <div class="tcard">
                <div class="tcard-quote">"</div>
                <p class="tcard-text">{{ $t[4] }}</p>
                <div class="tcard-meta">
                    <div class="tcard-avatar">{{ $t[0] }}</div>
                    <div>
                        <div class="tcard-name">{{ $t[1] }}</div>
                        <div class="tcard-role">{{ $t[2] }}</div>
                        <div class="tcard-inst">{{ $t[3] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center" style="margin-top:2.5rem;">
            <a href="{{ route('success-stories') }}" class="btn btn-black btn-lg">
                View All Stories <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 9: BLOG — "Tap into Trending Topics"
     (PotShow: "Latest Podcast, Always On")
     ============================================================ --}}
<section class="section" style="border-top:1px solid var(--border);">
    <div class="container">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2.5rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <span class="eyebrow reveal">Medical Admissions Blog</span>
                <div class="display-lg reveal reveal-d1" style="color:var(--black);margin-top:0.5rem;">
                    Tap into Trending Topics:<br>
                    <span style="color:var(--teal);">Latest Insights, Always On</span>
                </div>
            </div>
            <a href="{{ route('blog') }}" class="btn btn-black reveal" style="flex-shrink:0;">
                All Articles <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="blog-strip reveal">
            @forelse(\App\Models\BlogPost::published()->latest('published_at')->take(3)->get() as $post)
            <div class="bcard">
                <a href="{{ route('blog.show', $post->slug) }}" class="bcard-img" style="display:block;">
                    @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="bcard-img-inner" style="background:var(--off-white);">
                            <i class="fa-solid fa-newspaper" style="font-size:2.5rem;color:var(--muted);"></i>
                        </div>
                    @endif
                </a>
                <div class="bcard-body">
                    <span class="bcard-cat">{{ $post->category }}</span>
                    <div class="bcard-title">{{ $post->title }}</div>
                    <div class="bcard-foot">
                        <span style="display:flex;align-items:center;gap:0.3rem;font-size:0.75rem;color:var(--muted);">
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}
                        </span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="bcard-read">
                            Read <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            @foreach([
                ['NEET-PG 2026 Counselling Guide','neet-pg-2026-counselling-guide','Counselling Guide','15 Jun 2026','blog_neet_counselling.png'],
                ['How to Build a Perfect Choice List','choice-list-guide','Strategy','10 Jun 2026','card_neet_pg.png'],
                ['Kerala vs Karnataka MBBS Comparison','kerala-vs-karnataka-mbbs','College Comparison','5 Jun 2026','card_neet_ug.png'],
            ] as $fb)
            <div class="bcard">
                <div class="bcard-img" style="overflow:hidden;">
                    <img src="{{ asset('images/'.$fb[4]) }}" alt="{{ $fb[0] }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s;" loading="lazy">
                </div>
                <div class="bcard-body">
                    <span class="bcard-cat">{{ $fb[2] }}</span>
                    <div class="bcard-title">{{ $fb[0] }}</div>
                    <div class="bcard-foot">
                        <span style="font-size:0.75rem;color:var(--muted);">{{ $fb[3] }}</span>
                        <a href="{{ route('blog') }}" class="bcard-read">Read <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 10: GET IN TOUCH + PACKAGES CONTACT
     (PotShow: "Get in Touch")
     ============================================================ --}}
<section style="border-top:1px solid var(--border);">
    <div class="container">
        <div class="contact-section">
            {{-- Left --}}
            <div class="contact-left">
                <span class="eyebrow reveal">Get In Touch</span>
                <div class="display-lg reveal reveal-d1" style="color:var(--black);margin-top:0.6rem;">
                    Talk to Our<br>
                    <span style="color:var(--teal);">Expert Team</span>
                </div>
                <p class="body-md reveal reveal-d2" style="margin-top:1.25rem;max-width:380px;">
                    Have a question about your admission? Call us or drop a message. Our counsellors are available Mon–Sat, 9:30 AM – 5:30 PM.
                </p>

                <div style="margin-top:2.5rem;display:flex;flex-direction:column;gap:1.25rem;" class="reveal reveal-d3">
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:44px;height:44px;background:var(--off-white);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-phone" style="color:var(--teal);"></i>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted);font-weight:600;">Phone</div>
                            <div style="font-weight:700;font-size:0.95rem;">
                                <a href="tel:+919747500002" class="hover-underline">+91 97475 00002</a> /
                                <a href="tel:+919747500003" class="hover-underline">+91 97475 00003</a>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:44px;height:44px;background:var(--off-white);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-envelope" style="color:var(--teal);"></i>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted);font-weight:600;">Email</div>
                            <div style="font-weight:700;"><a href="mailto:info@medicalstudio.in" class="hover-underline">info@medicalstudio.in</a></div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1rem;">
                        <div style="width:44px;height:44px;background:var(--off-white);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-solid fa-location-dot" style="color:var(--teal);"></i>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--muted);font-weight:600;">Location</div>
                            <div style="font-weight:700;">Mangalore, Karnataka, India</div>
                        </div>
                    </div>
                </div>

                {{-- Social row --}}
                <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--border);display:flex;gap:1rem;" class="reveal">
                    @foreach([['fa-brands fa-facebook-f','https://www.facebook.com/people/Medical-Studioin/100093274676506/'],['fa-brands fa-instagram','https://www.instagram.com/medicalstudio.in/'],['fa-brands fa-youtube','https://youtu.be/nywWWOoPkBs'],['fa-brands fa-whatsapp','https://wa.me/919747500002']] as $s)
                    <a href="{{ $s[1] }}" class="footer-social-btn" target="_blank" rel="noopener">
                        <i class="{{ $s[0] }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Right: Quick contact form --}}
            <div class="contact-right reveal reveal-d2">
                <div style="background:var(--off-white);padding:2.5rem;">
                    <div style="font-family:var(--font-heading);font-size:1.2rem;font-weight:800;margin-bottom:1.5rem;">Request a Free Callback</div>

                    @if(session('success') && !session('quick_form'))
                        <div class="alert alert-success" style="margin-bottom: 1.5rem; background: rgba(16, 185, 129, 0.1); border: 1px solid var(--green); color: var(--green); padding: 0.75rem 1rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" style="display:flex;flex-direction:column;">
                        @csrf
                        <input  type="text"  name="name"    class="contact-form-field" placeholder="Your Full Name" required>
                        <input  type="tel"   name="phone"   class="contact-form-field" placeholder="Phone Number" required maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                        <select name="exam"                 class="contact-form-field" style="appearance:none;">
                            <option value="">Select Exam / Programme</option>
                            <option>NEET PG</option>
                            <option>NEET UG</option>
                            <option>NEET MDS</option>
                            <option>INICET</option>
                            <option>DNB PDCET</option>
                            <option>NEET SS</option>
                        </select>
                        <textarea name="message" class="contact-form-field" placeholder="Your query (optional)" rows="3" style="resize:vertical;border-bottom:1px solid var(--border) !important;"></textarea>
                        <button type="submit" class="btn btn-teal" style="margin-top:1rem;">
                            Request Callback <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SECTION 11: PACKAGES TEASER + FINAL DARK CTA
     (PotShow: "Accelerate Your Impact, Become a Sponsor!")
     ============================================================ --}}
<section class="sponsor-section">
    <div class="container" style="position:relative;z-index:1;">
        <span class="eyebrow-dark reveal">Transparent Pricing</span>
        <div style="font-family:var(--font-display);font-size:clamp(3rem,8vw,7.5rem);line-height:0.9;text-transform:uppercase;color:var(--ink);margin:0.75rem 0 1.5rem;" class="reveal reveal-d1">
            Accelerate Your<br>
            Journey. <span style="color:var(--blue);">Become</span><br>
            A Doctor.
        </div>
        <p style="color:var(--muted);font-size:1rem;max-width:520px;margin:0 auto 3rem;" class="reveal reveal-d2">
            Access India's most powerful admissions toolkit. Transparent pricing, no hidden fees.
        </p>

        {{-- Packages strip --}}
        <div class="packages-strip-wrapper reveal reveal-d3">
            <div class="packages-strip" style="gap:1px;background:var(--border);margin-bottom:3rem;">
                @php
                $plans = [['NEET UG','₹1,499',true],['NEET PG','₹1,499',false],['NEET MDS','₹1,499',false],['INICET','₹1,499',false],['DNB PDCET','₹1,499',false],['NEET SS','₹1,499',false]];
                @endphp
                @foreach($plans as $p)
                <div style="padding:1.5rem;text-align:center;background:{{ $p[2] ? 'var(--blue-dim)' : 'var(--bg)' }};border:1px solid transparent;transition:all 0.2s;" onmouseover="this.style.background='var(--bg-soft)'" onmouseout="this.style.background='{{ $p[2] ? 'var(--blue-dim)' : 'var(--bg)' }}'">
                    @if($p[2])<span style="display:block;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--blue);margin-bottom:0.5rem;">Popular</span>@endif
                    <div style="font-family:var(--font-heading);font-size:0.85rem;font-weight:700;color:var(--muted);margin-bottom:0.35rem;">{{ $p[0] }}</div>
                    <div style="font-family:var(--font-display);font-size:2rem;color:var(--ink);">{{ $p[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;" class="reveal">
            <a href="{{ route('packages') }}" class="btn btn-teal btn-lg">
                View All Packages <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-white btn-lg">
                Get Started Free
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .packages-strip-wrapper {
        width: 100%;
        overflow: hidden;
    }
    .packages-strip {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
    }
    @media (max-width: 992px) {
        .packages-strip-wrapper {
            margin-left: -1rem;
            margin-right: -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
            width: calc(100% + 2rem);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE/Edge */
        }
        .packages-strip-wrapper::-webkit-scrollbar {
            display: none; /* Chrome/Safari */
        }
        .packages-strip {
            display: flex;
            flex-wrap: nowrap;
            width: max-content;
            gap: 1px !important;
            padding-bottom: 0.5rem; /* For safe scrolling area */
        }
        .packages-strip > div {
            flex: 0 0 160px;
            width: 160px;
            scroll-snap-align: start;
        }
    }
</style>
</style>
@endpush

@push('scripts')
<script>
// Scroll reveal (IntersectionObserver)
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            io.unobserve(e.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal, .reveal-left, .reveal-fade').forEach(el => io.observe(el));

// Navbar scroll
const nav = document.getElementById('mainNavbar');
window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 30);
}, { passive: true });

// FAQ
function toggleFaq(btn) {
    const wasOpen = btn.classList.contains('open');
    document.querySelectorAll('.faq-trigger.open').forEach(b => {
        b.classList.remove('open');
        b.nextElementSibling.style.maxHeight = '0';
    });
    if (!wasOpen) {
        btn.classList.add('open');
        const body = btn.nextElementSibling;
        body.style.maxHeight = body.scrollHeight + 'px';
    }
}

// Counter animation
document.querySelectorAll('[data-target]').forEach(el => {
    const cio = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                const target = parseInt(el.getAttribute('data-target'));
                const suffix = el.innerHTML.replace(/[\d,]/g, '');
                let count = 0;
                const step = Math.ceil(target / 60);
                const t = setInterval(() => {
                    count = Math.min(count + step, target);
                    el.innerHTML = count.toLocaleString('en-IN') + suffix;
                    if (count >= target) clearInterval(t);
                }, 25);
                cio.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    cio.observe(el);
});

// Quick form handler
function handleQuickForm() {
    const phone = document.getElementById('quickPhone').value.trim();
    if (!phone) { alert('Please enter your phone number.'); return; }
    window.open('https://wa.me/919747500002?text=Hello!+I+need+guidance.+My+number+is+' + encodeURIComponent(phone), '_blank');
}
</script>
@endpush
