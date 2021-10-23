<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
    <div class="container justify-content-between align-items-center">
        
        <button class="navbar-toggler me-0 me-lg-3 border-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi-grid-fill h5 m-0"></i>
        </button>
        <a class="navbar-brand m-0 me-lg-3 p-0 d-flex align-items-center" href="/">
            <img width="160" src="https://demo.campusnet.id/assets/images/logo/campusnet.webp">
        </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <form class="mx-2 my-auto d-inline w-100" method="get" action="/search">
                <div class="input-group">
                    <input type="text" name="q" class="form-control border border-right-0" placeholder="Cari..." value="{{ isset($_GET) && isset($_GET['q']) ? $_GET['q'] : '' }}" style="border-radius: 1.5em 0 0 1.5em" required>
                    <span class="input-group-append">
                        <button class="btn btn-outline border border-left-0" type="submit" style="border-radius: 0 1.5em 1.5em 0">
                            <i class="bi-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item order-lg-0 order-2 {{ strpos(Request::url(), '/kategori') ? 'active' : '' }}">
                    <a class="nav-link font-weight-bold" href="/kategori">Kategori</a>
                </li>
                <li class="nav-item order-lg-0 order-3 {{ is_int(strpos(Request::url(), route('site.course.index'))) ? 'active' : '' }}">
                    <a class="nav-link font-weight-bold" href="{{ route('site.course.index') }}">Kelas</a>
                </li>
            </ul>
        </div>

        @if(Auth::guest())
        <a class="btn btn-primary rounded-3 px-3 ms-0 ms-lg-2" href="{{ route('auth.login') }}">Masuk</a>
        @else
        <div class="dropdown dropdown-user order-lg-0 order-1">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi-person h5 m-0"></i>
            </a>
            <div class="dropdown-menu rounded-2 dropdown-menu-end shadow-sm shadow-md-0 border-md border-0" aria-labelledby="navbarDropdown">
                <h5 class="dropdown-header disabled" href="#">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img src="{{ Auth::user()->photo != '' ? asset('assets/images/users/'.Auth::user()->photo) : asset('assets/images/default/user.jpg') }}" height="40" class="rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <sapan>Hai, <strong>{{ Auth::user()->name }}</strong></sapan>
                            <br>
                            <span class="user-role">({{ role(Auth::user()->role_id) }})</span>
                        </div>
                    </div>
                </h5>
                <div class="dropdown-divider"></div>
                @if(Auth::user()->role_id != role('learner'))
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}" target="_blank">Dashboard</a>
                @endif
                <a class="dropdown-item" href="/profil">Profil</a>
                @if(Auth::user()->role_id == role('instructor'))
                <a class="dropdown-item" href="/list-kelas">List Kelas</a>
                @endif
                @if(Auth::user()->role_id == role('learner'))
                <a class="dropdown-item" href="/riwayat-kelas">Riwayat Kelas</a>
                @endif
                <a class="dropdown-item" href="/ganti-password">Ganti Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item btn-logout" href="#">Keluar</a>
            </div>
        </div>
        <form id="form-logout" class="d-none" method="post" action="{{ route('auth.logout') }}">@csrf</form>
        @endif

    </div>
</nav>