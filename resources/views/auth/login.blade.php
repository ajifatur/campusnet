<!DOCTYPE html>
<html lang="en">
<head>
    @include('campusnet::layouts/_head')
    <title>Log in</title>
    <style>
        body, body main {
            min-height: 100vh;
        }
        .login-box {
            text-align: center;
            width: 75%;
            margin: auto;
        }
    </style>
</head>
<body>
    <main class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <form class="login-box" method="post" action="{{ route('auth.post-login') }}">
                        @csrf
                        <img class="mb-4" src="https://campusnet.id/assets/images/logo/campusnet.webp" alt="" height="57">
                        <h1 class="h3 mb-3 fw-normal">Welcome Back!</h1>
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">The provided credentials do not match our records!</div>
                        @endif
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ old('username') }}" placeholder="Email / Username" autofocus>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="Password">
                                <button type="button" class="btn {{ $errors->has('password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                        </div>
                        <button class="w-100 btn btn-primary" type="submit">Log in</button>
                        @if(config('campusnet.settings.socialite') == true)
                        <div class="btn-group mt-3">
                            <a href="{{ route('auth.login.provider', ['provider' => 'google']) }}" class="btn btn-outline-primary">Google</a>
                            <a href="{{ route('auth.login.provider', ['provider' => 'facebook']) }}" class="btn btn-outline-primary">Facebook</a>
                        </div>
                        @endif
                    </form>
                </div>
                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <img src="https://campusdigital.id/assets/images/illustration/undraw_Login_re_4vu2.svg" alt="img" class="img-fluid">
                </div>
            </div>
        </div>
    </main>
    @include('campusnet::layouts/_js')
</body>
</html>
