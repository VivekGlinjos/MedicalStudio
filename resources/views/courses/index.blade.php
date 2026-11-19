@extends('layouts.dashboard')

@section('title', 'Courses Directory - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <span class="eyebrow" style="margin-bottom: 0.5rem;">Directory</span>
            <h1 class="section-title" style="margin: 0;">Medical Courses</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Browse available {{ count($courses) }} courses across different levels.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($courses as $course)
            <div class="card-feature" style="padding: 0; overflow: hidden; border-radius: 16px; display: flex; flex-direction: column; height: 100%;">
                @if($course->image)
                    <div style="width: 100%; height: 160px; overflow: hidden; position: relative;">
                        <img src="{{ Str::startsWith($course->image, ['http://', 'https://']) ? $course->image : asset('storage/' . $course->image) }}" alt="{{ $course->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 1rem; right: 1rem;">
                            <span class="badge badge-navy" style="background: rgba(10, 37, 64, 0.9); color: white; backdrop-filter: blur(4px);">{{ $course->level }}</span>
                        </div>
                    </div>
                @else
                    <div style="width: 100%; height: 160px; background: var(--surface); display: flex; align-items: center; justify-content: center; position: relative;">
                        <div class="icon-circle" style="background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                            @if($course->level === 'UG')
                                <i class="fa-solid fa-stethoscope"></i>
                            @elseif($course->level === 'PG')
                                <i class="fa-solid fa-user-doctor"></i>
                            @elseif($course->level === 'SS')
                                <i class="fa-solid fa-star-of-life"></i>
                            @else
                                <i class="fa-solid fa-graduation-cap"></i>
                            @endif
                        </div>
                        <div style="position: absolute; top: 1rem; right: 1rem;">
                            <span class="badge badge-navy" style="background: rgba(10, 37, 64, 0.9); color: white; backdrop-filter: blur(4px);">{{ $course->level }}</span>
                        </div>
                    </div>
                @endif
                
                <div style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                    <h3 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">{{ $course->name }}</h3>
                    
                    @if($course->short_note)
                        <div style="font-size: 0.85rem; color: var(--muted); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-certificate"></i> {{ $course->short_note }}
                        </div>
                    @endif
                    
                    <a href="{{ route('colleges.index', ['course_slug' => $course->slug]) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--blue); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; margin-top: auto;">
                        View Colleges <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: var(--white); border: 1px dashed var(--border); border-radius: 16px; padding: 4rem 2rem; text-align: center;">
                <div class="icon-circle" style="margin: 0 auto 1rem;">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 style="font-family: var(--font-heading); font-size: 1.2rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">No courses found</h3>
                <p style="color: var(--muted); margin: 0;">We couldn't find any courses in the database.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
