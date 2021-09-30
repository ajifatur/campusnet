@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/course/_sidebar')
    </div>
    <div class="col-lg-8 col-md-6">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Topik Kelas</h6></div>
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="mb-3">
                    <a href="{{ route('admin.topic.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i>Tambah Topik</a>
                </div>
                <div class="sortable-topic">
                    @foreach($course->topics()->orderBy('num_order','asc')->get() as $topic)
                    <div class="card mb-2" data-id="{{ $topic->id }}">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ $topic->name }}</h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.material.create', ['course_id' => $course->id, 'topic_id' => $topic->id]) }}" class="btn btn-sm btn-outline-secondary btn-add-material" data-bs-toggle="tooltip" title="Tambah Materi"><i class="bi-plus"></i></a>
                                <a href="{{ route('admin.topic.edit', ['course_id' => $course->id, 'topic_id' => $topic->id]) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Edit Topik"><i class="bi-pencil"></i></a>
                                <a href="#" class="btn btn-sm btn-outline-secondary btn-delete-topic" data-id="{{ $topic->id }}" data-bs-toggle="tooltip" title="Hapus Topik"><i class="bi-trash"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($topic->materials)>0)
                                <div class="list-group sortable-material">
                                    @foreach($topic->materials()->orderBy('num_order','asc')->get() as $material)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $material->name }}</h6>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Tentang Kelas</h6></div>
            <div class="card-body">
                <p><strong>Nama:</strong><br>{{ $course->name }}</p>
                <p><strong>Kategori:</strong><br>{{ $course->category->name }}</p>
                <p><strong>Deskripsi:</strong><br>{!! nl2br($course->description) !!}</p>
            </div>
        </div>
    </div>
</div>

<form class="form-delete-topic d-none" method="post" action="{{ route('admin.topic.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<div class="toast-container position-absolute top-0 end-0">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    // Button Delete Topic
    $(document).on("click", ".btn-delete-topic", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask) {
            $(".form-delete-topic").find("input[name=id]").val(id);
            $(".form-delete-topic").submit();
        }
    });

    // Sortable Topic
    $(".sortable-topic").sortable({
        placeholder: "ui-state-highlight",
        start: function(event, ui){
            $(".ui-state-highlight").css("height", $(ui.item).outerHeight());
        },
        update: function(event, ui){
            var items = $(this).find(".card");
            var keys = [];
            var ids = [];
            $(items).each(function(key,elem){
                ids.push($(elem).data("id"));
            });
            $.ajax({
                type: "post",
                url: "{{ route('admin.topic.sort') }}",
                data: {_token: "{{ csrf_token() }}", ids: ids},
                success: function(response) {
                    $("#toast-sort-success").find(".toast-body").text(response);
                    var toast = new bootstrap.Toast(document.getElementById("toast-sort-success"));
                    toast.show();
                }
            })
        }
    });
    $(".sortable-topic").disableSelection();

    // Sortable Material
    $(".sortable-material").sortable({
        placeholder: "ui-state-highlight",
        start: function(event, ui){
            $(".ui-state-highlight").css("height", $(ui.item).outerHeight());
        },
        update: function(event, ui){
            console.log("Sorted");
        }
    });
    $(".sortable-material").disableSelection();
</script>

@endsection

@section('css')

<style type="text/css">
    .toast-container {margin: var(--bs-gutter-x,.75rem);}
    .ui-state-highlight {height: 2rem; margin-bottom: 1rem;}
    .sortable-topic .card {cursor: move;}
    .sortable-material .list-group-item {cursor: move;}
</style>

@endsection