@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/course/_sidebar')
    </div>
    <div class="col-lg-10 col-md-9">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.material.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                    <input type="hidden" name="type_code" value="{{ old('type_code') }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ old('name') }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tipe <span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-5">
                            <select name="type" class="form-select form-select-sm {{ $errors->has('type') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" data-code="{{ $type->code }}" {{ old('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                            <div class="small text-danger">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="content-field">
                        <!-- Content: Text -->
                        <div class="row mb-3 {{ old('type_code') == 'text' ? '' : 'd-none' }}" data-code="text">
                            <label class="col-lg-2 col-md-3 col-form-label">Konten</label>
                            <div class="col-lg-10 col-md-9">
                                <textarea name="content" class="d-none" data-code="text"></textarea>
                                <div id="quill-editor"></div>
                                @if($errors->has('content') && old('type_code') == 'text')
                                <div class="small text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- Content: Video (Upload File) -->
                        <div class="row mb-3 {{ old('type_code') == 'uploaded-video' ? '' : 'd-none' }}" data-code="uploaded-video">
                            <label class="col-lg-2 col-md-3 col-form-label">File Video <span class="text-danger">*</span></label>
                            <div class="col-lg-10 col-md-9">
                                <input type="hidden" name="content" data-code="uploaded-video">
                                <input type="file" name="content" class="d-none" id="uploaded-video-file" data-code="uploaded-video" accept="video/*">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-file"><i class="bi-files me-1"></i> Upload/Pilih File</button>
                                <div class="file-title mt-1 d-none"><i class="bi-camera-video me-1"></i> <span></span></div>
                                @if($errors->has('content') && old('type_code') == 'uploaded-video')
                                <div class="small text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- Content: Video (YouTube) -->
                        <div class="row mb-3 {{ old('type_code') == 'youtube-video' ? '' : 'd-none' }}" data-code="youtube-video">
                            <label class="col-lg-2 col-md-3 col-form-label">URL YouTube <span class="text-danger">*</span></label>
                            <div class="col-lg-10 col-md-9">
                                <input type="text" name="content" class="form-control form-control-sm {{ $errors->has('content') && old('type_code') == 'youtube-video' ? 'border-danger' : '' }}" value="{{ old('type_code') == 'youtube-video' ? old('content') : '' }}" data-code="youtube-video">
                                @if($errors->has('content') && old('type_code') == 'youtube-video')
                                <div class="small text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- Content: File -->
                        <div class="row mb-3 {{ old('type_code') == 'file' ? '' : 'd-none' }}" data-code="file">
                            <label class="col-lg-2 col-md-3 col-form-label">File <span class="text-danger">*</span></label>
                            <div class="col-lg-10 col-md-9">
                                <input type="hidden" name="content" data-code="file">
                                <input type="file" name="content" class="d-none" id="uploaded-file" data-code="file">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-file"><i class="bi-files me-1"></i> Upload/Pilih File</button>
                                <div class="file-title mt-1 d-none"><i class="bi-file-check me-1"></i> <span></span></div>
                                @if($errors->has('content') && old('type_code') == 'file')
                                <div class="small text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- Content: Assignment -->
                        <div class="row {{ old('type_code') == 'assignment' ? '' : 'd-none' }}" data-code="assignment">
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label class="col-lg-2 col-md-3 col-form-label">Judul Tugas <span class="text-danger">*</span></label>
                                    <div class="col-lg-10 col-md-9">
                                        <input type="text" name="content[name]" class="form-control form-control-sm {{ $errors->has('content.name') && old('type_code') == 'assignment' ? 'border-danger' : '' }}" value="{{ old('type_code') == 'assignment' ? old('content.name') : '' }}" data-code="assignment">
                                        @if($errors->has('content.name') && old('type_code') == 'assignment')
                                        <div class="small text-danger">{{ $errors->first('content.name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-lg-2 col-md-3 col-form-label">Deskripsi Tugas <span class="text-danger">*</span></label>
                                    <div class="col-lg-10 col-md-9">
                                        <textarea name="content[description]" class="form-control form-control-sm {{ $errors->has('content.description') && old('type_code') == 'assignment' ? 'border-danger' : '' }}" rows="5" data-code="assignment">{{ old('type_code') == 'assignment' ? old('content.description') : '' }}</textarea>
                                        @if($errors->has('content.description') && old('type_code') == 'assignment')
                                        <div class="small text-danger">{{ $errors->first('content.description') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-2 col-md-3 col-form-label">Waktu Tugas <span class="text-danger">*</span></label>
                                    <div class="col-lg-4 col-md-5">
                                        <input type="text" name="content[time]" class="form-control form-control-sm {{ $errors->has('content.time') && old('type_code') == 'assignment' ? 'border-danger' : '' }}" value="{{ old('type_code') == 'assignment' ? old('content.time') : '' }}" data-code="assignment">
                                        @if($errors->has('content.time') && old('type_code') == 'assignment')
                                        <div class="small text-danger">{{ $errors->first('content.time') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div class="list-group"></div>
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

@include('campusnet::layouts/js/quill')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    // Quill Editor
    QuillEditor("#quill-editor");

    // Daterangepicker
    $("input[name='content[time]']").daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        showDropdowns: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(48, 'hour'),
        locale: {
            format: 'DD/MM/YYYY HH:mm'
        }
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
                    data: {type: type_code},
                    success: function(files){
                        var html = '';
                        for(var i=0; i<files.length; i++) {
                            html += '<a href="#" class="list-group-item list-group-item-action">' + files[i] + '</a>';
                        }
                        $("#choose .list-group").html(html);
                    }
                });
            }
        });
    });

    // Change Type
    $(document).on("change", "select[name=type]", function() {
        var type_id = $(this).val();
        var type_code = $(this).find("option[value="+type_id+"]").data("code");
        $("input[name=type_code]").val(type_code);
        $(".content-field").find(".row[data-code]").each(function(key,elem) {
            if($(elem).data("code") == type_code) {
                $("textarea[name=content][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $("input[name=content][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $("input[name='content[name]'][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $("textarea[name='content[description]'][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $("input[name='content[time]'][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $(elem).removeClass("d-none");
            }
            else {
                $("textarea[name=content][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $("input[name=content][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $("input[name='content[name]'][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $("textarea[name='content[description]'][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $("input[name='content[time]'][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $(elem).addClass("d-none");
            }
        });
    });

    // Change File
    $(document).on("change", "input[type=file]", function() {
        // Change value and text
        var type_code = $("input[name=type_code]").val();
        var filename = document.getElementById($(this).attr("id")).files[0].name;
        $(".row[data-code="+type_code+"]").find("input[type=hidden][name=content]").val(filename);
        $(".row[data-code="+type_code+"]").find(".file-title span").text(filename);
        $(".row[data-code="+type_code+"]").find(".file-title").removeClass("d-none");

        // Hide modal
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("modal-file"));
        modal.hide();
    });

    // Button Upload File
    $(document).on("click", ".btn-upload", function(e) {
        e.preventDefault();
        $("input:not([disabled])[type=file][name=content]").trigger("click");
    });

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e) {
        e.preventDefault();
        var type_code = $("input[name=type_code]").val();
        var name = $("input[name=name]").val();
        var content = $("input[type=hidden][name=content][data-code="+type_code+"]").val();

        if(type_code === "text") {
            var editor = document.querySelector("#quill-editor");
            var html = editor.children[0].innerHTML;
            $("textarea[name=content][data-code="+type_code+"]").text(html);
        }
        else if(type_code === "uploaded-video") {
            if(name !== "" && content !== "") {
                formProgress({
                    content: document.getElementById("uploaded-video-file").files[0]
                });
                return;
            }
        }
        else if(type_code === "file") {
            if(name !== "" && content !== "") {
                formProgress({
                    content: document.getElementById("uploaded-file").files[0]
                });
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
        form.append("_token", "{{ csrf_token() }}");
        form.append("content", data.content);

        // Upload via AJAX
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                var result = JSON.parse(this.responseText);
                $("input[type=hidden][name=content]").val(result.filename);
                $("input[type=file]").attr("disabled","disabled").val(null);
                $("form").submit();
            }
        };
        ajax.open("POST", "{{ route('admin.media.upload') }}", true);
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style type="text/css">
    #quill-editor {height: 400px;}
</style>

@endsection