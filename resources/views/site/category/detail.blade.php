@extends('campusnet::layouts/site/main')

@section('content')

<div class="row py-5">
    <section class="section-course">
        <div class="container">
            <h4>Kelas: {{ $category->name }}</h4>
            @if(count($courses) > 0)
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
                <hr>
                <div class="d-flex justify-content-center">
                    {!! $courses->links() !!}
                </div>
            @else
                <p><em>Belum ada data.</em></p>
            @endif
        </div>
    </section>
</div>

@endsection