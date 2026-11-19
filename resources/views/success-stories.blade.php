@extends('layouts.app')

@section('title', 'Success Stories — Real NEET-PG Counselling Victories | Medical Studio')
@section('meta_description', 'Read how 10 real doctors secured their dream residency branches using Medical Studio\'s data-driven NEET-PG counselling platform. From AIR 68497 to top clinical branches.')

@section('content')

<style>
.story-full-card { background: var(--white, #fff); border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden; display: flex; flex-direction: column; border: 1px solid var(--border, #e2e8f0); transition: transform 0.3s ease, box-shadow 0.3s ease; }
.story-full-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
.story-full-header { background: var(--bg-soft, #f8fafc); border-bottom: 1px solid var(--border, #e2e8f0); padding: 1.5rem; }
.story-avatar { background: rgba(29, 78, 216, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--blue, #1d4ed8); }
.story-cvs { display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap; }
.story-cv-item { flex: 1; min-width: 80px; padding: 0.75rem; border-radius: 8px; background: var(--white, #ffffff); border: 1px solid var(--border, #e2e8f0); }
.story-full-body { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
.badge-red { background: var(--blue, #1d4ed8); color: #fff; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: bold; }
.page-hero { background: var(--bg-soft, #f8fafc); padding: 6rem 0 4rem; text-align: center; border-bottom: 1px solid var(--border, #e2e8f0); }
.page-hero-title { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; color: var(--ink, #0f172a); margin-bottom: 1rem; letter-spacing: -0.02em; }
.page-hero-desc { font-size: 1.1rem; color: var(--muted, #64748b); max-width: 600px; margin: 0 auto; line-height: 1.7; }
.stats-bar-grid { display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1rem; text-align: center; }
.stat-number { font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; color: var(--ink, #0f172a); margin-bottom: 0.25rem; letter-spacing: -0.02em; }
.stat-label { font-size: 0.9rem; color: var(--muted, #64748b); font-weight: 500; }
.cta-banner { background: var(--bg-soft, #f8fafc); padding: 5rem 0; text-align: center; border-top: 1px solid var(--border, #e2e8f0); }
.cta-banner-title { font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; color: var(--ink, #0f172a); margin-bottom: 1rem; letter-spacing: -0.02em; }
.cta-banner-desc { font-size: 1.1rem; color: var(--muted, #64748b); max-width: 600px; margin: 0 auto 2rem; line-height: 1.6; }
:root { --color-navy: #0f172a; --color-red: #dc2626; --color-gold: #fbbf24; --color-success: #16a34a; --color-success-bg: #f0fdf4; --color-body: #334155; --color-bg-soft: #f8fafc; --radius-md: 8px; }
</style>

{{-- PAGE HERO --}}
<section class="page-hero" style="position: relative; background-image: url('{{ asset('images/expert_doctor_female.png') }}'); background-size: cover; background-position: center; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(248,250,252,0.95) 100%); z-index: 0;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <span class="eyebrow" style="color: var(--blue, #1d4ed8);">Real Doctor Outcomes</span>
        <h1 class="page-hero-title">10 Stories of Strategic Victory</h1>
        <p class="page-hero-desc">Real doctors. Real ranks. Real strategies. These outcomes prove that the right data at the right time transforms counselling anxiety into career success.</p>
    </div>
</section>

{{-- STATS BAR --}}
<section style="background:var(--white, #ffffff); padding:3rem 0; border-bottom: 1px solid var(--border, #e2e8f0);">
    <div class="container">
        <div class="stats-bar-grid">
            <div class="stat-item"><div class="stat-number">5,000<span style="color:var(--blue, #1d4ed8);">+</span></div><div class="stat-label">Successful Allotments</div></div>
            <div class="stat-item"><div class="stat-number">10</div><div class="stat-label">Featured Stories</div></div>
            <div class="stat-item"><div class="stat-number">98.7<span style="color:var(--blue, #1d4ed8);">%</span></div><div class="stat-label">Prediction Accuracy</div></div>
            <div class="stat-item"><div class="stat-number">100<span style="color:var(--blue, #1d4ed8);">%</span></div><div class="stat-label">Document Success Rate</div></div>
        </div>
    </div>
</section>

{{-- ============================================================
     ALL 10 SUCCESS STORIES
     ============================================================ --}}
<section class="section">
    <div class="container">

        @php
        $stories = [
            [
                'initials' => 'RP',
                'name' => 'Dr. Rohit Patel',
                'achievement' => 'MD Psychiatry',
                'institution' => 'Vedanta Institute of Medical Sciences',
                'rank' => 'AIR 68,497',
                'category' => 'The Impossible Dream',
                'challenge' => 'A two-time dropper with an AIR of 68,497. Confidence was at rock bottom, and hope for a clinical seat seemed "unexpected." The counselling maze felt insurmountable.',
                'strategy' => 'Utilized Allotment Mapping to track real-time vacancies during the Stray Vacancy Round, identifying a seat that others had completely missed.',
                'victory' => 'Secured his dream branch at an "impossible" rank. Proved that miracles happen when you have the right data.',
                'quote' => 'I never thought I\'d get a clinical branch with my rank. Medical Studio showed me opportunities that were invisible to everyone else. The Allotment Mapping tool was a game-changer during the Stray Round.',
                'tool' => 'Allotment Mapping',
                'round' => 'Stray Vacancy Round',
                'learning' => 'Never underestimate virtual vacancies and real-time tracking during Stray Rounds.',
            ],
            [
                'initials' => 'WD',
                'name' => 'Dr. Wricheek Dutta',
                'achievement' => 'MS General Surgery',
                'institution' => 'Bankura Sammilani Medical College',
                'rank' => 'High Rank Anxiety',
                'category' => 'The Strategic Navigator',
                'challenge' => 'Navigating a lengthy counselling process with high rank-inflation anxiety and fear of missing the right seat. Every round felt like a minefield.',
                'strategy' => 'Used Rank Scan to predict rank shifts and Allotment Mapping strategically to hold out for a better government seat instead of settling early.',
                'victory' => 'Successfully predicted and secured General Surgery in AIQ Round 2 exactly as forecasted — not a rupee of deposit lost.',
                'quote' => 'The rank inflation was terrifying, but Medical Studio\'s data gave me the confidence to wait for Round 2. Their predictions were spot-on.',
                'tool' => 'Rank Scan + Allotment Mapping',
                'round' => 'AIQ Round 2',
                'learning' => 'Data-driven predictions reduce anxiety and lead to better decision-making.',
            ],
            [
                'initials' => 'SK',
                'name' => 'Dr. Siddhant Kamani',
                'achievement' => 'MD Radio Diagnosis',
                'institution' => 'K S Hegde, Mangalore',
                'rank' => 'Top Clinical Branch',
                'category' => 'First Round Precision',
                'challenge' => 'High-stakes decision-making for a top clinical branch with no room for error. Radio Diagnosis is among the most competitive branches in the country.',
                'strategy' => 'Medical Studio provided his mother (Madhu Kamani) with precise fee and cutoff data, allowing for an aggressive "Round 1" focus with a surgical choice list.',
                'victory' => 'Secured Radio Diagnosis in the very first round through informed, aggressive choice filling.',
                'quote' => 'The prompt call support during registration was invaluable. My son got his dream branch—Radio Diagnosis—in Round 1. Medical Studio\'s accuracy is unmatched.',
                'tool' => 'Choice List Builder + Expert Registration',
                'round' => 'Round 1',
                'learning' => 'Expert support helps families make confident decisions for competitive branches.',
            ],
            [
                'initials' => 'FK',
                'name' => 'Dr. Fabi Karim',
                'achievement' => 'MD Ophthalmology',
                'institution' => 'Kodagu Institute of Medical Sciences',
                'rank' => 'Dream Branch Hunter',
                'category' => 'The Patient Winner',
                'challenge' => 'Holding out for a "Dream Branch" while seats were filling up and peer pressure was mounting to settle for something less.',
                'strategy' => 'Stayed confident by reviewing Previous Last-Rank Details and waited specifically for the Stray Round based on Medical Studio\'s data prediction.',
                'victory' => 'Secured MD Ophthalmology when others had already settled for less desirable options.',
                'quote' => 'I was determined to get my dream branch but the cut-offs were intimidating. Medical Studio\'s accurate data on previous last ranks gave me the confidence to wait until the Stray Round. Their data predicted a seat would open, and it did. Their instant replies during that high-stress period were a lifesaver.',
                'tool' => 'Rank Scan + Last-Rank Data',
                'round' => 'Stray Vacancy Round',
                'learning' => 'Patience backed by data beats panic-driven decisions every time.',
            ],
            [
                'initials' => 'MS',
                'name' => 'Dr. Mihir Saxena',
                'achievement' => 'MD Medicine',
                'institution' => 'Tezpur Medical College',
                'rank' => 'Multi-Quota Navigator',
                'category' => 'The Workflow Master',
                'challenge' => 'Overwhelmed by simultaneous AIQ and State counselling rules, deadlines, and complex documentation requirements. Information overload at peak stress.',
                'strategy' => 'Used the Stress-Free Workflow to keep all rules, stipends, matrices, and deadlines in one centralized, organized, easy-to-navigate place.',
                'victory' => 'Smoothly navigated the "cloud of confusion" to land a preferred Medicine seat without missing a single deadline.',
                'quote' => 'Counseling was a maze. Medical Studio organized everything so I could focus on making smart decisions instead of drowning in paperwork.',
                'tool' => 'Stress-Free Workflow + Live Matrix',
                'round' => 'AIQ + State Parallel',
                'learning' => 'Organization and centralized information reduce overwhelm during complex multi-quota counselling.',
            ],
            [
                'initials' => 'CH',
                'name' => 'Dr. Chanthresh',
                'achievement' => 'Diploma in Anaesthesia',
                'institution' => 'Lokmanya Tilak Municipal Medical College',
                'rank' => 'Mid-Rank Optimizer',
                'category' => 'The Perfect Prioritizer',
                'challenge' => 'Managing a massive list of choices for a mid-rank profile without clear guidance on the optimal prioritization order.',
                'strategy' => 'Used the Choice List Builder sorting filters to optimize the order of preferences perfectly matched to his specific rank profile and financial constraints.',
                'victory' => 'Allotted his #1 choice in the third round. "The best choice for my rank."',
                'quote' => 'The Choice List Builder helped me prioritize perfectly. I got my first choice because I organized my list strategically. Best counselling decision I made.',
                'tool' => 'Choice List Builder',
                'round' => 'Round 3 (Mop-up)',
                'learning' => 'Smart choice list organization maximizes chances even for mid-rank candidates.',
            ],
            [
                'initials' => 'KM',
                'name' => 'Dr. Kaushik Murali',
                'achievement' => 'Institute of Choice',
                'institution' => 'AIQ Allotment',
                'rank' => 'Rank Inflation Survivor',
                'category' => 'The Prediction Believer',
                'challenge' => 'Unexpected rank inflation threatened to push him out of his desired institute, causing widespread panic among his peer group.',
                'strategy' => 'Relied on Medical Studio\'s accurate predictions to stay in the process without panic, trusting verified data over unverified peer rumors.',
                'victory' => 'Allotted exactly as predicted by Medical Studio\'s high-accuracy data engine — while others who panicked made costly mistakes.',
                'quote' => 'When everyone was panicking about rank shifts, Medical Studio\'s data kept me calm. I got exactly what they predicted. Trust the data.',
                'tool' => 'Rank Scan + Prediction Engine',
                'round' => 'AIQ Process',
                'learning' => 'Trust verified data over peer panic and unverified rumors.',
            ],
            [
                'initials' => 'MO',
                'name' => 'Dr. Monika',
                'achievement' => 'MS OBGY',
                'institution' => 'Christian Medical College (CMC)',
                'rank' => 'OCI Status Navigator',
                'category' => 'The OCI Success',
                'challenge' => 'OCI status created serious confusion about complex minority and government quota eligibility at the prestigious CMC Vellore.',
                'strategy' => 'Followed Medical Studio\'s comprehensive OCI &amp; Minority Guides to understand the specific application path and optimize quota advantage.',
                'victory' => 'Secured MS OBGY through the government quota at prestigious CMC — a result many OCI candidates miss due to eligibility confusion.',
                'quote' => 'As an OCI cardholder, I was confused about my eligibility. Medical Studio clarified everything and I got into CMC through the government quota.',
                'tool' => 'OCI & Minority Guide + Expert Services',
                'round' => 'Government Quota',
                'learning' => 'Specialized guidance for NRI/OCI status can unlock opportunities at top institutions.',
            ],
            [
                'initials' => 'SG',
                'name' => 'Dr. Savita Gadale',
                'achievement' => 'Mid-Rank Success',
                'institution' => 'Multi-State Counselling',
                'rank' => 'Strategic Optimizer',
                'category' => 'The Balanced Strategist',
                'challenge' => 'Mid-rank candidate needing to optimize chances without risking the dreaded "No Allotment" scenario across multiple states.',
                'strategy' => 'Applied Medical Studio\'s Strategy Suggestions to balance safe choices with ambitious targets, creating a risk-optimized, layered list.',
                'victory' => 'Secured a valuable seat by making informed, data-driven decisions. Got better than expected without risking no allotment.',
                'quote' => 'Medical Studio helped me build a balanced list. I wasn\'t left without a seat, and I got better than I expected. Exactly the outcome I needed.',
                'tool' => 'Strategy Suggestions + Choice List Builder',
                'round' => 'Multi-State Process',
                'learning' => 'Balanced strategy prevents both "no allotment" and "settling for less" scenarios.',
            ],
            [
                'initials' => 'AT',
                'name' => 'Dr. Athul',
                'achievement' => 'MD DCH',
                'institution' => 'Area Hospital Amalapuram',
                'rank' => 'Negative Shift Avoider',
                'category' => 'The Strategy Saver',
                'challenge' => 'Fear of the "Negative Shift" in Round 3 that costs candidates their current seats and clinical branches — a very real risk that many dismiss.',
                'strategy' => 'Used Bond and Stipend Details combined with real-time trends to make the informed decision to retain his Round 2 seat rather than upgrade.',
                'victory' => 'Successfully retained his MD DCH seat while peers lost their clinical branches in the Round 3 shift. A decision that saved his career.',
                'quote' => 'Counseling is a game of strategy. Medical Studio warned me about a potential "negative shift" in Round 3. Based on their Allotment Mapping tool, I chose to join my seat in Round 2 rather than risk an upgrade. I retained my seat while many others lost their clinical branches during the Round 3 shift. Their advice saved my career.',
                'tool' => 'Allotment Mapping + Bond Details',
                'round' => 'Round 2 (Strategic Hold)',
                'learning' => 'Strategic timing decisions can prevent devastating losses during round transitions.',
            ],
        ];
        @endphp

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:2rem;">
            @foreach($stories as $i => $story)
            <div class="story-full-card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                <div class="story-full-header">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1rem;">
                        <div style="display:flex;align-items:center;gap:1rem;">
                            <img src="{{ asset('images/avatars/avatar' . ($i + 1) . '.png') }}" alt="{{ $story['name'] }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--border, #e2e8f0);box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div>
                                <div style="font-family:var(--font-heading);font-weight:700;font-size:1.1rem;color:var(--ink, #0f172a);">{{ $story['name'] }}</div>
                                <div style="color:var(--blue, #1d4ed8);font-weight:600;font-size:0.9rem;">{{ $story['achievement'] }}</div>
                                <div style="color:var(--muted, #64748b);font-size:0.8rem;">{{ $story['institution'] }}</div>
                            </div>
                        </div>
                    </div>
                <div class="story-full-body">
                    <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.25rem;">
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--blue, #1d4ed8);font-weight:700;margin-bottom:0.3rem;">Challenge</div>
                            <p style="font-size:0.875rem;color:var(--ink-3, #334155);line-height:1.6;">{{ $story['challenge'] }}</p>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--ink, #0f172a);font-weight:700;margin-bottom:0.3rem;">Strategy</div>
                            <p style="font-size:0.875rem;color:var(--ink-3, #334155);line-height:1.6;">{{ $story['strategy'] }}</p>
                        </div>
                        <div>
                            <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--green, #16a34a);font-weight:700;margin-bottom:0.3rem;">Victory</div>
                            <p style="font-size:0.875rem;color:var(--ink-3, #334155);line-height:1.6;">{{ $story['victory'] }}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-banner">
    <div class="container" style="position:relative;z-index:1;">
        <h2 class="cta-banner-title">Your Victory Story Starts Here</h2>
        <p class="cta-banner-desc">Join 5,000+ doctors who navigated the NEET-PG maze with data-driven confidence. Your dream branch is waiting.</p>
        <a href="{{ route('contact') }}" class="btn btn-lg btn-rounded" style="background:var(--blue, #1d4ed8);color:#fff;font-weight:600;box-shadow:0 10px 25px rgba(29, 78, 216, 0.3);">
            <i class="fa-solid fa-star"></i>
            Start Your Journey Today
        </a>
    </div>
</section>

@endsection
