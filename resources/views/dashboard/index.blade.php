@extends('layouts.dashboard')

@section('title', 'Portal Dashboard - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
    
    {{-- Section A: Welcome & Progress --}}
    <div class="dash-layout">
        
        {{-- Welcome Banner --}}
        <div class="card" style="background: linear-gradient(135deg, var(--blue-dark), var(--blue)); color: var(--white); border: none; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            {{-- Decorative bg --}}
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <div style="position: relative; z-index: 1;">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.7); margin-bottom: 0.5rem; display: block;">Welcome Back</span>
                <h1 style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; margin: 0 0 0.5rem 0; line-height: 1.1;">{{ $user->name ?? 'Student' }}!</h1>
                <p style="font-size: 0.9rem; color: rgba(255,255,255,0.85); margin: 0; max-width: 400px; line-height: 1.6;">Your NEET UG counseling journey is currently active. You have 2 pending tasks to complete before the next round begins.</p>
                
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="{{ route('dashboard.choice-list') }}" class="btn" style="background: var(--white); color: var(--blue-dark); font-size: 0.8rem; padding: 0.5rem 1.25rem;">Resume Choice Filling</a>
                </div>
            </div>
        </div>

        {{-- Progress Tracker --}}
        <div class="card" style="padding: 1.75rem;">
            <h3 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 1.25rem 0; display: flex; justify-content: space-between; align-items: center;">
                Counseling Progress
                <span class="badge badge-teal">Round 1</span>
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; position: relative;">
                {{-- Track line --}}
                <div style="position: absolute; left: 15px; top: 20px; bottom: 20px; width: 2px; background: var(--border);"></div>
                
                {{-- Step 1 --}}
                <div style="display: flex; gap: 1rem; position: relative; z-index: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--green); color: var(--white); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink);">Registration</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">Completed on 12th Aug</div>
                    </div>
                </div>
                
                {{-- Step 2 --}}
                <div style="display: flex; gap: 1rem; position: relative; z-index: 1;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--white); border: 2px solid var(--blue); color: var(--blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--blue);">Choice Filling</div>
                        <div style="font-size: 0.75rem; color: var(--muted); font-weight: 500;">Currently Active</div>
                    </div>
                </div>
                
                {{-- Step 3 --}}
                <div style="display: flex; gap: 1rem; position: relative; z-index: 1; opacity: 0.5;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg-soft); border: 2px solid var(--border); color: var(--muted); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.8rem;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink);">Seat Allotment</div>
                        <div style="font-size: 0.75rem; color: var(--muted);">Upcoming</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section B: Quick Actions Grid --}}
    <div>
        <h2 style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 800; color: var(--ink); margin-bottom: 1.25rem;">Admission Tools</h2>
        <div class="dash-cards">
            <a href="{{ route('dashboard.rank-scan') }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 2rem 1.5rem;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(29,78,216,0.1); color: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-chart-simple"></i>
                </div>
                <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--ink); margin: 0 0 0.25rem 0;">Rank Scan</h3>
                <p style="font-size: 0.75rem; color: var(--muted); margin: 0;">Predict likely colleges</p>
            </a>
            <a href="{{ route('dashboard.seat-matrix') }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 2rem 1.5rem;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(22,163,74,0.1); color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-border-all"></i>
                </div>
                <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--ink); margin: 0 0 0.25rem 0;">Seat Matrix</h3>
                <p style="font-size: 0.75rem; color: var(--muted); margin: 0;">Check seat availability</p>
            </a>
            <a href="{{ route('dashboard.choice-list') }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 2rem 1.5rem;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(245,158,11,0.1); color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--ink); margin: 0 0 0.25rem 0;">Choice Builder</h3>
                <p style="font-size: 0.75rem; color: var(--muted); margin: 0;">Drag &amp; drop choices</p>
            </a>
            <a href="{{ route('past-allotments.index') }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 2rem 1.5rem;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: rgba(139,92,246,0.1); color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;">
                    <i class="fa-solid fa-list-ol"></i>
                </div>
                <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--ink); margin: 0 0 0.25rem 0;">Past Allotments</h3>
                <p style="font-size: 0.75rem; color: var(--muted); margin: 0;">View historic trends</p>
            </a>
        </div>
    </div>

    {{-- Section C & D: Notifications & Events --}}
    <div class="dash-layout">
        
        {{-- Notifications Panel --}}
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--bg-soft);">
                <h3 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0;">Live Updates</h3>
                <button style="font-size: 0.75rem; font-weight: 600; color: var(--blue);">Mark all read</button>
            </div>
            
            <div style="display: flex; flex-direction: column;">
                {{-- Notification Item --}}
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; gap: 1rem; align-items: flex-start; background: rgba(29, 78, 216, 0.03);">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--blue); margin-top: 0.4rem; flex-shrink: 0;"></div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 0.25rem;">MCC releases revised seat matrix for Round 1</div>
                        <div style="font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 0.5rem;">The Medical Counseling Committee has added 142 new MBBS seats to the AIQ pool.</div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--muted-lt);">2 hours ago</div>
                    </div>
                </div>
                
                {{-- Notification Item --}}
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: transparent; margin-top: 0.4rem; flex-shrink: 0;"></div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 0.25rem;">State Quota registrations opening soon</div>
                        <div style="font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 0.5rem;">Kerala CEE is expected to open the choice filling portal tomorrow at 10 AM.</div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--muted-lt);">Yesterday</div>
                    </div>
                </div>
                
                {{-- Notification Item --}}
                <div style="padding: 1.25rem 1.5rem; display: flex; gap: 1rem; align-items: flex-start;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background: transparent; margin-top: 0.4rem; flex-shrink: 0;"></div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink); margin-bottom: 0.25rem;">Your Premium Plan is active</div>
                        <div style="font-size: 0.8rem; color: var(--muted); line-height: 1.5; margin-bottom: 0.5rem;">You now have full access to the Rank Predictor and Allotment Mapping tools.</div>
                        <div style="font-size: 0.7rem; font-weight: 600; color: var(--muted-lt);">3 days ago</div>
                    </div>
                </div>
            </div>
            
            <div style="padding: 1rem; text-align: center; border-top: 1px solid var(--border); background: var(--bg-soft);">
                <a href="#" style="font-size: 0.8rem; font-weight: 600; color: var(--blue);">View all notifications</a>
            </div>
        </div>



        {{-- Important Events --}}
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--bg-soft);">
                <h3 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-regular fa-calendar-days" style="color: var(--blue);"></i> Upcoming Events
                </h3>
            </div>
            <div style="padding: 1rem 1.5rem;">
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; min-width: 50px;">
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--danger); text-transform: uppercase;">Jul</div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--ink);">14</div>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--ink);">MCC Round 1 Starts</div>
                        <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">Registration and fee payment window opens.</div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; min-width: 50px;">
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--danger); text-transform: uppercase;">Jul</div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--ink);">19</div>
                    </div>
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--ink);">Choice Locking</div>
                        <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">Final day to lock preferences for AIQ.</div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div style="text-align: center; border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; min-width: 50px; opacity: 0.6;">
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--muted); text-transform: uppercase;">Aug</div>
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--muted);">02</div>
                    </div>
                    <div style="opacity: 0.8;">
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--ink);">State Quota Registration</div>
                        <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">Tentative start date for major states.</div>
                    </div>
                </div>
            </div>
            
            <div style="padding: 1rem; text-align: center; border-top: 1px solid var(--border); background: var(--bg-soft);">
                <a href="#" style="font-size: 0.8rem; font-weight: 600; color: var(--blue);">View full calendar</a>
            </div>
        </div>

    </div>

    {{-- Section E: Video Gallery Horizontal Scroll --}}
    @if(isset($videos) && $videos->count() > 0)
    <div style="margin-top: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h2 style="font-family: var(--font-heading); font-size: 1.5rem; font-weight: 800; color: var(--ink); margin: 0;">Videos</h2>
            <a href="#" class="btn" style="background: var(--danger); color: white; border-radius: 20px; font-size: 0.8rem; padding: 0.35rem 1.25rem; text-decoration: none; font-weight: 700;">View all</a>
        </div>
        
        <div style="display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 1rem; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
            @foreach($videos as $video)
            <div class="card" style="min-width: 320px; max-width: 350px; flex-shrink: 0; padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <a href="{{ $video->video_link }}" target="_blank" style="text-decoration: none; display: block; position: relative;">
                    <div style="width: 100%; aspect-ratio: 16/9; background: #e2e8f0; overflow: hidden; position: relative;">
                        @if($video->thumbnail)
                            <img src="{{ Str::startsWith($video->thumbnail, 'videos/') ? asset('storage/' . $video->thumbnail) : asset('assets/images/' . $video->thumbnail) }}" alt="{{ $video->video_name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='{{ asset('images/default-video.jpg') }}'; this.onerror=null;">
                        @else
                            <img src="{{ asset('images/default-video.jpg') }}" alt="Placeholder" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; pointer-events: none;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.9); color: var(--danger); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <i class="fa-solid fa-play" style="margin-left: 3px;"></i>
                            </div>
                        </div>
                        <div style="position: absolute; bottom: 0.5rem; right: 0.5rem; background: rgba(0,0,0,0.8); color: white; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.5rem; border-radius: 4px;">
                            {{ rand(5,20) }}:{{ str_pad(rand(0,59), 2, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </a>
                <div style="padding: 1.25rem; flex-grow: 1; display: flex; gap: 1rem;">
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--blue-dark); flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <a href="{{ $video->video_link }}" target="_blank" style="text-decoration: none;">
                            <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--ink); line-height: 1.4; margin: 0 0 0.5rem 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s;" onmouseover="this.style.color='var(--blue)'" onmouseout="this.style.color='var(--ink)'">
                                {{ $video->video_name }}
                            </h3>
                        </a>
                        <div style="font-size: 0.8rem; color: var(--muted); margin-bottom: 0.2rem;">Medical Studio Explorer</div>
                        <div style="font-size: 0.75rem; color: var(--muted-lt);">{{ rand(1, 11) }} months ago</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

    @if(session('payment_success'))
    <div x-data="{ open: true }" x-show="open" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);" :style="open ? 'display: flex;' : 'display: none;'">
        <div @click.away="open = false" style="background: var(--white); border-radius: 16px; padding: 2.5rem 2rem; max-width: 400px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: rgba(22, 163, 74, 0.1); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1.5rem auto;">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2 style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 800; color: var(--ink); margin-bottom: 0.5rem;">Welcome to Premium!</h2>
            <p style="color: var(--muted); font-size: 0.9rem; margin-bottom: 2rem; line-height: 1.5;">Your payment was successful. You now have full access to Rank Scan, Seat Matrix, Allotment Analytics, and Choice Builder.</p>
            <button @click="open = false" class="btn btn-block" style="background: var(--blue); color: white; padding: 0.85rem; border-radius: 12px; font-weight: 700; box-shadow: 0 4px 15px rgba(29, 78, 216, 0.25);">Explore Dashboard</button>
        </div>
    </div>
    @endif

@endsection
