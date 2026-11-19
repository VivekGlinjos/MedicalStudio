@extends('layouts.dashboard')

@section('title', 'Rank Scan Engine - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--blue); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        <h1 class="section-title" style="margin: 0;">Rank Scan Engine</h1>
        <p style="color: var(--muted); margin-top: 0.5rem;">Input your NEET AIR and discover your likely college matches based on historical cutoffs.</p>
    </div>

    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <form action="{{ route('dashboard.rank-scan') }}" method="GET" class="filter-form">
            <div>
                <label class="form-label">NEET All India Rank (AIR)</label>
                <input type="number" name="rank" class="form-input" placeholder="e.g. 25000" value="{{ request('rank') }}" required>
            </div>
            <div>
                <label class="form-label">Category</label>
                <select name="category" class="form-input">
                    <option value="GEN" {{ request('category') == 'GEN' || request('category') == 'UR' ? 'selected' : '' }}>GEN (General / Unreserved)</option>
                    <option value="OBC" {{ request('category') == 'OBC' ? 'selected' : '' }}>OBC</option>
                    <option value="SC" {{ request('category') == 'SC' ? 'selected' : '' }}>SC</option>
                    <option value="ST" {{ request('category') == 'ST' ? 'selected' : '' }}>ST</option>
                    <option value="EW" {{ request('category') == 'EW' || request('category') == 'EWS' ? 'selected' : '' }}>EW (EWS)</option>
                    <option value="EZ" {{ request('category') == 'EZ' ? 'selected' : '' }}>EZ (Ezhava)</option>
                    <option value="MU" {{ request('category') == 'MU' ? 'selected' : '' }}>MU (Muslim)</option>
                    <option value="LA" {{ request('category') == 'LA' ? 'selected' : '' }}>LA (Latin Catholic)</option>
                    <option value="DV" {{ request('category') == 'DV' ? 'selected' : '' }}>DV (Dheevara)</option>
                    <option value="VK" {{ request('category') == 'VK' ? 'selected' : '' }}>VK (Viswakarma)</option>
                    <option value="BH" {{ request('category') == 'BH' ? 'selected' : '' }}>BH (Backward Hindu)</option>
                    <option value="BX" {{ request('category') == 'BX' ? 'selected' : '' }}>BX (Backward Christian)</option>
                    <option value="KN" {{ request('category') == 'KN' ? 'selected' : '' }}>KN (Kudumbi)</option>
                </select>
            </div>
            <div>
                <label class="form-label">Quota</label>
                <select name="quota" class="form-input">
                    <option value="all" {{ request('quota', 'all') == 'all' ? 'selected' : '' }}>All Quotas</option>
                    <option value="aiq" {{ request('quota') == 'aiq' ? 'selected' : '' }}>All India Quota (AIQ) — 15%</option>
                    <option value="state" {{ request('quota') == 'state' ? 'selected' : '' }}>State Quota — 85%</option>
                    <option value="deemed" {{ request('quota') == 'deemed' ? 'selected' : '' }}>Deemed Universities — 100%</option>
                    <option value="central" {{ request('quota') == 'central' ? 'selected' : '' }}>Central Universities (AIIMS/BHU/JIPMER)</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-teal" style="width: 100%;"><i class="fa-solid fa-radar" style="margin-right: 0.5rem;"></i> Scan Colleges</button>
            </div>
        </form>
    </div>

    @if(request()->filled('rank') && isset($predictedColleges))
        {{-- Summary Dashboard --}}
        <div class="card" style="margin-bottom: 2rem; padding: 1.5rem;">
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--muted); margin-bottom: 0.25rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">You have approximately</div>
                    <div style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 800; color: var(--ink); line-height: 1;">
                        {{ number_format($predictedColleges instanceof \Illuminate\Pagination\LengthAwarePaginator ? $predictedColleges->total() : $predictedColleges->count()) }} <span style="font-size: 1.25rem; color: var(--blue);">Choices</span>
                    </div>
                    <div style="font-size: 0.875rem; color: var(--muted); margin-top: 0.25rem;">across All India, Deemed & Central Universities *</div>
                </div>
                <div style="text-align: right;">
                    <button class="btn btn-blue" onclick="document.getElementById('scan-results-list').scrollIntoView({ behavior: 'smooth', block: 'start' })">
                        View List <i class="fa-solid fa-arrow-down" style="margin-left: 0.5rem;"></i>
                    </button>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.25); border-radius: var(--r-lg, 12px); padding: 1.25rem; text-align: center;">
                    <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #10B981; margin-bottom: 0.35rem;">
                        <i class="fa-solid fa-circle-check"></i> High Chance
                    </div>
                    <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--ink);">{{ number_format($highChance->count()) }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted);">colleges</div>
                </div>
                <div style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.25); border-radius: var(--r-lg, 12px); padding: 1.25rem; text-align: center;">
                    <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #F59E0B; margin-bottom: 0.35rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Borderline
                    </div>
                    <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--ink);">{{ number_format($borderline->count()) }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted);">colleges</div>
                </div>
                <div style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25); border-radius: var(--r-lg, 12px); padding: 1.25rem; text-align: center;">
                    <div style="font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #EF4444; margin-bottom: 0.35rem;">
                        <i class="fa-solid fa-xmark"></i> Low Chance
                    </div>
                    <div style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--ink);">{{ number_format($lowChance->count()) }}</div>
                    <div style="font-size: 0.75rem; color: var(--muted);">colleges</div>
                </div>
            </div>
        </div>

        <div id="scan-results-list" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0;">Institute Shortlist</h3>
            <span class="badge badge-navy">Showing {{ $predictedColleges->firstItem() ?? 0 }} - {{ $predictedColleges->lastItem() ?? 0 }} of {{ $predictedColleges->total() }}</span>
        </div>

        @if($predictedColleges->isEmpty())
            <div class="card" style="padding: 4rem 2rem; text-align: center;">
                <div class="icon-circle" style="margin: 0 auto 1rem;"><i class="fa-solid fa-triangle-exclamation" style="color: var(--blue);"></i></div>
                <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">No Matches Found</h3>
                <p style="color: var(--muted); margin: 0;">We couldn't find any historical cutoffs matching your rank under this category and quota.</p>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($predictedColleges as $cutoff)
                <div class="card rank-scan-card" style="padding: 1.25rem; display: flex; gap: 1.5rem; align-items: center; transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="college-icon" style="width: 64px; height: 64px; flex-shrink: 0; background: var(--bg-soft); border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--blue); overflow: hidden;">
                        @if($cutoff->college?->hasImage())
                            <img src="{{ $cutoff->college->getImageUrl() }}" alt="{{ $cutoff->college->college_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-building-columns"></i>
                        @endif
                    </div>
                    <div style="flex-grow: 1;">
                        <h4 style="margin: 0 0 0.35rem; font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700;">
                            <a href="{{ $cutoff->college && $cutoff->college->slug ? route('colleges.show', $cutoff->college->slug) : '#' }}" style="color: var(--ink); text-decoration: none;">
                                {{ $cutoff->college?->college_name ?? 'Unknown College' }}
                            </a>
                        </h4>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; font-size: 0.8rem; color: var(--muted); margin-bottom: 0.75rem;">
                            <span><i class="fa-solid fa-location-dot" style="margin-right: 0.25rem;"></i> {{ $cutoff->college?->stateRelation?->name ?? $cutoff->college?->state ?? 'Unknown State' }}</span>
                            <span style="width: 4px; height: 4px; background: var(--border); border-radius: 50%;"></span>
                            <span class="badge" style="background: rgba(29, 78, 216, 0.1); color: var(--blue); padding: 0.2rem 0.5rem; font-size: 0.7rem;">{{ $cutoff->course?->name ?? 'N/A' }}</span>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; font-size: 0.85rem; background: var(--bg-soft); padding: 0.75rem 1rem; border-radius: 8px;">
                            <div><span style="color: var(--muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; display: block; margin-bottom: 0.1rem;">Round</span> <span style="font-weight: 600; color: var(--ink);">{{ $cutoff->round }}</span></div>
                            <div><span style="color: var(--muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; display: block; margin-bottom: 0.1rem;">Closing Rank</span> <span style="font-weight: 700; color: var(--ink); font-family: monospace; font-size: 1rem;">{{ number_format($cutoff->closing_rank) }}</span></div>
                            <div><span style="color: var(--muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; display: block; margin-bottom: 0.1rem;">Score</span> <span style="font-weight: 600; color: var(--ink);">{{ $cutoff->closing_score }}</span></div>
                        </div>
                    </div>
                    <div style="flex-shrink: 0; padding-left: 1rem;">
                        <a href="{{ $cutoff->college && $cutoff->college->slug ? route('colleges.show', $cutoff->college->slug) : '#' }}" class="btn btn-outline" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($predictedColleges->hasPages())
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    {{ $predictedColleges->links() }}
                </div>
            @endif
        @endif
    @endif
</div>

<style>
    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }
    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .filter-form button {
            width: 100%;
        }
    }
</style>
@endsection
