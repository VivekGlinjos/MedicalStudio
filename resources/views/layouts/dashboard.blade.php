<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard — Medical Studio')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Sortable.js (For Choice List Drag & Drop) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <style>
        /* Dashboard specific layout styles built on top of app.css */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--bg);
        }
        .dashboard-container {
            display: flex;
            height: calc(100vh - 72px); /* Assuming navbar is ~72px */
            margin-top: 72px;
        }
        .dashboard-sidebar {
            width: 260px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .dashboard-main {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
            background: var(--bg);
        }
        .sidebar-section {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            font-weight: 700;
            padding: 0 1.5rem 0.5rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1.5rem;
            color: var(--ink);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: var(--bg-soft);
            color: var(--teal);
        }
        .sidebar-link i {
            width: 20px;
            text-align: center;
            color: var(--muted);
            transition: color 0.2s;
        }
        .sidebar-link:hover i, .sidebar-link.active i {
            color: var(--teal);
        }
        @media(max-width: 768px) {
            .dashboard-sidebar {
                position: fixed;
                top: 72px;
                left: -260px;
                bottom: 0;
                z-index: 1001;
                background: #ffffff !important;
                transition: left 0.3s ease;
                display: flex !important;
                box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            }
            .dashboard-sidebar.mobile-open {
                left: 0;
            }
            .mobile-overlay {
                display: none;
                position: fixed; inset: 0; top: 72px; background: rgba(0,0,0,0.5); z-index: 1000;
            }
            .mobile-overlay.mobile-open {
                display: block;
            }
            .dash-header { padding: 0 1rem !important; }
            .dash-brand-text { display: none !important; }
            .dash-portal-badge { margin-left: 0 !important; }
            .dash-mobile-toggle { display: block !important; }
            .dash-profile-name { display: none !important; }
        }
        .dash-mobile-toggle { display: none; background: transparent; border: none; font-size: 1.25rem; color: var(--ink); cursor: pointer; padding-right: 0.5rem; }
        .dash-layout { display: grid; grid-template-columns: 1fr 320px; gap: 2rem; }
        .dash-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }
        @media(max-width: 1024px) {
            .dash-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body x-data="{ mobileNav: false }">

    {{-- Dedicated Portal Top Bar --}}
    <header class="dash-header" style="height: 72px; background: var(--white); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <button class="dash-mobile-toggle" @click="mobileNav = !mobileNav"><i class="fa-solid fa-bars"></i></button>
            <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 32px; width: 32px; object-fit: contain;">
                <span class="dash-brand-text" style="font-family: var(--font-heading); font-weight: 800; color: var(--ink); font-size: 1.1rem; letter-spacing: -0.02em;">MEDICAL <span style="color: var(--blue);">STUDIO</span></span>
            </a>
            <span class="dash-portal-badge" style="background: rgba(29, 78, 216, 0.1); color: var(--blue); padding: 2px 8px; border-radius: 4px; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; margin-left: 0.5rem;">Portal</span>
        </div>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <div x-data="{ open: false }" style="position: relative;">
                <button @click="open = !open" @click.away="open = false" style="position: relative; color: var(--muted); font-size: 1.25rem; transition: color 0.2s; cursor: pointer; background: transparent; border: none;" onmouseover="this.style.color='var(--ink)'" onmouseout="this.style.color='var(--muted)'">
                    <i class="fa-regular fa-bell"></i>
                    <span style="position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background: #ef4444; border-radius: 50%; border: 2px solid var(--white);"></span>
                </button>
                
                <div x-show="open" x-cloak x-transition style="position: absolute; top: 100%; right: -10px; margin-top: 1rem; width: 320px; background: var(--white); border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid var(--border); overflow: hidden; z-index: 2000;">
                    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); background: var(--bg-soft); display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700; font-size: 0.9rem; color: var(--ink);">Notifications</span>
                        <a href="#" style="font-size: 0.75rem; color: var(--blue); text-decoration: none;">Mark all read</a>
                    </div>
                    <div style="max-height: 300px; overflow-y: auto;">
                        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); background: rgba(29, 78, 216, 0.03);">
                            <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink);">MCC Round 1 Starts</div>
                            <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">Registration and fee payment window opens today.</div>
                            <div style="font-size: 0.7rem; color: var(--blue); font-weight: 600; margin-top: 0.5rem;">Just now</div>
                        </div>
                        <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--border);">
                            <div style="font-size: 0.85rem; font-weight: 600; color: var(--ink);">Premium Plan Activated</div>
                            <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">You now have full access to rank scan.</div>
                            <div style="font-size: 0.7rem; color: var(--muted-lt); font-weight: 600; margin-top: 0.5rem;">2 days ago</div>
                        </div>
                    </div>
                    <div style="padding: 0.75rem; text-align: center; border-top: 1px solid var(--border); background: var(--bg-soft);">
                        <a href="#" style="font-size: 0.8rem; font-weight: 600; color: var(--ink); text-decoration: none;">View All</a>
                    </div>
                </div>
            </div>
            
            <div x-data="{ openProfile: false }" style="position: relative; display: flex; align-items: center; gap: 0.75rem; padding-left: 1.5rem; border-left: 1px solid var(--border); cursor: pointer;" @click="openProfile = !openProfile" @click.away="openProfile = false">
                <div class="dash-profile-name" style="text-align: right;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: var(--ink); line-height: 1.2;">{{ $user->name ?? 'Student' }}</div>
                    <div style="font-size: 0.7rem; color: var(--muted); font-weight: 500;">{{ auth()->user() && auth()->user()->is_paid ? 'Premium Plan' : 'Free Plan' }}</div>
                </div>
                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--blue), var(--blue-dark)); display: flex; align-items: center; justify-content: center; color: var(--white); font-weight: 700; font-size: 0.9rem;">
                    {{ strtoupper(substr($user->name ?? 'S', 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->name ?? 'Student')[1] ?? 'T', 0, 1)) }}
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; color: var(--muted);" :style="openProfile ? 'transform: rotate(180deg);' : ''" style="transition: transform 0.2s;"></i>

                <div x-show="openProfile" x-cloak x-transition style="position: absolute; top: 100%; right: 0; margin-top: 1rem; width: 200px; background: var(--white); border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border: 1px solid var(--border); overflow: hidden; z-index: 2000; text-align: left;">
                    <a href="{{ route('dashboard.profile') }}" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; font-size: 0.85rem; font-weight: 600; color: var(--ink); text-decoration: none; border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--bg-soft)'" onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-user" style="width: 16px; color: var(--muted);"></i> My Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; font-size: 0.85rem; font-weight: 600; color: #ef4444; background: transparent; border: none; cursor: pointer; text-align: left; transition: background 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.05)'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-right-from-bracket" style="width: 16px;"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        {{-- Mobile Overlay --}}
        <div class="mobile-overlay" :class="mobileNav ? 'mobile-open' : ''" @click="mobileNav = false"></div>

        {{-- Sidebar --}}
        <aside class="dashboard-sidebar" :class="mobileNav ? 'mobile-open' : ''">
            <div class="sidebar-section">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Overview
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Discover</div>
                <a href="{{ route('colleges.index') }}" class="sidebar-link {{ request()->routeIs('colleges*') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-columns"></i> Colleges
                </a>
                <a href="{{ route('courses.index') }}" class="sidebar-link {{ request()->routeIs('courses*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate"></i> Courses
                </a>
                <a href="{{ route('states.index') }}" class="sidebar-link {{ request()->routeIs('states*') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-location-dot"></i> States
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">My Activities</div>
                <a href="{{ route('dashboard.profile') }}" class="sidebar-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-user"></i> My Profile
                </a>
                <a href="{{ route('dashboard.enquiries') }}" class="sidebar-link {{ request()->routeIs('dashboard.enquiries') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> My Enquiries
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">Admissions Tools</div>
                <a href="{{ route('dashboard.rank-scan') }}" class="sidebar-link {{ request()->routeIs('dashboard.rank-scan') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass-chart"></i> Rank Scan Engine
                </a>
                <a href="{{ route('dashboard.seat-matrix') }}" class="sidebar-link {{ request()->routeIs('dashboard.seat-matrix') ? 'active' : '' }}">
                    <i class="fa-solid fa-border-all"></i> Seat Matrix
                </a>
                <a href="{{ route('past-allotments.index') }}" class="sidebar-link {{ request()->routeIs('past-allotments.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-ol"></i> Past Allotments
                </a>
                <a href="{{ route('dashboard.allotment') }}" class="sidebar-link {{ request()->routeIs('dashboard.allotment') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-location"></i> Allotment Mapping <span class="badge bg-warning text-dark ms-auto" style="font-size:0.6rem;">Coming Soon</span>
                </a>
                <a href="{{ route('dashboard.choice-list') }}" class="sidebar-link {{ request()->routeIs('dashboard.choice-list') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i> Choice List Builder
                </a>
            </div>
            
            <div class="sidebar-section">
                <form action="{{ route('logout') }}" method="POST" id="user-logout-form" style="display:none;">
                    @csrf
                </form>
                <a href="#" onclick="document.getElementById('user-logout-form').submit(); return false;" class="sidebar-link">
                    <i class="fa-solid fa-right-from-bracket" style="color:var(--danger);"></i> Logout
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="dashboard-main">
            @yield('content')
        </main>
    </div>

    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 20,
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
