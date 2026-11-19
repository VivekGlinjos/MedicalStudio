@extends('layouts.dashboard')

@section('content')
<style>
    /* Styling for the Zynerd-like UI */
    .search-container {
        max-width: 700px;
        margin: 0 auto;
    }
    .search-input-wrapper {
        position: relative;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        background: white;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .search-input-wrapper i {
        color: #94a3b8;
        font-size: 1.1rem;
    }
    .search-input-wrapper input {
        border: none;
        outline: none;
        width: 100%;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        box-shadow: none;
    }
    .filter-btn {
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        background: white;
        padding: 0.5rem 2rem;
        font-weight: 500;
        color: #334155;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .filter-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Modal styling */
    .filter-modal .modal-content {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }
    .filter-modal .modal-header {
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
    }
    .filter-layout {
        display: flex;
        height: 60vh;
        min-height: 400px;
    }
    .filter-sidebar {
        width: 30%;
        background: #f8fafc;
        border-right: 1px solid #f1f5f9;
        overflow-y: auto;
    }
    .filter-content {
        width: 70%;
        padding: 1rem;
        overflow-y: auto;
        background: white;
    }
    @media (max-width: 768px) {
        .filter-sidebar {
            width: 40%;
        }
        .filter-content {
            width: 60%;
        }
        .filter-layout {
            height: 70vh;
        }
    }
    .filter-tab {
        padding: 1rem;
        cursor: pointer;
        border-left: 3px solid transparent;
        font-weight: 500;
        color: #64748b;
        transition: all 0.2s;
    }
    .filter-tab.active {
        background: white;
        border-left-color: #2563eb; /* Blue border */
        color: #2563eb; /* Blue text */
        font-weight: 700;
    }
    .filter-tab:hover:not(.active) {
        background: #f1f5f9;
    }
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        cursor: pointer;
    }
    .checkbox-item input[type="checkbox"] {
        width: 1.1rem;
        height: 1.1rem;
        cursor: pointer;
        margin: 0;
    }
    .checkbox-item label {
        margin: 0;
        cursor: pointer;
        color: #334155;
        font-weight: 500;
    }

    /* Card styling */
    .allotment-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        padding: 1.5rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .allotment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
    }
    .card-title-link {
        color: #0f172a;
        font-weight: 700;
        text-decoration: none;
        font-size: 1.1rem;
        line-height: 1.4;
        display: block;
        margin-bottom: 0.5rem;
    }
    .card-title-link:hover {
        color: var(--teal, #0ea5e9);
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
    }
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    .detail-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    .detail-val {
        font-size: 0.9rem;
        color: #334155;
        font-weight: 700;
    }
</style>

<div class="container-fluid px-lg-4 py-5" style="background: #f8fafc; min-height: 100vh;" id="mainContainer">
    
    <!-- Search Section -->
    <div class="search-container text-center mb-5">
        <h1 class="h3 fw-bold mb-4" style="color: #0f172a; font-family: 'Inter', sans-serif;">Past Allotments in India</h1>
        
        <form action="{{ route('past-allotments.index') }}" method="GET" id="searchForm">
            <div class="search-input-wrapper mb-3">
                <i class="fa fa-search ms-2"></i>
                <input type="text" name="search" placeholder="Search institutes" value="{{ request('search') }}" onkeypress="if(event.keyCode == 13) { this.form.submit(); return false; }">
            </div>
            
            <button type="button" class="filter-btn" id="filterBtn">
                <i class="fa-solid fa-sliders me-2"></i> Filters
            </button>
        </form>

        <div class="text-muted small mt-3">{{ $cutoffs->total() }} Institutes found</div>
    </div>

    <!-- Results Grid -->
    <div class="row g-4 mb-4">
        @forelse($cutoffs as $cutoff)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="allotment-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-light text-dark border">{{ $cutoff->course->name ?? 'N/A' }}</span>
                    <span class="badge" style="background: #eff6ff; color: #2563eb;">{{ $cutoff->year }} - R{{ $cutoff->round }}</span>
                </div>
                
                <a href="{{ route('colleges.show', $cutoff->college->slug ?? $cutoff->college_id) }}" class="card-title-link">
                    {{ $cutoff->college->college_name ?? 'Unknown College' }}
                </a>
                
                <div class="small text-muted mb-3">
                    <i class="fa-solid fa-location-dot me-1"></i> {{ $cutoff->college->stateRelation->name ?? $cutoff->college->state ?? 'N/A' }}
                </div>

                <div class="detail-grid flex-grow-1">
                    <div class="detail-item">
                        <span class="detail-label">Category</span>
                        <span class="detail-val text-success">{{ $cutoff->category }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Quota</span>
                        <span class="detail-val">{{ $cutoff->quota }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Closing Rank</span>
                        <span class="detail-val" style="font-family: monospace; font-size: 1rem;">{{ number_format($cutoff->closing_rank) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Score</span>
                        <span class="detail-val">{{ $cutoff->closing_score ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-auto">
                    <button class="btn btn-outline-primary w-100 save-to-choice-btn rounded-pill" 
                            data-college-id="{{ $cutoff->college_id }}" 
                            data-course-id="{{ $cutoff->course_id }}"
                            data-quota="{{ $cutoff->quota }}"
                            data-category="{{ $cutoff->category }}">
                        <i class="fa-solid fa-bookmark me-1"></i> Save to Choice List
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px;">
                <i class="fa-solid fa-search fs-2 text-muted opacity-50"></i>
            </div>
            <h5 class="fw-bold" style="color: #334155;">No records found</h5>
            <p class="text-muted mb-4">Try adjusting your filters to see more results.</p>
            <a href="{{ route('past-allotments.index') }}" class="btn btn-primary rounded-pill px-4">Clear All Filters</a>
        </div>
        @endforelse
    </div>

    @if($cutoffs->hasPages())
    <div class="d-flex justify-content-center mt-4 mb-5">
        {{ $cutoffs->links('pagination::bootstrap-5') }}
    </div>
    @endif

    <!-- Filter Modal -->
    <div class="modal-overlay" id="filterModalContainer" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
        <div class="filter-modal" id="filterModalInner" style="width: 100%; max-width: 800px; margin: 1rem;">
            <div class="modal-content" style="background: white; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; max-height: 90vh;">
                <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                    <h5 class="modal-title fw-bold m-0" id="filterModalLabel">Filters</h5>
                    <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close" style="background: transparent; border: none; font-size: 1.25rem;"><i class="fa-solid fa-xmark"></i></button>
                </div>
            <form action="{{ route('past-allotments.index') }}" method="GET" id="modalFilterForm">
                <!-- Preserve search query -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                
                <div class="filter-layout">
                    <!-- Tabs -->
                    <div class="filter-sidebar">
                        <div class="filter-tab active" onclick="switchFilterTab('stateTab', this)">State</div>
                        <div class="filter-tab" onclick="switchFilterTab('courseTab', this)">Course</div>
                        <div class="filter-tab" onclick="switchFilterTab('typeTab', this)">Institute Type</div>
                        <div class="filter-tab" onclick="switchFilterTab('yearTab', this)">Year</div>
                        <div class="filter-tab" onclick="switchFilterTab('roundTab', this)">Round</div>
                        <div class="filter-tab" onclick="switchFilterTab('categoryTab', this)">Category</div>
                        <div class="filter-tab" onclick="switchFilterTab('quotaTab', this)">Quota</div>
                    </div>
                    
                    <!-- Content -->
                    <div class="filter-content">
                        <!-- State Tab Content -->
                        <div id="stateTab" class="filter-pane" style="display: block;">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-sm rounded-pill" id="searchState" placeholder="Search state..." onkeyup="filterCheckboxes('stateList', this.value)">
                            </div>
                            <div id="stateList">
                                @foreach($states as $s)
                                <div class="checkbox-item">
                                    <input type="checkbox" name="state_id[]" value="{{ $s->id }}" id="state_{{ $s->id }}" {{ (is_array(request('state_id')) && in_array($s->id, request('state_id'))) || request('state_id') == $s->id ? 'checked' : '' }}>
                                    <label for="state_{{ $s->id }}">{{ $s->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Course Tab Content -->
                        <div id="courseTab" class="filter-pane" style="display: none;">
                            <div id="courseList">
                                @foreach($courses as $c)
                                <div class="checkbox-item">
                                    <input type="checkbox" name="course_id[]" value="{{ $c->id }}" id="course_{{ $c->id }}" {{ (is_array(request('course_id')) && in_array($c->id, request('course_id'))) || request('course_id') == $c->id ? 'checked' : '' }}>
                                    <label for="course_{{ $c->id }}">{{ $c->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Type Tab Content -->
                        <div id="typeTab" class="filter-pane" style="display: none;">
                            <div class="checkbox-item">
                                <input type="checkbox" name="college_type[]" value="0" id="type_0" {{ (is_array(request('college_type')) && in_array('0', request('college_type'))) || request('college_type') === '0' ? 'checked' : '' }}>
                                <label for="type_0">Government</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="college_type[]" value="1" id="type_1" {{ (is_array(request('college_type')) && in_array('1', request('college_type'))) || request('college_type') === '1' ? 'checked' : '' }}>
                                <label for="type_1">Private</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="college_type[]" value="2" id="type_2" {{ (is_array(request('college_type')) && in_array('2', request('college_type'))) || request('college_type') === '2' ? 'checked' : '' }}>
                                <label for="type_2">Deemed</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="college_type[]" value="3" id="type_3" {{ (is_array(request('college_type')) && in_array('3', request('college_type'))) || request('college_type') === '3' ? 'checked' : '' }}>
                                <label for="type_3">Central</label>
                            </div>
                        </div>

                        <!-- Year Tab Content -->
                        <div id="yearTab" class="filter-pane" style="display: none;">
                            @foreach($years as $yr)
                            <div class="checkbox-item">
                                <input type="checkbox" name="year[]" value="{{ $yr }}" id="year_{{ $yr }}" {{ (is_array(request('year')) && in_array($yr, request('year'))) || request('year') == $yr ? 'checked' : '' }}>
                                <label for="year_{{ $yr }}">{{ $yr }}</label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Round Tab Content -->
                        <div id="roundTab" class="filter-pane" style="display: none;">
                            @foreach($rounds as $r)
                            <div class="checkbox-item">
                                <input type="checkbox" name="round[]" value="{{ $r }}" id="round_{{ $r }}" {{ (is_array(request('round')) && in_array($r, request('round'))) || request('round') == $r ? 'checked' : '' }}>
                                <label for="round_{{ $r }}">Round {{ $r }}</label>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Category Tab Content -->
                        <div id="categoryTab" class="filter-pane" style="display: none;">
                            @foreach($categories as $cat)
                            <div class="checkbox-item">
                                <input type="checkbox" name="category[]" value="{{ $cat }}" id="cat_{{ Str::slug($cat) }}" {{ (is_array(request('category')) && in_array($cat, request('category'))) || request('category') == $cat ? 'checked' : '' }}>
                                <label for="cat_{{ Str::slug($cat) }}">{{ $cat }}</label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Quota Tab Content -->
                        <div id="quotaTab" class="filter-pane" style="display: none;">
                            @foreach($quotas as $q)
                            <div class="checkbox-item">
                                <input type="checkbox" name="quota[]" value="{{ $q }}" id="quota_{{ Str::slug($q) }}" {{ (is_array(request('quota')) && in_array($q, request('quota'))) || request('quota') == $q ? 'checked' : '' }}>
                                <label for="quota_{{ Str::slug($q) }}">{{ $q }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light d-flex justify-content-between align-items-center" style="padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('past-allotments.index') }}" class="text-decoration-underline text-muted">Clear filters</a>
                    <button type="submit" class="btn text-white rounded-pill px-4 py-2" style="background: #f97316; font-weight: 600;">View results</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
function switchFilterTab(tabId, el) {
    // hide all panes
    document.querySelectorAll('.filter-pane').forEach(p => p.style.display = 'none');
    // show target pane
    document.getElementById(tabId).style.display = 'block';
    
    // remove active from all tabs
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    // add active to clicked
    el.classList.add('active');
}

function filterCheckboxes(listId, query) {
    const list = document.getElementById(listId);
    const items = list.querySelectorAll('.checkbox-item');
    query = query.toLowerCase();
    
    items.forEach(item => {
        const label = item.querySelector('label').innerText.toLowerCase();
        if (label.includes(query)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Modal Toggle Logic
    const filterBtn = document.getElementById('filterBtn');
    const modalContainer = document.getElementById('filterModalContainer');
    const modalInner = document.getElementById('filterModalInner');
    const closeBtn = document.getElementById('closeModalBtn');

    if(filterBtn && modalContainer && closeBtn && modalInner) {
        filterBtn.addEventListener('click', function() {
            modalContainer.style.display = 'flex';
        });

        closeBtn.addEventListener('click', function() {
            modalContainer.style.display = 'none';
        });

        modalContainer.addEventListener('click', function(e) {
            // Close if clicking outside the modal content
            if (!modalInner.contains(e.target)) {
                modalContainer.style.display = 'none';
            }
        });
    }

    // Choice List Save Logic
    const buttons = document.querySelectorAll('.save-to-choice-btn');
    
    buttons.forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            const collegeId = this.dataset.collegeId;
            const courseId = this.dataset.courseId;
            const quota = this.dataset.quota || 'AIQ';
            const category = this.dataset.category || 'UR';
            const originalText = this.innerHTML;
            
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...';
            this.disabled = true;
            
            try {
                // First get active list
                const listRes = await fetch('{{ url("/api/choice-list/active") }}');
                const listData = await listRes.json();
                
                if(!listData || !listData.list) {
                    alert('Session expired or no active choice list found. Please log in or create a list first.');
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
                        quota: quota,
                        category: category
                    })
                });
                
                if(storeRes.ok) {
                    this.innerHTML = '<i class="fa-solid fa-check me-1"></i> Saved!';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success', 'text-white');
                    
                    // Reset after 3 seconds
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        this.classList.add('btn-outline-primary');
                        this.classList.remove('btn-success', 'text-white');
                    }, 3000);
                } else {
                    const data = await storeRes.json();
                    throw new Error(data.message || 'Failed to save');
                }
            } catch(e) {
                console.error(e);
                alert(e.message || 'An error occurred while saving. Please try again.');
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    });
});
</script>
@endsection
