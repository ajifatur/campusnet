@extends('campusnet::layouts/site/main')

@section('content')

<div class="row py-5">
    <section class="section-carousel">
        <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class=""></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner shadow-sm rounded-3">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="https://demo.campusnet.id/assets/images/carousel/2021-03-08-22-59-45.webp" class="d-block w-100 rounded-3 shadow" alt="...">
                    </div>
                    <div class="carousel-item " data-bs-interval="5000">
                        <img src="https://demo.campusnet.id/assets/images/carousel/2021-03-08-23-01-29.webp" class="d-block w-100 rounded-3 shadow" alt="...">
                    </div>
                    <div class="carousel-item " data-bs-interval="5000">
                        <img src="https://demo.campusnet.id/assets/images/carousel/2021-03-08-23-02-00.webp" class="d-block w-100 rounded-3 shadow" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <section class="section-category mt-5">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-2">
                <div class="card-header bg-theme-1 fw-bold rounded-2 border-0 shadow">
                    <p class="m-0">Kategori</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($categories as $category)
                        <a href="{{ route('site.category.detail', ['slug' => $category->slug]) }}" class="col-4 col-md-3 col-lg-2 text-center mb-2 mb-lg-0 transition">
                            <div class="card h-100">
                                <div class="card-body p-2"><i class="bi-box h5"></i><br>{{ $category->name }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-transparent text-center">
                    <a href="{{ route('site.category.index') }}" class="btn btn-theme-1 rounded-3">Semua Kategori</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-course mt-5">
        <div class="container">
            <h4>Kelas</h4>
            <p>Kelas yang mungkin anda sukai</p>
            <div class="row"> 
                @foreach($courses as $course)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 transition">
                    <div class="card h-100 shadow-sm rounded-2 border-0">
                        <a href="{{ route('site.course.detail', ['slug' => $course->slug]) }}">
                            <img class="card-img-top rounded-2 shadow" src="https://demo.campusnet.id/assets/images/kelas/2021-08-30-14-00-02.png" alt="Sampul Gambar">
                        </a>
                        <div class="card-badge">
                            <span class="badge bg-theme-1"><a class="text-white text-decoration-none" href="{{ route('site.category.detail', ['slug' => $course->category->slug]) }}">{{ $course->category->name }}</a></span>
                        </div>
                        <div class="card-body">
                            <p class="card-title h6 mb-0"><a class="text-dark text-decoration-none" href="{{ route('site.course.detail', ['slug' => $course->slug]) }}">{{ $course->name }}</a></p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <p class="small mb-0">Oleh <a class="text-decoration-none" href="#">{{ $course->user->name }}</a></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('site.course.index') }}" class="btn btn-theme-1 rounded-3">Tampilkan Lainnya</a>
            </div>
        </div>
    </section>
</div>

@endsection