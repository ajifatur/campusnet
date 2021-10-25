@extends('campusnet::layouts/site/main')

@section('content')

<div class="row py-5">
    <div class="container">
        <div class="rounded-2 bg-theme-1 px-4">
            <div class="row align-items-center">
                <div class="col-lg-9 order-last order-lg-first">
                    <p class="h3 mb-3 text-white">{{ $course->name }}</p>
                    <p class="text-light">
                        <span class="badge bg-light"><a class="text-decoration-none" href="{{ route('site.category.detail', ['slug' => $course->category->slug]) }}">{{ $course->category->name }}</a></span>
                    </p>
                    <p class="text-light">Pengajar: <a class="text-light" href="/pengajar/farisfanani2">Faris Fanani</a></p>
                </div>
                <div class="col-lg-3 order-first order-lg-last py-4">
                    <img class="img-fluid w-100 gambar-kelas rounded-2" src="https://demo.campusnet.id/assets/images/kelas/2021-03-08-22-52-23.webp" alt="Sampul Gambar">
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-9 order-last order-lg-first">
                <h4>Deskripsi</h4>
                <p>{!! nl2br($course->description) !!}</p>
                <h4>Materi</h4>
                @if(count($course->topics) > 0)
                    <div class="accordion" id="accordionExample">
                        @foreach($course->topics()->orderBy('num_order','asc')->get() as $key=>$topic)
                        <div class="accordion-item rounded-3">
                            <h2 class="accordion-header rounded-3" id="heading-{{ $key }}">
                                <button class="accordion-button bg-theme-1 rounded-3 {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                    {{ $topic->name }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @if(count($topic->materials)>0)
                                        <ul class="list-group">
                                            @foreach($topic->materials()->orderBy('num_order','asc')->get() as $material)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="{{ $material->type->icon }} me-1" data-bs-toggle="tooltip" title="{{ $material->type->name }}"></i>
                                                        {{ $material->name }}
                                                    </div>
                                                    <div><i class="bi-lock-fill"></i></div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-danger fst-italic mb-0">Belum ada materi.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-danger fst-italic mb-0">Belum ada topik dan materi.</p>
                @endif
            </div>

            <div class="col-lg-3 order-first order-lg-last mb-3 mb-lg-0">
                <div class="sticky-lg-top">
                    <div class="d-grid gap-2">
                        @if(Auth::check() && Auth::user()->role_id == role('learner') && in_array(Auth::user()->id, $course->learners()->pluck('user_id')->toArray()))
                        <div class="progress rounded-3 shadow-sm">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success fw-bold" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            <span class="progress-bar-label">0% dikerjakan</span>
                        </div>
                        @endif
                        @if(Auth::guest() || (Auth::check() && Auth::user()->role_id == role('learner')))
                        <a href="#" class="btn btn-theme-1 rounded-3 shadow-sm fw-bold btn-register-course">Belajar Sekarang</a>
                        @endif
                    </div>
                    <div class="card rounded-2 mt-2">
                        <div class="card-body text-center">
                            <h5 class="mb-3">Pengajar</h5>
                            <img src="{{ $course->user->photo != '' ? asset('assets/images/users/'.$course->user->photo) : asset('assets/images/default/user.jpg') }}" class="rounded-circle mb-2" width="100">
                            <p class="mb-0">{{ $course->user->name }}</p>
                            <p class="mb-0">({{ count($course->user->courses) }} Kelas)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form-register-course" class="d-none" action="{{ route('site.course.register', ['slug' => $course->slug]) }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $course->id }}">
</form>

@endsection

@section('js')

<script type="text/javascript">
    // Button Register Course
    $(document).on("click", ".btn-register-course", function(e) {
        e.preventDefault();
        $("#form-register-course").submit();
    });
</script>

@endsection

@section('css')

<style type="text/css">
    .accordion-button:not(.collapsed) {background-color: var(--color-1); color: #fff;}
    .sticky-lg-top {top: 70px;}
    .progress {height: 2.25rem; position: relative;}
    .progress .progress-bar-label {height: 2.25rem; line-height: 2.25rem; font-weight: bold; position: absolute; width: 100%; text-align: center;}
</style>

@endsection