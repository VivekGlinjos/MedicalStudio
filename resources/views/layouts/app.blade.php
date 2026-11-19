<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Medical Studio — Expert Medical Admissions Counselling')</title>
    <meta name="description" content="@yield('meta_description', 'Medical Studio: India\'s trusted partner for MBBS, MD, MS, BDS & MDS admissions. Expert counselling for NEET-PG, NEET-UG, INICET, DNB-PDCET. Serving Kerala, Karnataka & Tamil Nadu.')">
    <meta property="og:title"       content="@yield('title', 'Medical Studio')">
    <meta property="og:description" content="@yield('meta_description', 'Expert medical admissions counselling — NEET-PG, NEET-UG, MBBS, MD, MS guidance.')">
    <meta property="og:type"        content="website">
    <meta property="og:image"       content="{{ asset('images/logo.png') }}">
    <meta name="robots"             content="INDEX,FOLLOW">
    <meta name="geo.region"         content="IN-KA">
    <meta name="geo.placename"      content="Mangalore">
    <link rel="canonical"           href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- WhatsApp FAB --}}
    <a href="https://wa.me/919747500002?text=Hello%21+I+need+guidance+for+Medical+Admissions."
       class="fab-wa"
       target="_blank"
       rel="noopener"
       aria-label="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    @include('partials.callback-modal')

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50,
            });
        });
    </script>
</body>
</html>
