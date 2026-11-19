@extends('layouts.dashboard')

@section('title', 'Colleges Directory - Medical Studio')

@section('content')
<style>
    .colleges-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 640px) {
        .colleges-grid {
            grid-template-columns: 1fr; /* Stack one by one on mobile */
        }
    }
</style>
<div style="max-width: 1200px; margin: 0 auto; overflow-x: hidden;">
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <span class="eyebrow" style="margin-bottom: 0.5rem;">Directory</span>
            <h1 class="section-title" style="margin: 0;">Medical Colleges</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Browse and filter through {{ $colleges->total() ?? 0 }} verified medical institutes.</p>
        </div>
        
        <form action="{{ route('colleges.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <select name="state_id" class="form-select" style="width: auto; padding: 0.5rem 1rem; border-radius: 8px;">
                <option value="">All States</option>
                @foreach(\App\Models\State::orderBy('name')->get() as $st)
                    <option value="{{ $st->id }}" {{ (request('state_id') == $st->id || request('state') == $st->id) ? 'selected' : '' }}>
                        {{ $st->name }}
                    </option>
                @endforeach
            </select>
            
            <select name="college_type" class="form-select" style="width: auto; padding: 0.5rem 1rem; border-radius: 8px;">
                <option value="">All Types</option>
                <option value="0" {{ request('college_type') === '0' ? 'selected' : '' }}>Government</option>
                <option value="1" {{ request('college_type') === '1' ? 'selected' : '' }}>Private</option>
                <option value="2" {{ request('college_type') === '2' ? 'selected' : '' }}>Deemed</option>
                <option value="3" {{ request('college_type') === '3' ? 'selected' : '' }}>Central</option>
            </select>

            @if(isset($courses) && count($courses) > 0)
            <select name="course_slug" class="form-select" style="width: auto; padding: 0.5rem 1rem; border-radius: 8px;">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->slug }}" {{ request('course_slug') == $course->slug ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            @endif
            
            <div style="display: flex; background: var(--white); border: 1px solid var(--border); border-radius: 8px; overflow: hidden;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search colleges..." style="padding: 0.5rem 1rem; border: none; background: transparent; color: var(--ink); outline: none;">
                <button type="submit" style="padding: 0.5rem 1rem; background: var(--bg-soft); border: none; border-left: 1px solid var(--border); color: var(--ink); cursor: pointer;">
                    <i class="fa-solid fa-search" style="font-size: 1rem;"></i>
                </button>
            </div>

            <select name="sort_by" class="form-select" style="width: auto; padding: 0.5rem 1rem; border-radius: 8px;" onchange="this.form.submit()">
                <option value="">Sort By...</option>
                <option value="general_rank" {{ request('sort_by') === 'general_rank' ? 'selected' : '' }}>Gen Rank (Low to High)</option>
                <option value="obc_rank" {{ request('sort_by') === 'obc_rank' ? 'selected' : '' }}>OBC Rank (Low to High)</option>
                <option value="sc_rank" {{ request('sort_by') === 'sc_rank' ? 'selected' : '' }}>SC Rank (Low to High)</option>
                <option value="st_rank" {{ request('sort_by') === 'st_rank' ? 'selected' : '' }}>ST Rank (Low to High)</option>
                <option value="total_seats" {{ request('sort_by') === 'total_seats' ? 'selected' : '' }}>Total Seats</option>
            </select>
            
            @if(request()->anyFilled(['state_id', 'state', 'college_type', 'search', 'course_slug', 'sort_by']))
                <a href="{{ route('colleges.index') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; border-radius: 8px;">Clear</a>
            @endif
        </form>
    </div>

    <div class="colleges-grid">
        @forelse($colleges as $college)
            <a href="{{ route('colleges.show', $college->slug) }}" style="display: flex; flex-direction: column; background: #fff; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.04); overflow: hidden; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="height: 240px; background: url('{{ $college->getImageUrl() }}') center/cover no-repeat; position: relative;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, transparent 40%, rgba(0,0,0,0.2) 100%);"></div>
                    <div style="position: absolute; top: 1rem; left: 1rem; display: flex; gap: 0.5rem;">
                        <span style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff; font-size: 0.75rem; font-weight: 500; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3);">
                            {{ $college->getTypeLabel() }}
                        </span>
                        @if($college->year_of_inspection)
                        <span style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff; font-size: 0.75rem; font-weight: 500; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3);">
                            Est. {{ $college->year_of_inspection }}
                        </span>
                        @endif
                    </div>
                    <div style="position: absolute; top: 1rem; right: 1rem;">
                        <span style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; gap: 4px;">
                            <i class="fa-solid fa-star" style="font-size: 0.65rem;"></i> {{ number_format(rand(42, 49) / 10, 1) }}
                        </span>
                    </div>
                    <div style="position: absolute; bottom: 1rem; left: 0; right: 0; display: flex; justify-content: center; gap: 5px;">
                        <div style="width: 5px; height: 5px; border-radius: 50%; background: #fff;"></div>
                        <div style="width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5);"></div>
                        <div style="width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5);"></div>
                        <div style="width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5);"></div>
                        <div style="width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5);"></div>
                    </div>
                </div>
                
                <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column;">
                    <h3 style="font-family: var(--font-heading); font-size: 1.15rem; font-weight: 600; color: #111; margin: 0 0 0.25rem 0; line-height: 1.3;">
                        {{ Str::limit($college->college_name, 45) }}
                    </h3>
                    
                    <p style="font-size: 0.85rem; color: #6b7280; margin: 0 0 1rem 0;">
                        {{ $college->place ?? 'City N/A' }} &bull; {{ $college->stateRelation->name ?? $college->state ?? 'State N/A' }}
                    </p>
                    
                    <p style="font-size: 0.85rem; color: #9ca3af; margin: 0 0 1.25rem 0; line-height: 1.5; flex: 1;">
                        A prominent medical institute offering quality clinical exposure and comprehensive academic programs in {{ $college->stateRelation->name ?? $college->state ?? 'India' }}.
                    </p>

                    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto;">
                        <div style="font-size: 1.05rem; font-weight: 600; color: #111;">
                            {{ $college->total_seats ?? 'N/A' }} <span style="font-size: 0.85rem; font-weight: 400; color: #6b7280;">/ seats</span>
                        </div>
                        

                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; background: var(--white); border: 1px dashed var(--border); border-radius: 16px; padding: 4rem 2rem; text-align: center;">
                <div class="icon-circle" style="margin: 0 auto 1rem;">
                    <i class="fa-solid fa-search"></i>
                </div>
                <h3 style="font-family: var(--font-heading); font-size: 1.2rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">No colleges found</h3>
                <p style="color: var(--muted); margin: 0;">Try adjusting your search filters.</p>
                <a href="{{ route('colleges.index') }}" class="btn btn-outline" style="margin-top: 1.5rem;">Clear Filters</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $colleges->withQueryString()->links('pagination::tailwind') }}
    </div>
</div>
@endsection
