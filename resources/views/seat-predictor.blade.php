@extends('layouts.app')

@section('title', 'Seat Predictor — Know Your NEET Choices | Medical Studio')
@section('meta_description', 'Use Medical Studio\'s free Seat Predictor to estimate your NEET choices by rank, category, and quota. Full results and institute list requires login.')

@section('content')

<section class="predictor-hero">
    <div class="container">
        <div class="text-center" style="position:relative;z-index:1;margin-bottom:3rem;">
            <span class="eyebrow" style="color:var(--muted);">Free Tool</span>
            <h1 class="display-xl text-ink" style="margin-top:0.75rem;">NEET Seat Predictor</h1>
            <p style="color:var(--muted);font-size:1.1rem;margin:1rem auto 0;max-width:500px;">Enter your rank and get an instant estimate of choices available across all quotas and categories.</p>
        </div>

        <div class="predictor-card" style="max-width:860px;margin:0 auto;position:relative;z-index:1;">
            {{-- Exam Selector --}}
            <div style="margin-bottom:1.5rem;">
                <div class="exam-tabs" id="predExamTabs">
                    @foreach(['NEET UG' => 'neet-ug', 'NEET PG' => 'neet-pg', 'NEET MDS' => 'neet-mds', 'NEET SS' => 'neet-ss', 'INICET' => 'inicet', 'DNB PDCET' => 'dnb-pdcet'] as $label => $val)
                    <button class="exam-tab {{ $val === 'neet-ug' ? 'active' : '' }}" data-exam="{{ $val }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>

            <div id="predictorEngine">
                <div class="predictor-grid">
                <div class="predictor-field">
                    <label>Preferred Counselling</label>
                    <select id="predCounselling">
                        <option value="all">All Quotas</option>
                        <option value="aiq" data-ug-text="All India Quota (AIQ) — 15%" data-pg-text="All India Quota (AIQ) — 50%">All India Quota (AIQ) — 15%</option>
                        <option value="state" data-ug-text="State Quota — 85%" data-pg-text="State Quota — 50%">State Quota — 85%</option>
                        <option value="deemed">Deemed Universities — 100%</option>
                        <option value="central">Central Universities (AIIMS/BHU/JIPMER)</option>
                    </select>
                </div>
                <div class="predictor-field">
                    <label>Category</label>
                    <select id="predCategory">
                        <option value="GEN">GEN (General / Unreserved)</option>
                        <option value="OBC">OBC</option>
                        <option value="SC">SC</option>
                        <option value="ST">ST</option>
                        <option value="EW">EW (EWS)</option>
                        <option value="EZ">EZ (Ezhava)</option>
                        <option value="MU">MU (Muslim)</option>
                        <option value="LA">LA (Latin Catholic)</option>
                        <option value="DV">DV (Dheevara)</option>
                        <option value="VK">VK (Viswakarma)</option>
                        <option value="BH">BH (Backward Hindu)</option>
                        <option value="BX">BX (Backward Christian)</option>
                        <option value="KN">KN (Kudumbi)</option>
                    </select>
                </div>
                <div class="predictor-field" id="stateFieldWrapper" style="display:none;">
                    <label>Domicile State</label>
                    <select id="predState">
                        <option value="">Select your state</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Rank Input --}}
            <div class="predictor-field" style="margin-bottom:1.5rem;">
                <label>Your All India Rank (AIR)</label>
                <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                    <input type="number" id="predRankNum" min="1" max="300000" value="25000" placeholder="Enter AIR..." style="width:200px;">
                    <input type="range" id="predRankSlider" min="1" max="300000" value="25000" style="flex:1;min-width:200px;">
                    <div style="font-family:var(--font-display);font-size:1.25rem;font-weight:700;color:var(--ink);min-width:80px;" id="predRankDisplay">25,000</div>
                </div>
            </div>

            <button onclick="runPredictor()" class="btn btn-red btn-lg btn-block" id="predictBtn">
                <i class="fa-solid fa-magnifying-glass-chart"></i>
                Calculate My Choices
            </button>

            {{-- Results --}}
            <div id="predResult" style="display:none;margin-top:1.5rem;">
                {{-- Summary Row --}}
                <div class="predictor-result" style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:space-between;align-items:center;">
                    <div>
                        <div style="color:rgba(255,255,255,0.5);font-size:0.875rem;margin-bottom:0.25rem;">You have approximately</div>
                        <div class="predictor-count"><span id="predCount">0</span><span class="highlight"> Choices</span></div>
                        <div class="predictor-label">across All India, Deemed &amp; Central Universities *</div>
                    </div>
                    <div style="text-align:right;">
                        @auth
                            @if(auth()->user()->subscribed ?? false)
                                <a href="{{ route('dashboard.rank-scan') }}" class="btn btn-red btn-sm">
                                    View All Choices <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            @else
                                <a href="{{ route('packages') }}" class="btn btn-red btn-sm">
                                    <i class="fa-solid fa-crown"></i> Upgrade to See Full List
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn btn-red btn-sm">
                                <i class="fa-solid fa-lock-open"></i> Login to Explore All
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- 3-Tier Classification --}}
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:1.25rem;">
                    <div style="background:rgba(16,185,129,0.08);border:1px solid rgba(16,185,129,0.25);border-radius:var(--r-lg,12px);padding:1.25rem;text-align:center;">
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#10B981;margin-bottom:0.35rem;">
                            <i class="fa-solid fa-circle-check"></i> High Chance
                        </div>
                        <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--ink);" id="predHigh">0</div>
                        <div style="font-size:0.75rem;color:var(--muted);">colleges</div>
                    </div>
                    <div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:var(--r-lg,12px);padding:1.25rem;text-align:center;">
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#F59E0B;margin-bottom:0.35rem;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Borderline
                        </div>
                        <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--ink);" id="predBorderline">0</div>
                        <div style="font-size:0.75rem;color:var(--muted);">colleges</div>
                    </div>
                    <div style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.25);border-radius:var(--r-lg,12px);padding:1.25rem;text-align:center;">
                        <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#EF4444;margin-bottom:0.35rem;">
                            <i class="fa-solid fa-xmark"></i> Low Chance
                        </div>
                        <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:var(--ink);" id="predLow">0</div>
                        <div style="font-size:0.75rem;color:var(--muted);">colleges</div>
                    </div>
                </div>
            </div>

            {{-- Locked Preview --}}
            <div id="lockedPreview" style="display:none;margin-top:1.5rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                    <h3 style="font-size:1rem;font-weight:700;">Institute Shortlist Preview</h3>
                    <span class="badge badge-red">
                        <i class="fa-solid fa-lock"></i> Login Required
                    </span>
                </div>
                <div class="lock-overlay">
                    <div class="blur-content" id="previewList">
                        {{-- Dynamically populated from API response --}}
                    </div>
                    <div class="lock-gate">
                        <i class="fa-solid fa-lock"></i>
                        <div style="text-align:center;">
                            <p style="font-weight:700;color:var(--ink);margin-bottom:0.5rem;">Full Institute List Locked</p>
                            <p style="font-size:0.85rem;color:var(--body-text);margin-bottom:1rem;">Login and subscribe to see all institutes for your rank</p>
                            <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
                                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-red btn-sm">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p style="font-size:0.75rem;color:var(--muted);margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border);">
                * Estimates based on historical closing rank data. Actual choices depend on official seat matrix for the current counselling year. Full verified results available with subscription.
            </p>
            </div>

            {{-- Lead Capture Form for PG --}}
            <div id="pgLeadForm" style="display:none; padding: 2.5rem 1.5rem; text-align: center; background: var(--bg-soft); border-radius: var(--r-lg); margin-top: 1.5rem; border: 1px solid var(--border);">
                <div style="width: 60px; height: 60px; background: rgba(225, 29, 72, 0.1); color: var(--red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 1.5rem;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-family: var(--font-display); font-weight: 800; color: var(--ink); margin-bottom: 0.5rem;">NEET PG Data Not Yet Available</h3>
                <p style="color: var(--body-text); margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">The official NEET PG 2026 details and ranks have not been released yet. Get notified instantly when the predictor is live.</p>
                <form action="{{ route('contact.submit') }}" method="POST" style="max-width: 400px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem;">
                    @csrf
                    <input type="hidden" name="name" value="NEET PG Predictor Lead">
                    <input type="hidden" name="enquiry_for" value="NEET PG Predictor Alert">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required style="padding: 0.875rem; border-radius: 8px; border: 1px solid var(--border);">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required style="padding: 0.875rem; border-radius: 8px; border: 1px solid var(--border);" maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                    <button type="submit" class="btn btn-red btn-block btn-lg" style="margin-top: 0.5rem;">
                        <i class="fa-solid fa-bell"></i> Notify Me
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Info Section --}}
<section class="section">
    <div class="container">
        <div class="grid-3" style="gap:2rem;">
            <div class="card reveal">
                <div class="icon-wrap"><i class="fa-solid fa-chart-line"></i></div>
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;margin-bottom:0.5rem;">How It Works</h3>
                <p class="body-sm">Our predictor uses 3 years of historical closing rank data from MCC official results. Enter your AIR, select your category and quota to get an instant estimate.</p>
            </div>
            <div class="card reveal reveal-d2">
                <div class="icon-wrap"><i class="fa-solid fa-unlock"></i></div>
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;margin-bottom:0.5rem;">Full Access</h3>
                <p class="body-sm">Free teaser shows your estimated count. Subscribers see the full verified institute list with course, quota, category, closing rank, fee, bond, and stipend details.</p>
            </div>
            <div class="card reveal reveal-d3">
                <div class="icon-wrap"><i class="fa-solid fa-shield-halved"></i></div>
                <h3 style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;margin-bottom:0.5rem;">Accuracy Promise</h3>
                <p class="body-sm">All data cross-verified with MCC official allotment PDFs, institutional websites, and state DME circulars. 98.7% prediction accuracy across 3 years of outcomes.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const predRankNum    = document.getElementById('predRankNum');
const predRankSlider = document.getElementById('predRankSlider');
const predRankDisplay= document.getElementById('predRankDisplay');
const predCounselling= document.getElementById('predCounselling');
const stateFieldWrapper = document.getElementById('stateFieldWrapper');

predRankNum.addEventListener('input', () => {
    predRankSlider.value = predRankNum.value;
    predRankDisplay.textContent = parseInt(predRankNum.value).toLocaleString('en-IN');
});
predRankSlider.addEventListener('input', () => {
    predRankNum.value = predRankSlider.value;
    predRankDisplay.textContent = parseInt(predRankSlider.value).toLocaleString('en-IN');
});

// Show/hide State dropdown based on counselling selection
predCounselling.addEventListener('change', () => {
    stateFieldWrapper.style.display = predCounselling.value === 'state' ? '' : 'none';
});

// Exam tab switching — also updates quota percentage text
let currentExam = 'neet-ug';
const aiqOption = predCounselling.querySelector('option[value="aiq"]');
const stateOption = predCounselling.querySelector('option[value="state"]');

function updateQuotaLabels() {
    const isPG = ['neet-pg', 'neet-mds', 'neet-ss', 'inicet', 'dnb-pdcet'].includes(currentExam);
    if (aiqOption) {
        aiqOption.textContent = isPG
            ? 'All India Quota (AIQ) — 50%'
            : 'All India Quota (AIQ) — 15%';
    }
    if (stateOption) {
        stateOption.textContent = isPG
            ? 'State Quota — 50%'
            : 'State Quota — 85%';
    }
}

document.querySelectorAll('#predExamTabs .exam-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('#predExamTabs .exam-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentExam = tab.dataset.exam;
        updateQuotaLabels();
        
        if (currentExam === 'neet-pg') {
            document.getElementById('predictorEngine').style.display = 'none';
            document.getElementById('pgLeadForm').style.display = 'block';
        } else {
            document.getElementById('predictorEngine').style.display = 'block';
            document.getElementById('pgLeadForm').style.display = 'none';
        }
    });
});

// Animate a counter from 0 to target
function animateCount(el, target) {
    let c = 0;
    const step = Math.max(1, Math.ceil(target / 40));
    const t = setInterval(() => {
        c = Math.min(c + step, target);
        el.textContent = c.toLocaleString('en-IN');
        if (c >= target) clearInterval(t);
    }, 25);
}

async function runPredictor() {
    const btn = document.getElementById('predictBtn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Calculating...';
    btn.disabled = true;

    try {
        const resp = await fetch('{{ url("/seat-predictor/calculate") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
            body: JSON.stringify({
                exam: currentExam,
                category: document.getElementById('predCategory').value,
                quota: predCounselling.value,
                rank: parseInt(predRankNum.value),
                state_id: document.getElementById('predState')?.value || '',
            })
        });
        const data = await resp.json();

        // Show results
        document.getElementById('predResult').style.display = 'block';
        document.getElementById('lockedPreview').style.display = 'block';

        // Animate main counter
        animateCount(document.getElementById('predCount'), data.count);

        // Animate tier counters
        animateCount(document.getElementById('predHigh'), data.high_chance);
        animateCount(document.getElementById('predBorderline'), data.borderline);
        animateCount(document.getElementById('predLow'), data.low_chance);

        // Populate preview list from server response
        const previewList = document.getElementById('previewList');
        previewList.innerHTML = '';
        if (data.preview && data.preview.length > 0) {
            data.preview.forEach(col => {
                const div = document.createElement('div');
                div.style.cssText = 'padding:0.75rem 1rem;border-bottom:1px solid var(--border);font-size:0.875rem;display:flex;justify-content:space-between;align-items:center;';
                div.innerHTML = `
                    <span style="color:var(--ink);font-weight:500;">${col.name}</span>
                    <span style="color:var(--muted);font-size:0.8rem;">${col.type} · Rank ${col.rank?.toLocaleString('en-IN') || 'N/A'}</span>
                `;
                previewList.appendChild(div);
            });
        } else {
            previewList.innerHTML = '<div style="padding:1rem;text-align:center;color:var(--muted);font-size:0.875rem;">No matching institutes found for this combination.</div>';
        }

    } catch (e) {
        alert('Something went wrong. Please try again.');
    }

    btn.innerHTML = '<i class="fa-solid fa-magnifying-glass-chart"></i> Recalculate';
    btn.disabled = false;
}
</script>

@if(session('pg_alert'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert("{{ session('pg_alert') }}");
    });
</script>
@endif

@endpush
