@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/course/_sidebar')
    </div>
    <div class="col-lg-10 col-md-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.material.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $material->id }}">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="type_code" value="{{ $material->type->code }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ $material->name }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="content-field">
                        @if($material->type->code == 'text')
                            <!-- Content: Text -->
                            <div class="row mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">Konten</label>
                                <div class="col-lg-10 col-md-9">
                                    <textarea name="content" class="d-none"></textarea>
                                    <div id="quill-editor">{!! $material->type->code == 'text' ? html_entity_decode($material->content) : '' !!}</div>
                                    @if($errors->has('content'))
                                    <div class="small text-danger">{{ $errors->first('content') }}</div>
                                    @endif
                                </div>
                            </div>
                        @elseif($material->type->code == 'uploaded-video')
                            <!-- Content: Video (Upload File) -->
                            <div class="row mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">File Video <span class="text-danger">*</span></label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="hidden" name="content" value="{{ $content ? $content->id : '' }}">
                                    <input type="file" name="content" class="d-none" id="uploaded-video-file" accept="video/*">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-file"><i class="bi-files me-1"></i> Upload/Pilih File</button>
                                    <div class="file-title mt-1"><i class="bi-camera-video me-1"></i> <span>{{ $content ? $content->name : '' }}</span></div>
                                    @if($errors->has('content'))
                                    <div class="small text-danger">{{ $errors->first('content') }}</div>
                                    @endif
                                </div>
                            </div>
                        @elseif($material->type->code == 'youtube-video')
                            <!-- Content: Video (YouTube) -->
                            <div class="row mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">ID YouTube <span class="text-danger">*</span></label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" name="content" class="form-control form-control-sm {{ $errors->has('content') ? 'border-danger' : '' }}" value="{{ $content ? $content->name : '' }}" id="youtube-id">
                                    <div class="youtube-media mt-2">
                                        <input type="hidden" name="youtube[id]" value="{{ $content ? $content->id : '' }}">
                                        <input type="hidden" name="youtube[title]" value="{{ $content ? $content->title : '' }}">
                                        <input type="hidden" name="youtube[author]" value="{{ $content ? $content->author : '' }}">
                                        <input type="hidden" name="youtube[thumbnail]" value="{{ $content ? $content->thumbnail : '' }}">
                                        <div class="message {{ $content ? 'd-none' : '' }}"><i class="bi-youtube me-1"></i> <span class="text-danger">Video YouTube tidak ditemukan.</span></div>
                                        <div class="d-flex {{ $content ? '' : 'd-none' }}">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $content ? $content->thumbnail : '' }}" class="img-thumbnail">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0 title">{{ $content ? $content->title : '' }}</p>
                                                <p class="mb-0 small author">{{ $content ? $content->author : '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($errors->has('content'))
                                    <div class="small text-danger">{{ $errors->first('content') }}</div>
                                    @endif
                                </div>
                            </div>
                        @elseif($material->type->code == 'file')
                            <!-- Content: File -->
                            <div class="row mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">File <span class="text-danger">*</span></label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="hidden" name="content" value="{{ $content ? $content->id : '' }}">
                                    <input type="file" name="content" class="d-none" id="uploaded-file">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-file"><i class="bi-files me-1"></i> Upload/Pilih File</button>
                                    <div class="file-title mt-1"><i class="bi-file-check me-1"></i> <span>{{ $content ? $content->name : '' }}</span></div>
                                    @if($errors->has('content'))
                                    <div class="small text-danger">{{ $errors->first('content') }}</div>
                                    @endif
                                </div>
                            </div>
                        @elseif($material->type->code == 'assignment')
                            <!-- Content: Assignment -->
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="content[id]" value="{{ $content ? $content->id : '' }}">
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label">Judul Tugas <span class="text-danger">*</span></label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="content[name]" class="form-control form-control-sm {{ $errors->has('content.name') ? 'border-danger' : '' }}" value="{{ $content ? $content->name : '' }}">
                                            @if($errors->has('content.name'))
                                            <div class="small text-danger">{{ $errors->first('content.name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Tugas <span class="text-danger">*</span></label>
                                        <div class="col-lg-10 col-md-9">
                                            <textarea name="content[description]" class="form-control form-control-sm {{ $errors->has('content.description') ? 'border-danger' : '' }}" rows="5">{{ $content ? $content->description : '' }}</textarea>
                                            @if($errors->has('content.description'))
                                            <div class="small text-danger">{{ $errors->first('content.description') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-lg-2 col-md-3 col-form-label">Waktu Tugas <span class="text-danger">*</span></label>
                                        <div class="col-lg-4 col-md-5">
                                            <input type="text" name="content[time]" class="form-control form-control-sm {{ $errors->has('content.time') ? 'border-danger' : '' }}" value="">
                                            @if($errors->has('content.time'))
                                            <div class="small text-danger">{{ $errors->first('content.time') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                            <a href="{{ route('admin.course.detail', ['id' => $course->id]) }}" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal File -->
<div class="modal fade" id="modal-file" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload/Pilih File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="true"><i class="bi-upload me-1"></i> Upload File</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose" type="button" role="tab" aria-controls="choose" aria-selected="false"><i class="bi-hand-index me-1"></i> Pilih File</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane py-3 fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <div class="d-grid">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-upload"><i class="bi-upload me-1"></i> Upload File</button>
                        </div>
                    </div>
                    <div class="tab-pane py-3 fade" id="choose" role="tabpanel" aria-labelledby="choose-tab">
                        <div class="list-group">Memuat...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Progress -->
<div class="modal fade" id="modal-progress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center mb-1">Mengupload file...</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://campusdigital.id/assets/plugins/quill/quill.min.js"></script>
<script src="https://cdn.rawgit.com/kensnyder/quill-image-resize-module/3411c9a7/image-resize.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    // Quill Editor
    Spandiv.Quill("#quill-editor");

    // Daterangepicker
    Spandiv.DateRangePicker("input[name='content[time]']", {
        start: "{{ $content ? date('d/m/Y H:i', strtotime($content->start_at)) : null }}",
        end: "{{ $content ? date('d/m/Y H:i', strtotime($content->end_at)) : null }}",
    });

    // Show Modal File Event
    var modalFile = document.getElementById("modal-file");
    modalFile.addEventListener("show.bs.modal", function(event) {
        var triggerFirstTabEl = document.querySelector("#modal-file li:first-child button");
        bootstrap.Tab.getInstance(triggerFirstTabEl).show();
    });

    // Nav Tabs Event
    var triggerTabList = [].slice.call(document.querySelectorAll("#modal-file button[data-bs-toggle=tab]"));
    triggerTabList.forEach(function(triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);

        // Shown Tab Event
        triggerEl.addEventListener("shown.bs.tab", function(event) {
            var id = $(event.target).attr("id");
            var type_code = $("input[name=type_code]").val();
            if(id === 'choose-tab') {
                // AJAX Call
                $.ajax({
                    type: "get",
                    url: "{{ route('api.media.index') }}",
                    data: {type: type_code, user_id: "{{ Auth::user()->id }}"},
                    success: function(files){
                        var html = '';
                        $(files).each(function(key,file) {
                            html += '<a href="#" class="list-group-item list-group-item-action btn-choose-file" data-id="' + file.id + '" data-name="' + file.name + '">' + file.name + '</a>';
                        });
                        $("#choose .list-group").html(html);
                    }
                });
            }
        });
    });

    // Change File
    $(document).on("change", "input[type=file]", function() {
        // Change value and text
        var type_code = $("input[name=type_code]").val();
        var filename = document.getElementById($(this).attr("id")).files[0].name;
        $("input[type=hidden][name=content]").val(filename);
        $(".file-title span").text(filename);
        $(".file-title").removeClass("d-none");

        // Hide modal
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modal-file"));
        modal.hide();
    });

    // Button Upload File
    $(document).on("click", ".btn-upload", function(e) {
        e.preventDefault();
        $("input:not([disabled])[type=file][name=content]").trigger("click");
    });

    // Button Choose File
    $(document).on("click", ".btn-choose-file", function(e) {
        // Change value and text
        e.preventDefault();
        var id = $(this).data("id");
        var name = $(this).data("name");
        $("input[type=hidden][name=content]").val(id);
        $(".file-title span").text(name);
        $(".file-title").removeClass("d-none");

        // Hide modal
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modal-file"));
        modal.hide();
    });

    // Change YouTube ID
    $(document).on("keyup", "#youtube-id", function() {
        var id = $(this).val();
        if(id != '') {
            $.ajax({
                type: "get",
                url: "https://www.googleapis.com/youtube/v3/videos",
                data: {id: id, key: "{{ env('YOUTUBE_API_KEY') }}", part: "snippet"},
                success: function(response) {
                    var items = response.items;
                    if(items.length > 0) {
                        $(".youtube-media").find(".message").addClass("d-none");
                        $(".youtube-media").find(".d-flex").removeClass("d-none");
                        $(".youtube-media").find("img").attr("src",items[0].snippet.thumbnails.default.url);
                        $(".youtube-media").find(".title").text(items[0].snippet.title);
                        $(".youtube-media").find(".author").text(items[0].snippet.channelTitle);
                        $(".youtube-media").find("input[name='youtube[title]']").val(items[0].snippet.title);
                        $(".youtube-media").find("input[name='youtube[author]']").val(items[0].snippet.channelTitle);
                        $(".youtube-media").find("input[name='youtube[thumbnail]']").val(items[0].snippet.thumbnails.default.url);
                    }
                    else {
                        $(".youtube-media").find(".message").removeClass("d-none");
                        $(".youtube-media").find(".d-flex").addClass("d-none");
                        $(".youtube-media").find("input[name='youtube[title]']").val(null);
                        $(".youtube-media").find("input[name='youtube[author]']").val(null);
                        $(".youtube-media").find("input[name='youtube[thumbnail]']").val(null);
                        $("#youtube-id").val(null);
                    }
                }
            });
        }
    });

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e) {
        e.preventDefault();
        var type_code = $("input[name=type_code]").val();
        var name = $("input[name=name]").val();
        var content = $("input[type=hidden][name=content]").val();

        if(type_code === "text") {
            var editor = document.querySelector("#quill-editor");
            var html = editor.children[0].innerHTML;
            $("textarea[name=content]").text(html);
        }
        else if(type_code === "uploaded-video") {
            var file_content = document.getElementById("uploaded-video-file").files[0];
            if(name !== "" && content !== "" && file_content !== undefined) {
                formProgress({content: file_content, user_id: "{{ Auth::user()->id }}"});
                return;
            }
        }
        else if(type_code === "file") {
            var file_content = document.getElementById("uploaded-file").files[0];
            if(name !== "" && content !== "" && file_content !== undefined) {
                formProgress({content: file_content, user_id: "{{ Auth::user()->id }}"});
                return;
            }
        }

        // Submit form
        $(this).parents("form").submit();
    });
</script>

<script type="text/javascript">
    // AJAX request form with progress
    let formProgress = (data) => {
        // Form
        var form = new FormData();
        form.append("content", data.content);
        form.append("user_id", data.user_id);

        // Upload via AJAX
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                var result = JSON.parse(this.responseText);
                $("input[type=hidden][name=content]").val(result.id);
                $("input[type=file]").attr("disabled","disabled").val(null);
                $("form").submit();
            }
        };
        ajax.open("POST", "{{ route('api.media.upload') }}", true);
        ajax.send(form);

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById("modal-progress"));
        modal.show();
    }

    // Progress handler
    let progressHandler = (event) => {
        // Count percentage
        var percent = (event.loaded / event.total) * 100;

        // Show percentage
        $("#modal-progress").find(".progress-bar").text(Math.round(percent) + '%').css('width', Math.round(percent) + '%');

        // Change progress class
        if(event.loaded === event.total && Math.round(percent) === 100) {
            $("#modal-progress").find(".progress-bar").addClass("bg-success").text("100% (Mohon tunggu sebentar...)");
        };
    }
</script>

@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="https://campusdigital.id/assets/plugins/quill/quill.snow.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<style type="text/css">
    #quill-editor {height: 400px;}
</style>

@endsection