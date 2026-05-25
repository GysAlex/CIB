<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />

    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
    <meta name="apple-mobile-web-app-title" content="CIB" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('seo')
    <title>
        @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (request()->routeIs('blog') || request()->routeIs('contact') || request()->routeIs('formation') || request()->routeIs('formation.show') || request()->routeIs('blog.show'))
        @vite(['resources/css/app.css'])
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script>

    <script>
        const lenis = new Lenis()

        function raf(time) {
            lenis.raf(time)
            requestAnimationFrame(raf)
        }

        requestAnimationFrame(raf)
    </script>

    @stack('scripts')
</head>

<body class="min-h-screen bg-background">

    @yield('header')

    <main role="main" class="">

        @yield('section')

    </main>

</body>

</html>