<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CampusNet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ is_int(strpos(Request::url(), route('admin.course.index'))) ? 'active' : '' }}" href="{{ route('admin.course.index') }}">Kelas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ is_int(strpos(Request::url(), route('admin.category.index'))) ? 'active' : '' }}" href="{{ route('admin.category.index') }}">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Media</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pengajar</a>
                </li>
            </ul>
            <div class="d-flex">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hi, John!
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi-person me-1"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi-gear me-1"></i> Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi-power me-1"></i> Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>