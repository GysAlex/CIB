<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @yield('title')
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (request()->routeIs('blog'))
            @vite(['resources/css/app.css'])
        @else
            @vite(['resources/css/app.css', 'resources/js/app.js'])        
        @endif
        
        <script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script> 

        <script>
            const lenis = new Lenis()

            function raf(time)
            {
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
