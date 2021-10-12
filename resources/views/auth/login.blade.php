<!DOCTYPE html>
<html lang="en">
<head>
    @include('campusnet::layouts/_head')
    <title>Log in</title>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link href="https://getbootstrap.com/docs/5.0/examples/sign-in/signin.css" rel="stylesheet">
</head>
<body class="text-center">
    <main class="form-signin">
        <form method="post" action="{{ route('auth.post-login') }}">
            @csrf
            <img class="mb-4" src="https://campusnet.id/assets/images/logo/campusnet.webp" alt="" height="57">
            <h1 class="h3 mb-3 fw-normal">Welcome Back!</h1>
            @if($errors->any())
            <div class="alert alert-danger" role="alert">The provided credentials do not match our records!</div>
            @endif
            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Email / Username" value="{{ old('username') }}" autofocus>
                <label for="floatingInput">Email / Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
        </form>
    </main>
</body>
</html>
