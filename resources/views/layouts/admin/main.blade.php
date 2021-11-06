<!DOCTYPE html>
<html lang="en">
<head>
    @include('campusnet::layouts/admin/_head')
    @yield('css')

    <title>@yield('title') | CampusNet</title>
</head>
<body>
	<div class="wrapper">
        @include('campusnet::layouts/admin/_sidebar')
        
		<div class="main">
            @include('campusnet::layouts/admin/_header')

			<main class="content">
				<div class="container-fluid p-0">
                    @yield('content')
				</div>
			</main>

            @include('campusnet::layouts/admin/_footer')

		</div>
	</div>

    @include('campusnet::layouts/admin/_js')
    @yield('js')

</body>
</html>