@extends('layouts.app')

@section('title', $post->title . ' — Medical Studio Blog')
@section('meta_description', $post->excerpt)

@section('content')

{{-- Minimal Blog Header --}}
<section class="blog-hero-pg" style="padding-top: calc(var(--bar-h) + var(--nav-h) + 2rem); padding-bottom: 3rem; background: var(--bg-soft); border-bottom: 1px solid var(--border);">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <a href="{{ route('blog') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--blue); font-size: 0.85rem; font-weight: 600; text-decoration: none; margin-bottom: 1.5rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
            <i class="fa-solid fa-arrow-left"></i> Back to Blog
        </a>

        @if($post->category)
        <div>
            <span style="display: inline-block; background: var(--blue-dim); color: var(--blue); padding: 4px 12px; border-radius: 4px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 1rem;">
                {{ $post->category }}
            </span>
        </div>
        @endif

        <h1 style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.05; color: var(--ink); margin: 0 0 1.25rem 0; text-transform: uppercase;">
            {{ $post->title }}
        </h1>

        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; font-size: 0.85rem; color: var(--muted); font-weight: 500;">
            <span style="display: flex; align-items: center; gap: 0.4rem;">
                <i class="fa-solid fa-user" style="color: var(--blue); font-size: 0.75rem;"></i>
                {{ $post->author }}
            </span>
            <span style="display: flex; align-items: center; gap: 0.4rem;">
                <i class="fa-regular fa-calendar" style="color: var(--blue); font-size: 0.75rem;"></i>
                {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}
            </span>
        </div>
    </div>
</section>

{{-- Featured Image --}}
@if($post->image)
<div style="background: var(--white); padding-top: 2rem;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <div style="border-radius: 16px; overflow: hidden; border: 1px solid var(--border); background: var(--bg-soft); display: flex; align-items: center; justify-content: center; min-height: 200px;">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                 style="width: 100%; max-height: 500px; object-fit: contain; display: block;" loading="lazy">
        </div>
    </div>
</div>
@endif

{{-- Post Body --}}
<section style="padding: 3rem 0; background: var(--white, #ffffff);">
    <div class="container" style="max-width: 880px; display: grid; grid-template-columns: 1fr 280px; gap: 4rem; align-items: start;">

        {{-- Content --}}
        <div class="blog-post-body" style="color: var(--ink); padding: 1.5rem; background: var(--white); border-radius: 12px; border: 1px solid var(--border); overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; hyphens: auto; overflow: hidden;">
            {!! $post->content !!}

            {{-- Share Buttons --}}
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                <p style="font-size: 0.75rem; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;">Share this article</p>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #25D366; color: #fff; border-radius: 999px; font-size: 0.8rem; font-weight: 600; text-decoration: none;" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #1877F2; color: #fff; border-radius: 999px; font-size: 0.8rem; font-weight: 600; text-decoration: none;" target="_blank">
                        <i class="fa-brands fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #0f172a; color: #fff; border-radius: 999px; font-size: 0.8rem; font-weight: 600; text-decoration: none;" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i> X
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside>
            {{-- CTA Card --}}
            <div style="background: var(--bg-soft, #f1f5f9); border: 1px solid var(--border, #e2e8f0); padding: 2rem; text-align: center; margin-bottom: 2rem; position: sticky; top: 100px; border-radius: 12px;">
                <div style="width: 52px; height: 52px; background: var(--blue, #1d4ed8); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; border-radius: 50%;">
                    <i class="fa-solid fa-phone" style="font-size: 1.1rem; color: #fff;"></i>
                </div>
                <div style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 800; color: var(--ink, #0f172a); margin-bottom: 0.5rem;">Need Guidance?</div>
                <p style="font-size: 0.85rem; color: var(--muted, #64748b); margin-bottom: 1.25rem; line-height: 1.65;">Talk to our expert counsellors. No AI. No bots.</p>
                <a href="{{ route('contact') }}" class="btn btn-teal btn-sm" style="width: 100%; justify-content: center; margin-bottom: 0.75rem;">
                    <i class="fa-solid fa-comments"></i> Talk to Expert
                </a>
                <a href="https://wa.me/919747500002" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
                <p style="font-size: 0.72rem; color: var(--muted, #94a3b8); margin-top: 0.875rem;">Mon–Sat: 9:30 AM – 5:30 PM</p>
            </div>

            {{-- Related Posts --}}
            @if($related->count())
            <div>
                <div style="font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: var(--muted, #94a3b8); margin-bottom: 1rem;">Related Articles</div>
                <div style="display: flex; flex-direction: column; gap: 1px; border: 1px solid var(--border, #e2e8f0); border-radius: 8px; overflow: hidden;">
                    @foreach($related as $rel)
                    <a href="{{ route('blog.show', $rel->slug) }}" style="display: block; padding: 1rem; background: var(--white, #ffffff); transition: background 0.2s; text-decoration: none; border-bottom: 1px solid var(--border, #e2e8f0);" onmouseover="this.style.background='var(--bg-soft, #f8fafc)'" onmouseout="this.style.background='var(--white, #ffffff)'">
                        <span style="display: inline-block; background: rgba(29, 78, 216, 0.08); color: var(--blue, #1d4ed8); padding: 2px 8px; border-radius: 3px; font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">{{ $rel->category }}</span>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--ink, #0f172a); line-height: 1.4; margin-top: 0.4rem;">{{ $rel->title }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>
    </div>
</section>

{{-- More Posts --}}
<section style="padding: 4rem 0; background: var(--bg, #f8fafc); border-top: 1px solid var(--border, #e2e8f0);">
    <div class="container">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
            <div style="font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3rem); color: var(--ink, #0f172a); text-transform: uppercase;">More Articles</div>
            <a href="{{ route('blog') }}" class="btn btn-outline">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="blog-grid">
            @foreach(\App\Models\BlogPost::published()->where('id','!=',$post->id)->latest('published_at')->take(3)->get() as $p)
            <div class="blog-card">
                <a href="{{ route('blog.show', $p->slug) }}" class="blog-card-img" style="display:block;">
                    @if($p->image)
                        <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->title }}" loading="lazy">
                    @else
                        <div class="blog-card-img-placeholder"><i class="fa-solid fa-newspaper"></i></div>
                    @endif
                </a>
                <div class="blog-card-body">
                    <span class="blog-card-category">{{ $p->category }}</span>
                    <a href="{{ route('blog.show', $p->slug) }}" class="blog-card-title" style="display:block;">{{ $p->title }}</a>
                    <div class="blog-card-excerpt">{{ $p->excerpt }}</div>
                    <div class="blog-card-meta">
                        <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($p->published_at)->format('d M Y') }}</span>
                        <a href="{{ route('blog.show', $p->slug) }}" class="blog-card-read">Read <i class="fa-solid fa-arrow-right" style="font-size:.65rem;"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
    /* Responsive: stack sidebar below content on mobile */
    @media (max-width: 768px) {
        .container[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
    /* Ensure blog content images are responsive */
    .blog-post-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
</style>
<script>
const io = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting){ x.target.classList.add('visible'); io.unobserve(x.target); } }), { threshold:.07 });
document.querySelectorAll('.reveal,.reveal-d1,.reveal-d2,.reveal-d3').forEach(el => io.observe(el));
const nav = document.getElementById('mainNavbar');
if(nav) window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 20), { passive:true });
</script>
@endpush
