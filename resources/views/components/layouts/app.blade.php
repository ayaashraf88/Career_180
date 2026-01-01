<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components.layouts.head')
    @livewireStyles
    <style>
        .darkMode {
            background-color: #121212 !important;
            color: #ffffff;
        }

        .darkMode body {
            background-color: #121212 !important;
            color: #ffffff;
        }

        .darkMode main {
            background-color: #121212 !important;
            color: #ffffff;
        }

        .darkMode .bg-light {
            background-color: #343a40 !important;
            color: #ffffff !important;
        }

        .darkMode .text-reset {
            color: #ffffff !important;
        }

        .darkMode .nav-link {
            color: #ffffff !important;
        }

        .darkMode .btn-outline-primary {
            color: #ffffff;
            border-color: #ffffff;
        }

        .darkMode .btn-outline-primary:hover {
            background-color: #ffffff;
            color: #000000;
        }

        .lightMode {
            background-color: #ffffff !important;
            color: #000000;
        }

        .lightMode body {
            background-color: #ffffff !important;
            color: #000000;
        }

        .lightMode main {
            background-color: #ffffff !important;
            color: #000000;
        }
    </style>
</head>

<body 
    x-data 
    class="font-sans antialiased" 
    :class="$store.theme && $store.theme.on ? 'darkMode' : 'lightMode'"
>
    <!-- Page Heading -->
    @include('components.layouts.header')

    <!-- Page Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('components.layouts.footer')
    @include('livewire.toasts')
    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

</body>

</html>