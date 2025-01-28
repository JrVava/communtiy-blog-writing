<!DOCTYPE html>
<html lang="en" class="@guest form-screen @endguest">

<head>
    <title>@yield('title')</title>
    <!-- Tailwind is included -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>
    <div id="app">
        @auth
            @include('_partial.admin-navbar')
            @include('_partial.admin-sideBar')
        @endauth
        @yield('content')
    </div>
    <!-- Scripts below are for demo only -->
    <script type="text/javascript" src="{{ asset('assets/js/main.min.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>


    @yield('scripts')
    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
</body>

</html>
