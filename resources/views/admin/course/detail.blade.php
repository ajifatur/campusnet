@extends('campusnet::layouts/admin/main')

@section('title', 'Detail Kelas: '.$course->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Detail Kelas</h1>
</div>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Tentang Kelas</h5></div>
            <div class="card-body">
                <p><strong>Nama:</strong><br>{{ $course->name }}</p>
                <p><strong>Kategori:</strong><br>{{ $course->category->name }}</p>
                <p><strong>Deskripsi:</strong><br>{!! nl2br($course->description) !!}</p>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Topik Kelas</h5></div>
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <a href="{{ route('admin.topic.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi-plus me-1"></i>Tambah Topik</a>
                <br>

                @if(count($course->topics) > 0)
                <!-- Topic -->
                <p class="fst-italic small text-muted"><i class="bi-info-circle me-1"></i> Tekan dan geser topik di bawah ini untuk mengurutkannya.</p>
                <div class="sortable-topic">
                    @foreach($course->topics()->orderBy('num_order','asc')->get() as $topic)
                    <div class="card mb-2" data-id="{{ $topic->id }}">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <a href="#" data-bs-toggle="collapse" data-bs-target="#collapse-topic-{{ $topic->id }}">
                                    {{ $topic->name }}
                                </a>
                            </h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.material.create', ['course_id' => $course->id, 'topic_id' => $topic->id]) }}" class="btn btn-sm btn-outline-secondary btn-add-material" data-bs-toggle="tooltip" title="Tambah Materi"><i class="bi-plus"></i></a>
                                <a href="{{ route('admin.topic.edit', ['course_id' => $course->id, 'topic_id' => $topic->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Topik"><i class="bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-topic" data-id="{{ $topic->id }}" data-bs-toggle="tooltip" title="Hapus Topik"><i class="bi-trash"></i></a>
                            </div>
                        </div>
                        <div class="card-body collapse" id="collapse-topic-{{ $topic->id }}">
                            <p>{!! nl2br($topic->description) !!}</p>

                            <!-- Materials -->
                            <div class="card">
                                <div class="card-header"><h6 class="mb-0">Materi Kelas</h6></div>
                                <div class="card-body">
                                    @if(count($topic->materials)>0)
                                        <p class="fst-italic small text-muted"><i class="bi-info-circle me-1"></i> Tekan dan geser materi di bawah ini untuk mengurutkannya.</p>
                                        <div class="list-group sortable-material">
                                            @foreach($topic->materials()->orderBy('num_order','asc')->get() as $material)
                                                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $material->id }}">
                                                    <div>
                                                        <i class="{{ $material->type->icon }} me-1" data-bs-toggle="tooltip" title="{{ $material->type->name }}"></i>
                                                        <a href="{{ route('admin.material.detail', ['course_id' => $course->id, 'topic_id' => $topic->id, 'material_id' => $material->id]) }}">{{ $material->name }}</a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.material.edit', ['course_id' => $course->id, 'topic_id' => $topic->id, 'material_id' => $material->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Materi"><i class="bi-pencil"></i></a>
                                                        <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-material" data-id="{{ $material->id }}" data-bs-toggle="tooltip" title="Hapus Materi"><i class="bi-trash"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <em class="text-danger">Belum ada materi.</em>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <em class="text-danger">Belum ada topik.</em>
                @endif

            </div>
        </div>
    </div>
</div>

<form class="form-delete-topic d-none" method="post" action="{{ route('admin.topic.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<form class="form-delete-material d-none" method="post" action="{{ route('admin.material.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    // Button Delete Topic
    Spandiv.ButtonDelete(".btn-delete-topic", ".form-delete-topic");

    // Button Delete Material
    Spandiv.ButtonDelete(".btn-delete-material", ".form-delete-material");

    // Sortable Topic
    Spandiv.Sortable(".sortable-topic", function(event, ui) {
        var items = $(this).find(".ui-sortable-handle");
        var ids = [];
        $(items).each(function(key,elem) {
            ids.push($(elem).data("id"));
        });
        $.ajax({
            type: "post",
            url: "{{ route('admin.topic.sort') }}",
            data: {_token: "{{ csrf_token() }}", ids: ids},
            success: function(response) {
                Spandiv.Toast("#toast-sort", response);
            }
        });
    });

    // Sortable Material
    Spandiv.Sortable(".sortable-material", function(event, ui) {
        var items = $(this).find(".ui-sortable-handle");
        var ids = [];
        $(items).each(function(key,elem) {
            ids.push($(elem).data("id"));
        });
        $.ajax({
            type: "post",
            url: "{{ route('admin.material.sort') }}",
            data: {_token: "{{ csrf_token() }}", ids: ids},
            success: function(response) {
                Spandiv.Toast("#toast-sort", response);
            }
        });
    });
</script>

@endsection