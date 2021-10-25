@extends('campusnet::layouts/site/main')

@section('content')

<div class="row py-5">
    <div class="container">
        <div class="px-3 py-2 bg-white shadow-sm rounded-3 mb-4">
            <a href="{{ route('site.course.detail', ['slug' => $course->slug]) }}"><i class="bi-arrow-left me-1"></i>Kembali ke Kelas</a>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <h5>{{ $course->name }}</h5>
                <p>Oleh {{ $course->user->name }}</p>
                <div class="progress rounded-3 shadow-sm">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success fw-bold" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    <span class="progress-bar-label">0% dikerjakan</span>
                </div>
                @if(count($course->topics) > 0)
                    <div class="accordion mt-3" id="accordionExample">
                        @foreach($course->topics()->orderBy('num_order','asc')->get() as $key=>$topic)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $key }}">
                                <button class="accordion-button bg-theme-1 {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                    {{ $topic->name }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body p-0">
                                    @if(count($topic->materials)>0)
                                        <div class="list-group list-group-flush">
                                            @foreach($topic->materials()->orderBy('num_order','asc')->get() as $material)
                                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <div>
                                                        {{ $material->name }}
                                                        <br>
                                                        <small class="text-muted"><i class="{{ $material->type->icon }} me-1"></i> {{ $material->type->name }}</small>
                                                    </div>
                                                    <div>
                                                        <!-- <i class="bi-check-circle-fill text-success"></i> -->
                                                        <i class="bi-lock-fill"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-danger fst-italic mb-0 py-2 px-3">Belum ada materi.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-danger fst-italic mt-3 mb-0">Belum ada topik dan materi.</p>
                @endif
            </div>

            <div class="col-lg-9">
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
</script>

@endsection

@section('css')

<style type="text/css">
    .accordion-button:not(.collapsed) {background-color: var(--color-1); color: #fff;}
    .progress {height: 2.25rem; position: relative;}
    .progress .progress-bar-label {height: 2.25rem; line-height: 2.25rem; font-weight: bold; position: absolute; width: 100%; text-align: center;}
</style>

@endsection