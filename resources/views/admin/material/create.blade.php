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
                                <input type="file" name="content" id="uploaded-video-file" data-code="uploaded-video" accept="video/*">
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

<script type="text/javascript">
    // Variables
    let _typeCode = $("input[name=type_code]");
    let _contentField = $(".content-field");
    let _modalProgress = new bootstrap.Modal(document.getElementById("modal-progress"));

    // Quill Editor
    QuillEditor("#quill-editor");

    // Change Type
    $(document).on("change", "select[name=type]", function() {
        var type = $(this).val();
        var type_code = $(this).find("option[value="+type+"]").data("code");
        $(_typeCode).val(type_code);
        $(_contentField).find(".row").each(function(key,elem) {
            if($(elem).data("code") == type_code) {
                $("textarea[name=content][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $("input[name=content][data-code="+$(elem).data("code")+"]").removeAttr("disabled");
                $(elem).removeClass("d-none");
            }
            else {
                $("textarea[name=content][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $("input[name=content][data-code="+$(elem).data("code")+"]").attr("disabled","disabled");
                $(elem).addClass("d-none");
            }
        });
    });

    // Change File
    $(document).on("change", "input[type=file]", function() {
        var filename = document.getElementById($(this).attr("id")).files[0].name;
        $(this).parents(".row").find("input[type=hidden][name=content]").val(filename);
    })

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e) {
        e.preventDefault();
        var type_code = $(_typeCode).val();

        if(type_code === "text") {
            var editor = document.querySelector("#quill-editor");
            var html = editor.children[0].innerHTML;
            $(_contentField).find(".row[data-code="+type_code+"]").find("textarea[name=content]").text(html);
        }
        else if(type_code === "uploaded-video") {
            var name = $("input[name=name]").val();
            var content = $(_contentField).find(".row[data-code="+type_code+"]").find("input[name=content]").val();

            // If validation is success, upload file
            if(name !== "" && content !== "") {
                // Form
                var form = new FormData();
                form.append("_token", "{{ csrf_token() }}");
                form.append("content", document.getElementById("uploaded-video-file").files[0]);

                // Upload via AJAX
                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.open("POST", "{{ route('admin.media.upload') }}", true);
                ajax.send(form);

                // Show modal
                _modalProgress.show();
                return;
            }
        }

        $(this).parents("form").submit();
    });
</script>

<script type="text/javascript">
    // Progress handler
    let progressHandler = (event) => {
        console.log(event);

        // Count percentage
        var percent = (event.loaded / event.total) * 100;

        // Show percentage
        $("#modal-progress").find(".progress-bar").text(Math.round(percent) + '%').css('width', Math.round(percent) + '%');

        // Submit form
        if(event.loaded === event.total && Math.round(percent) === 100) {
            $("#modal-progress").find(".progress-bar").addClass("bg-success");
            window.setTimeout(() => {
                $("input[type=file]").attr("disabled","disabled").val(null);
                // $("form").submit();
            }, 1000);
        };
    }
</script>

@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="https://campusdigital.id/assets/plugins/quill/quill.snow.css">
<style type="text/css">
    #quill-editor {height: 400px;}
</style>

@endsection