@extends('layouts.app')

@section('title', 'Medical Admissions Blog — Insights, Tips & Guides | Medical Studio')
@section('meta_description', 'Expert articles on NEET-PG, NEET-UG, MBBS, MD, MS, BDS & MDS admissions. Stay updated with counselling strategies, college comparisons, and exam insights.')

@section('content')

{{-- HERO --}}
<section class="page-hero" style="position: relative; background-image: url('{{ asset('images/hero_bg_medical.png') }}'); background-size: cover; background-position: center; overflow: hidden;">
    {{-- Minimal Professional Overlay --}}
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,255,255,0.85) 0%, rgba(248,250,252,0.95) 100%); z-index: 0;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <span class="eyebrow-dim reveal">Knowledge Hub</span>
        <h1 class="page-hero-title reveal reveal-d1">
            Medical Admissions<br><span style="color:var(--teal);">Insights & Guides</span>
        </h1>
        <p class="page-hero-desc reveal reveal-d2">
            Expert articles to help you navigate NEET counselling, college selection, and everything in between.
        </p>
    </div>
</section>

{{-- BLOG CONTENT --}}
<section class="section" style="border-top:1px solid var(--border-d);">
    <div class="container">

        {{-- Category Filters --}}
        @if($categories->count() > 0)
        <div class="blog-filters reveal">
            <a href="{{ route('blog') }}" class="blog-filter-btn {{ !$category ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
            <a href="{{ route('blog', ['category' => $cat]) }}" class="blog-filter-btn {{ $category === $cat ? 'active' : '' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- Posts Grid --}}
        @if($posts->count())
        <div class="blog-grid reveal">
            @foreach($posts as $post)
            <div class="blog-card">
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-img" style="display:block;">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy">
                    @else
                        <div class="blog-card-img-placeholder">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                    @endif
                </a>
                <div class="blog-card-body">
                    <span class="blog-card-category">{{ $post->category }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-title" style="display:block;">{{ $post->title }}</a>
                    <div class="blog-card-excerpt">{{ $post->excerpt }}</div>
                    <div class="blog-card-meta">
                        <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-read">
                            Read <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($posts->hasPages())
        <div style="margin-top:3rem;display:flex;justify-content:center;">
            {{ $posts->links('pagination::tailwind') }}
        </div>
        @endif

        @else
        <div style="text-align:center;padding:6rem 0;">
            <i class="fa-solid fa-newspaper" style="font-size:3.5rem;color:rgba(255,255,255,.1);margin-bottom:1.5rem;display:block;"></i>
            <div style="font-family:var(--font-display);font-size:2.5rem;color:#fff;margin-bottom:.5rem;">Articles Coming Soon</div>
            <p style="color:rgba(255,255,255,.3);margin-bottom:2rem;">We're working on expert content. Check back soon!</p>
            <a href="{{ route('home') }}" class="btn btn-teal">Back to Home</a>
        </div>
        @endif

    </div>
</section>

{{-- CTA --}}
<section class="dark-cta-section">
    <div class="container">
        <div class="dark-cta-inner">
            <span class="eyebrow-dim reveal">Stay Updated</span>
            <div class="dark-cta-title reveal reveal-d1">Get Expert<br>Counselling<br><em>Directly</em></div>
            <p style="color:rgba(255,255,255,.3);font-size:.9rem;line-height:1.75;margin-top:.75rem;" class="reveal reveal-d2">
                Call or WhatsApp us to get the latest NEET counselling insights directly from our experts.
            </p>
            <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;margin-top:2rem;" class="reveal reveal-d3">
                <a href="{{ route('contact') }}" class="btn btn-teal btn-lg"><i class="fa-solid fa-comments"></i> Talk to Expert</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const io = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting){ x.target.classList.add('visible'); io.unobserve(x.target); } }), { threshold:.07 });
document.querySelectorAll('.reveal,.reveal-d1,.reveal-d2,.reveal-d3').forEach(el => io.observe(el));
const nav = document.getElementById('mainNavbar');
if(nav) window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 20), { passive:true });
</script>
@endpush
