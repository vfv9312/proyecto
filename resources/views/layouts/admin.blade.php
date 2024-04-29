<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
</head>

<body class="">
    <div class=""><!--animate__animated  animate__flipInX-->
        @include('layouts.navbar')
        @include('layouts.siderbar')

        <!-- Page Content -->
        <main class=" lg:pl-64">
            @yield('content')
        </main>
    </div>
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <script>
            document.querySelectorAll('.menu-desplegable-siderbar').forEach(button => {
                button.addEventListener('click', () => {
                    const menuContent = button.nextElementSibling;
                    menuContent.classList.toggle('hidden');
                });
            });

            document.querySelector('.boton-desplegable-menu').addEventListener('click', function() {
                document.getElementById('default-sidebar').classList.toggle('hidden');
            });
        </script>
    @endpush
    @stack('js')
</body>

</html>
