<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components.layouts.head')
    @livewireStyles
</head>

<body class="font-sans antialiased">

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