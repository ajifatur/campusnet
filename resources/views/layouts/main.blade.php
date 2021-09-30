<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head -->
    @include('campusnet::layouts/_head')
    @yield('css')

    <!-- Title -->
    <title>CampusNet LMS</title>
</head>
<body>
    <!-- Navbar -->
    @include('campusnet::layouts/_navbar')

    <!-- Content -->
    <div class="container-fluid my-5">
        @yield('content')
    </div>

    <!-- Scripts -->
    @include('campusnet::layouts/_js')
    @yield('js')
</body>
</html>