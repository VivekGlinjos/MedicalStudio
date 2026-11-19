<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard — Medical Studio</title>
    
    <!-- Admin Base CSS (Bootstrap & DataTables) -->
    <link rel="stylesheet" href="{{ asset('assets/bcss/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- App CSS (Portal Template) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Modulix Inspired Dashboard Layout */
        html, body {
            height: 100%; margin: 0; padding: 0;
            background: #fafbfe; /* Very light cool grey */
            font-family: 'Inter', sans-serif !important;
            color: #334155;
        }
        .dashboard-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        
        /* Sidebar Styling */
        .dashboard-sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #f1f5f9;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1.25rem;
            overflow-y: auto;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none; margin-bottom: 2.5rem; padding: 0 0.5rem;
        }
        .sidebar-brand img { width: 32px; height: 32px; object-fit: contain; }
        .sidebar-brand-text { font-size: 1.25rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
        
        .sidebar-section-title {
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: #94a3b8; font-weight: 700; margin: 1.5rem 0 0.5rem 0.5rem;
        }
        
        .sidebar-link {
            display: flex; align-items: center; gap: 1rem;
            padding: 0.75rem 1rem; color: #64748b; font-size: 0.95rem; font-weight: 500;
            text-decoration: none; border-radius: 12px; transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }
        .sidebar-link i { font-size: 1.1rem; width: 24px; text-align: center; }
        .sidebar-link:hover { background: #f8fafc; color: #0f172a; }
        .sidebar-link.active { background: #f8fafc; color: #0f172a; font-weight: 600; box-shadow: inset 3px 0 0 #0f172a; border-radius: 8px; }
        
        /* User Profile at bottom of sidebar */
        .sidebar-user {
            margin-top: auto; padding: 1rem; background: #f8fafc; border-radius: 12px;
            display: flex; align-items: center; gap: 0.75rem; border: 1px solid #f1f5f9;
        }
        .user-avatar { width: 36px; height: 36px; background: #0f172a; color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; }
        .user-info { flex: 1; overflow: hidden; }
        .user-name { font-size: 0.85rem; font-weight: 700; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.7rem; color: #64748b; }
        
        /* Main Content */
        .dashboard-content-wrapper {
            flex: 1; display: flex; flex-direction: column; overflow: hidden;
        }
        
        /* Topbar */
        .dashboard-topbar {
            height: 80px; background: #fafbfe; padding: 0 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-search {
            background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px;
            padding: 0.6rem 1.25rem; display: flex; align-items: center; gap: 0.75rem; width: 300px;
        }
        .topbar-search input { border: none; outline: none; background: transparent; font-size: 0.9rem; width: 100%; color: #334155; }
        
        .dashboard-main {
            flex: 1; padding: 1rem 2.5rem 3rem; overflow-y: auto;
        }

        /* Modern Bootstrap overrides */
        .card { border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); background: #ffffff; overflow: hidden; margin-bottom: 1.5rem; }
        .card-header { background: #ffffff; border-bottom: 1px solid #f1f5f9; padding: 1.5rem; font-weight: 700; color: #0f172a; }
        .card-body { padding: 1.5rem; }
        .table { color: #334155; font-size: 0.9rem; }
        .table th { border-bottom: 1px solid #e2e8f0; color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; padding: 1rem; }
        .table td { border-bottom: 1px solid #f1f5f9; vertical-align: middle; padding: 1rem; }
        .btn-primary { background-color: #0f172a; border-color: #0f172a; border-radius: 8px; }
        .btn-primary:hover { background-color: #1e293b; border-color: #1e293b; }
        
        .page-title { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; letter-spacing: -0.02em; }
    </style>
</head>
<body x-data="{ mobileNav: false }">

    <div class="dashboard-container">
        {{-- Sidebar --}}
        <aside class="dashboard-sidebar">
            <a href="{{ url('/') }}" class="sidebar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <span class="sidebar-brand-text">Medical Studio</span>
            </a>

            <div class="sidebar-section-title">MAIN MENU</div>
            <a href="{{route('admin.dashboard')}}" class="sidebar-link {{ request()->is('admin/dashboard*') ? 'active' : ''}}">
                <i class="fa-solid fa-border-all"></i> Dashboard
            </a>
            <a href="{{route('admin.enquiries.index')}}" class="sidebar-link {{ request()->is('admin/enquiries*') ? 'active' : ''}}">
                <i class="fa-regular fa-envelope"></i> Enquiries
            </a>
            <a href="{{route('admin.packages.index')}}" class="sidebar-link {{ request()->is('admin/packages*') ? 'active' : ''}}">
                <i class="fa-solid fa-box"></i> Packages
            </a>
            <a href="{{route('admin.payments.index')}}" class="sidebar-link {{ request()->is('admin/payments*') ? 'active' : ''}}">
                <i class="fa-solid fa-credit-card"></i> Payments
            </a>

            <div class="sidebar-section-title">ACADEMICS</div>
            <a href="{{route('admin.courses.index')}}" class="sidebar-link {{ request()->is('admin/courses*') ? 'active' : ''}}">
                <i class="fa-solid fa-graduation-cap"></i> Courses
            </a>
            <a href="{{route('admin.colleges.index')}}" class="sidebar-link {{ request()->is('admin/colleges*') ? 'active' : ''}}">
                <i class="fa-regular fa-building"></i> Colleges
            </a>
            <a href="{{route('admin.cutoffs.index')}}" class="sidebar-link {{ request()->is('admin/cutoffs*') ? 'active' : ''}}">
                <i class="fa-solid fa-list-ol"></i> Past Allotments
            </a>

            <a href="{{route('admin.states.index')}}" class="sidebar-link {{ request()->is('admin/states*') ? 'active' : ''}}">
                <i class="fa-solid fa-map-location-dot"></i> States
            </a>

            <div class="sidebar-section-title">MEDIA & CONTENT</div>
            <a href="{{route('admin.galleries.index')}}" class="sidebar-link {{ request()->is('admin/galleries*') ? 'active' : ''}}">
                <i class="bi bi-images"></i> Gallery
            </a>
            <a href="{{route('admin.blogs.index')}}" class="sidebar-link {{ request()->is('admin/blogs*') ? 'active' : ''}}">
                <i class="fa-solid fa-file-lines"></i> Blogs
            </a>
            <a href="{{route('admin.media.videos')}}" class="sidebar-link {{ request()->is('admin/videos*') ? 'active' : ''}}">
                <i class="fa-brands fa-youtube"></i> Video Gallery
            </a>
            <a href="{{route('admin.media.gallery')}}" class="sidebar-link {{ request()->is('admin/gallery*') ? 'active' : ''}}">
                <i class="fa-regular fa-image"></i> Image Gallery
            </a>
            
            <div class="sidebar-user">
                <div class="user-avatar">AD</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="user-role">{{ auth()->user()->email ?? 'admin@modulix.com' }}</div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" id="admin-logout-form" style="display:none;">@csrf</form>
                <a href="#" onclick="document.getElementById('admin-logout-form').submit(); return false;" style="color: #94a3b8; font-size: 1.1rem; padding: 0.25rem;"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </aside>

        {{-- Content Area --}}
        <div class="dashboard-content-wrapper">
            
            {{-- Topbar --}}
            <header class="dashboard-topbar">
                <div style="font-weight: 500; color: #94a3b8; font-size: 0.95rem;">
                    Main Menu <span style="margin: 0 0.5rem;">/</span> <span style="color: #0f172a; font-weight: 600;"><i class="fa-solid fa-border-all" style="margin-right: 0.4rem;"></i> Dashboard</span>
                </div>
                
                <div class="topbar-search">
                    <i class="fa-solid fa-magnifying-glass" style="color:#94a3b8;"></i>
                    <input type="text" placeholder="Search anything...">
                </div>
            </header>

            {{-- Main Content --}}
            <main class="dashboard-main">
                @yield('contentpanel')
            </main>
        </div>
    </div>

    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/bjs/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables -->
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.table:not(.no-datatable)').forEach(table => {
                new simpleDatatables.DataTable(table);
            });
        });
    </script>
</body>
</html>