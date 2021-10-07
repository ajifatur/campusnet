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

                <a href="{{ route('admin.topic.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi-plus me-1"></i>Tambah Topik</a>

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
                                                        <a href="#">{{ $material->name }}</a>
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

<form class="form-delete-material d-none" method="post" action="{{ route('admin.material.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort-success" role="alert" aria-live="assertive" aria-atomic="true">
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
    $(document).on("click", ".btn-delete-topic", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask) {
            $(".form-delete-topic").find("input[name=id]").val(id);
            $(".form-delete-topic").submit();
        }
    });

    // Button Delete Material
    $(document).on("click", ".btn-delete-material", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menghapus data ini?");
        if(ask) {
            $(".form-delete-material").find("input[name=id]").val(id);
            $(".form-delete-material").submit();
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
            var ids = [];
            $(items).each(function(key,elem){
                ids.push($(elem).data("id"));
            });
            $.ajax({
                type: "post",
                url: "{{ route('admin.topic.sort') }}",
                data: {_token: "{{ csrf_token() }}", ids: ids},
                success: function(response) {
                    Toast(response);
                }
            });
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
            var items = $(this).find(".list-group-item");
            var ids = [];
            $(items).each(function(key,elem){
                ids.push($(elem).data("id"));
            });
            $.ajax({
                type: "post",
                url: "{{ route('admin.material.sort') }}",
                data: {_token: "{{ csrf_token() }}", ids: ids},
                success: function(response) {
                    Toast(response);
                }
            });
        }
    });
    $(".sortable-material").disableSelection();
</script>
<script type="text/javascript">
    let Toast = (message) => {
        $(".toast-container").removeClass("d-none");
        $("#toast-sort-success").find(".toast-body").text(message);
        var toast = new bootstrap.Toast(document.getElementById("toast-sort-success"));
        toast.show();
    }
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