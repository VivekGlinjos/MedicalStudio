@extends('layouts.dashboard')

@section('title', 'States Directory - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <span class="eyebrow" style="margin-bottom: 0.5rem;">Directory</span>
            <h1 class="section-title" style="margin: 0;">State Wise Data</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Explore {{ count($states) }} states and their counselling data.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($states as $state)
            <div class="card-feature" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <div class="icon-circle" style="margin: 0;">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <div style="flex: 1;">
                    <h3 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0 0 0.25rem 0;">
                        {{ $state->name }}
                    </h3>
                    <a href="{{ route('colleges.index', ['state' => $state->id]) }}" style="font-size: 0.8rem; font-weight: 700; color: var(--blue); text-decoration: none;">View Colleges &rarr;</a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background: var(--white); border: 1px dashed var(--border); border-radius: 16px; padding: 4rem 2rem; text-align: center;">
                <div class="icon-circle" style="margin: 0 auto 1rem;">
                    <i class="fa-solid fa-map"></i>
                </div>
                <h3 style="font-family: var(--font-heading); font-size: 1.2rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">No states found</h3>
                <p style="color: var(--muted); margin: 0;">We couldn't find any states in the database.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
