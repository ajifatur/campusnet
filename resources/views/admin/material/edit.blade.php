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
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ $material->name }}" autofocus>
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
                                    @if($errors->has('content'))
                                        <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @else
                                        <option value="{{ $type->id }}" {{ $material->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('type'))
                            <div class="small text-danger">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="content-field">
                        <!-- Content: Text -->
                        <div class="row mb-3 {{ $material->type_id == 1 ? '' : 'd-none' }}" data-id="1">
                            <label class="col-lg-2 col-md-3 col-form-label">Konten</label>
                            <div class="col-lg-10 col-md-9">
                                <textarea name="content" class="d-none" data-id="1" {{ $material->type_id == 1 ? '' : 'disabled' }}></textarea>
                                <div id="quill-editor">{!! $material->type_id == 1 ? html_entity_decode($material->content) : '' !!}</div>
                                @if($errors->has('content') && old('type') == 1)
                                <div class="small text-danger">{{ $errors->first('content') }}</div>
                                @endif
                            </div>
                        </div>
                        <!-- Content: Video (YouTube) -->
                        <div class="row mb-3 {{ $material->type_id == 3 || (old('type') == 3 && $errors->has('content')) ? '' : 'd-none' }}" data-id="3">
                            <label class="col-lg-2 col-md-3 col-form-label">URL YouTube <span class="text-danger">*</span></label>
                            <div class="col-lg-10 col-md-9">
                                <input type="text" name="content" class="form-control form-control-sm {{ $errors->has('content') ? 'border-danger' : '' }}" value="{{ $material->type->code === 'youtube-video' ? $material->content : '' }}" data-id="3" {{ $material->type_id == 3 ? '' : 'disabled' }}>
                                @if($errors->has('content') && old('type') == 3)
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

@endsection

@section('js')

@include('campusnet::layouts/js/quill')

<script type="text/javascript">
    // Quill Editor
    QuillEditor("#quill-editor");

    // Change Type
    $(document).on("change", "select[name=type]", function() {
        var type = $(this).val();
        $(".content-field .row").each(function(key,elem) {
            if($(elem).data("id") == type) {
                $("textarea[name=content][data-id="+$(elem).data("id")+"]").removeAttr("disabled");
                $("input[name=content][data-id="+$(elem).data("id")+"]").removeAttr("disabled");
                $(elem).removeClass("d-none");
            }
            else {
                $("textarea[name=content][data-id="+$(elem).data("id")+"]").attr("disabled","disabled");
                $("input[name=content][data-id="+$(elem).data("id")+"]").attr("disabled","disabled");
                $(elem).addClass("d-none");
            }
        });
    });

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e) {
        var editor = document.querySelector("#quill-editor");
        var html = editor.children[0].innerHTML;
        $("textarea[name=content]").text(html);
        $(this).parents("form").submit();
    });
</script>

@endsection

@section('css')

<link rel="stylesheet" type="text/css" href="https://campusdigital.id/assets/plugins/quill/quill.snow.css">
<style type="text/css">
    #quill-editor {height: 400px;}
</style>

@endsection