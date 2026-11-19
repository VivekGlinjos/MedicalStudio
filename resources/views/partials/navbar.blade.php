
<div class="announce-bar">
    <a href="tel:+919747500002"><i class="fa-solid fa-phone-volume" style="font-size:.65rem;"></i> +91 97475 00002</a>
    <span class="sep">|</span>
    <a href="tel:+919747500003">+91 97475 00003</a>
    <span class="sep">|</span>
    <a href="mailto:info@medicalstudio.in"><i class="fa-solid fa-envelope" style="font-size:.65rem;"></i> info@medicalstudio.in</a>
    <span class="sep">|</span>
    <span><i class="fa-regular fa-clock" style="font-size:.65rem;"></i> Mon – Sat: 9:30 AM – 5:30 PM</span>
</div>

<nav class="navbar" id="mainNavbar" x-data="{ open: false }">
    <div class="navbar-inner">


        <a href="{{ route('home') }}" class="nav-brand">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Medical Studio"
                 class="nav-logo-img"
                 onerror="this.style.display='none'">
            <span class="nav-brand-text">
                <span class="ms-teal">MEDICAL</span><span class="ms-dark"> STUDIO</span>
            </span>
        </a>


        <ul class="nav-links">


            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->routeIs('counselling*') ? 'active' : '' }}">
                    Admissions <i class="fa-solid fa-chevron-down chevron"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ route('counselling.show', 'neet-ug') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-graduation-cap" style="width:16px;color:var(--teal);"></i> NEET UG 2026
                    </a>
                    <a href="{{ route('counselling.show', 'neet-pg') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-user-doctor" style="width:16px;color:var(--teal);"></i> NEET PG 2026
                    </a>
                    <a href="{{ route('counselling.show', 'neet-mds') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-tooth" style="width:16px;color:var(--teal);"></i> NEET MDS 2026
                    </a>
                    <a href="{{ route('counselling.show', 'inicet') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-microscope" style="width:16px;color:var(--teal);"></i> INICET 2026
                    </a>
                    <a href="{{ route('counselling.show', 'dnb-pdcet') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-file-medical" style="width:16px;color:var(--teal);"></i> DNB PDCET 2026
                    </a>
                    <a href="{{ route('counselling.show', 'neet-ss') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-star" style="width:16px;color:var(--teal);"></i> NEET SS 2026
                    </a>
                </div>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                    Programmes <i class="fa-solid fa-chevron-down chevron"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ route('counselling.show', 'neet-ug') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-stethoscope" style="width:16px;color:var(--teal);"></i> MBBS
                    </a>
                    <a href="{{ route('counselling.show', 'neet-pg') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-user-doctor" style="width:16px;color:var(--teal);"></i> MD / MS
                    </a>
                    <a href="{{ route('counselling.show', 'neet-mds') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-tooth" style="width:16px;color:var(--teal);"></i> BDS / MDS
                    </a>
                    <a href="{{ route('counselling.show', 'inicet') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-hospital" style="width:16px;color:var(--teal);"></i> AIIMS PG
                    </a>
                </div>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->routeIs('institutes','seat-predictor','features') ? 'active' : '' }}">
                    Resources <i class="fa-solid fa-chevron-down chevron"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ route('institutes') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-hospital" style="width:16px;color:var(--teal);"></i> Institutes DB
                    </a>
                    <a href="{{ route('seat-predictor') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-chart-bar" style="width:16px;color:var(--teal);"></i> Seat Predictor
                    </a>
                    <a href="{{ route('features') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-bolt" style="width:16px;color:var(--teal);"></i> All Tools
                    </a>
                </div>
            </li>


            <li class="nav-item">
                <a href="{{ route('blog') }}" class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}">
                    Blog
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('packages') }}" class="nav-link {{ request()->routeIs('packages') ? 'active' : '' }}">
                    Packages
                </a>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link {{ request()->routeIs('about','contact','success-stories') ? 'active' : '' }}">
                    Company <i class="fa-solid fa-chevron-down chevron"></i>
                </a>
                <div class="nav-dropdown">
                    <a href="{{ route('about') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-circle-info" style="width:16px;color:var(--teal);"></i> About Us
                    </a>
                    <a href="{{ route('success-stories') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-trophy" style="width:16px;color:var(--teal);"></i> Success Stories
                    </a>
                    <a href="{{ route('contact') }}" class="nav-dropdown-link">
                        <i class="fa-solid fa-phone" style="width:16px;color:var(--teal);"></i> Contact Us
                    </a>
                </div>
            </li>

        </ul>


        <style>
            @media (max-width: 992px) {
                .desktop-auth-actions { display: none !important; }
            }
        </style>
        <div class="nav-actions">
            <div class="desktop-auth-actions" style="display: flex; gap: 0.5rem; align-items: center;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-teal btn-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" id="navLoginBtn">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-teal btn-sm" id="navGetStartedBtn">
                        <i class="fa-solid fa-rocket"></i> Get Started
                    </a>
                @endauth
            </div>


            <button class="nav-toggle" @click="open = !open" aria-label="Toggle navigation menu" id="mobileMenuBtn">
                <span :style="open ? 'transform:rotate(45deg) translate(5px,5px)' : ''"></span>
                <span :style="open ? 'opacity:0' : ''"></span>
                <span :style="open ? 'transform:rotate(-45deg) translate(5px,-5px)' : ''"></span>
            </button>
        </div>
    </div>


    <div class="nav-mobile" :class="{ 'open': open }" x-data="{ c:false, pr:false, r:false, co:false }">

        <button class="nav-mobile-link" @click="c = !c">
            Admissions <i class="fa-solid" :class="c ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size:.7rem;"></i>
        </button>
        <div class="nav-mobile-sub" x-show="c" x-transition>
            <a href="{{ route('counselling.show', 'neet-ug') }}">NEET UG 2026</a>
            <a href="{{ route('counselling.show', 'neet-pg') }}">NEET PG 2026</a>
            <a href="{{ route('counselling.show', 'neet-mds') }}">NEET MDS 2026</a>
            <a href="{{ route('counselling.show', 'inicet') }}">INICET 2026</a>
            <a href="{{ route('counselling.show', 'dnb-pdcet') }}">DNB PDCET 2026</a>
            <a href="{{ route('counselling.show', 'neet-ss') }}">NEET SS 2026</a>
        </div>

        <button class="nav-mobile-link" @click="pr = !pr">
            Programmes <i class="fa-solid" :class="pr ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size:.7rem;"></i>
        </button>
        <div class="nav-mobile-sub" x-show="pr" x-transition>
            <a href="{{ route('counselling.show', 'neet-ug') }}">MBBS</a>
            <a href="{{ route('counselling.show', 'neet-pg') }}">MD / MS</a>
            <a href="{{ route('counselling.show', 'neet-mds') }}">BDS / MDS</a>
            <a href="{{ route('counselling.show', 'inicet') }}">AIIMS PG</a>
        </div>

        <button class="nav-mobile-link" @click="r = !r">
            Resources <i class="fa-solid" :class="r ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size:.7rem;"></i>
        </button>
        <div class="nav-mobile-sub" x-show="r" x-transition>
            <a href="{{ route('institutes') }}">Institutes</a>
            <a href="{{ route('seat-predictor') }}">Seat Predictor</a>
            <a href="{{ route('features') }}">All Tools</a>
        </div>

        <a href="{{ route('blog') }}" class="nav-mobile-link">Blog</a>
        <a href="{{ route('packages') }}" class="nav-mobile-link">Packages</a>

        <button class="nav-mobile-link" @click="co = !co">
            Company <i class="fa-solid" :class="co ? 'fa-chevron-up' : 'fa-chevron-down'" style="font-size:.7rem;"></i>
        </button>
        <div class="nav-mobile-sub" x-show="co" x-transition>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('success-stories') }}">Success Stories</a>
            <a href="{{ route('contact') }}">Contact Us</a>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--border-d);flex-direction:column;">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-teal btn-sm" style="flex:1;justify-content:center;">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display:flex;">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;width:100%;">Logout</button>
                </form>
            @else
                <div style="display:flex;gap:.75rem;width:100%;">
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-teal btn-sm" style="flex:1;justify-content:center;">Get Started</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
