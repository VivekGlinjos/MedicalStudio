@extends('layouts.dashboard')

@section('title', 'Seat Matrix - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--blue); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
        <h1 class="section-title" style="margin: 0;">Seat Matrix</h1>
        <p style="color: var(--muted); margin-top: 0.5rem;">Track available seats across colleges by state and course.</p>
    </div>

    <div class="card" style="padding: 2rem; margin-bottom: 2rem;">
        <form action="{{ route('dashboard.seat-matrix') }}" method="GET" class="filter-form">
            <div style="flex: 1;">
                <label class="form-label">Filter by State</label>
                <select name="state_id" class="form-input">
                    <option value="">All States</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1;">
                <label class="form-label">Filter by Course</label>
                <select name="course_id" class="form-input">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-teal"><i class="fa-solid fa-filter" style="margin-right: 0.5rem;"></i> Apply Filters</button>
            </div>
            @if(request()->has('state_id') || request()->has('course_id'))
            <div>
                <a href="{{ route('dashboard.seat-matrix') }}" class="btn" style="background: var(--bg-soft); color: var(--ink);">Clear</a>
            </div>
            @endif
        </form>
    </div>

    @if($seatMatrices->isEmpty())
        <div class="card" style="padding: 4rem 2rem; text-align: center;">
            <div class="icon-circle" style="margin: 0 auto 1rem;"><i class="fa-solid fa-chair" style="color: var(--teal);"></i></div>
            <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">No Seats Found</h3>
            <p style="color: var(--muted); margin: 0;">No seat matrix data found for the selected filters.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($seatMatrices as $college)
            <div class="card seat-matrix-card" style="padding: 1.25rem; display: flex; gap: 1.5rem; align-items: center; transition: transform 0.2s, box-shadow 0.2s;">
                <div class="college-icon" style="width: 64px; height: 64px; flex-shrink: 0; background: var(--bg-soft); border: 1px solid var(--border); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; color: var(--teal); overflow: hidden;">
                    @if($college->hasImage())
                        <img src="{{ $college->getImageUrl() }}" alt="{{ $college->college_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-building-columns"></i>
                    @endif
                </div>
                <div style="flex-grow: 1;">
                    <h4 style="margin: 0 0 0.35rem; font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700;">
                        <a href="{{ $college->slug ? route('colleges.show', $college->slug) : '#' }}" style="color: var(--ink); text-decoration: none;">
                            {{ $college->college_name ?? 'Unknown College' }}
                        </a>
                    </h4>
                    
                    @php
                        $uniqueCourses = $college->seatMatrices->pluck('course')->unique('id')->filter();
                    @endphp

                    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; font-size: 0.8rem; color: var(--muted); margin-bottom: 0.75rem;">
                        <span><i class="fa-solid fa-location-dot" style="margin-right: 0.25rem;"></i> {{ $college->stateRelation->name ?? $college->state ?? 'Unknown State' }}</span>
                        <span style="width: 4px; height: 4px; background: var(--border); border-radius: 50%;"></span>
                        @foreach($uniqueCourses as $course)
                            <span class="badge" style="background: rgba(20, 184, 166, 0.1); color: var(--teal); padding: 0.2rem 0.5rem; font-size: 0.7rem;">{{ $course->name ?? 'N/A' }}</span>
                        @endforeach
                    </div>
                    
                    <div style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($uniqueCourses as $course)
                        <button class="btn btn-outline save-to-choice-btn" 
                                data-college-id="{{ $college->id }}" 
                                data-course-id="{{ $course->id }}"
                                style="font-size: 0.85rem; padding: 0.5rem 1rem;">
                            <i class="fa-solid fa-bookmark" style="margin-right: 0.5rem;"></i> Save {{ $course->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
                <div style="flex-shrink: 0; padding-left: 1rem;">
                    <a href="{{ $college->slug ? route('colleges.show', $college->slug) : '#' }}" class="btn btn-outline" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    
    <div style="margin-top: 1.5rem;">
        {{ $seatMatrices->links('pagination::tailwind') }}
    </div>
</div>

<style>
    .filter-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
    }
    @media (max-width: 768px) {
        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-form > div {
            width: 100%;
        }
        .filter-form button, .filter-form a {
            width: 100%;
            text-align: center;
        }
        
        .seat-matrix-table thead {
            display: none;
        }
        .seat-matrix-table, 
        .seat-matrix-table tbody {
            display: block;
            width: 100%;
        }
        .seat-matrix-table tbody tr {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            width: 100%;
        }
        .seat-matrix-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0 !important;
            border: none !important;
            text-align: right !important;
        }
        .seat-matrix-table td:first-child {
            flex-direction: column;
            align-items: flex-start;
            text-align: left !important;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid var(--border) !important;
            padding-bottom: 1rem !important;
        }
        .seat-matrix-table td::before {
            content: attr(data-label);
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
        }
        .seat-matrix-table td:first-child::before {
            display: none;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.save-to-choice-btn');
    
    buttons.forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const collegeId = this.dataset.collegeId;
            const courseId = this.dataset.courseId;
            const originalText = this.innerHTML;
            
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 0.5rem;"></i> Saving...';
            this.disabled = true;
            
            try {
                // First get active list
                const listRes = await fetch('{{ url("/api/choice-list/active") }}');
                const listData = await listRes.json();
                
                if(!listData || !listData.list) {
                    alert('Session expired. Please log in again.');
                    window.location.reload();
                    return;
                }
                
                let csrfToken = '';
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (tokenMeta) csrfToken = tokenMeta.getAttribute('content');
                
                // Now store the choice
                const storeRes = await fetch('{{ url("/api/choice-list/store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        list_id: listData.list.id,
                        college_id: collegeId,
                        course_id: courseId,
                        quota: 'AIQ', // Default for now
                        category: 'UR'
                    })
                });
                
                if(storeRes.ok) {
                    this.innerHTML = '<i class="fa-solid fa-check" style="margin-right: 0.5rem;"></i> Saved Successfully!';
                    this.classList.remove('btn-outline');
                    this.classList.add('btn-teal');
                    
                    // Reset after 3 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        this.classList.add('btn-outline');
                        this.classList.remove('btn-teal');
                    }, 3000);
                } else {
                    throw new Error('Failed to save to list');
                }
            } catch(e) {
                console.error(e);
                alert('An error occurred while saving. Please try again.');
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    });
});
</script>
@endsection
