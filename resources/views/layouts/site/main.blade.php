<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head -->
    @include('campusnet::layouts/site/_head')
    @yield('css')

    <!-- Title -->
    <title>CampusNet LMS</title>
</head>
<body style="background-color: #f8f9fa;">
    <!-- Navbar -->
    @include('campusnet::layouts/site/_navbar')

    <!-- Content -->
    <main class="container-fluid my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('campusnet::layouts/site/_footer')

    <!-- Scripts -->
    @include('campusnet::layouts/site/_js')
    @yield('js')
</body>
</html>