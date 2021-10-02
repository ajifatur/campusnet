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
                        @elseif($material->type->code == 'youtube-video')
                            <!-- Content: Video (YouTube) -->
                            <div class="row mb-3">
                                <label class="col-lg-2 col-md-3 col-form-label">URL YouTube <span class="text-danger">*</span></label>
                                <div class="col-lg-10 col-md-9">
                                    <input type="text" name="content" class="form-control form-control-sm {{ $errors->has('content') ? 'border-danger' : '' }}" value="{{ $material->content }}">
                                    @if($errors->has('content'))
                                    <div class="small text-danger">{{ $errors->first('content') }}</div>
                                    @endif
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

@endsection

@section('js')

@include('campusnet::layouts/js/quill')

<script type="text/javascript">
    // Quill Editor
    QuillEditor("#quill-editor");

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e) {
        e.preventDefault();
        var type = $("input[name=type_code]").val();
        if(type === "text") {
            var editor = document.querySelector("#quill-editor");
            var html = editor.children[0].innerHTML;
            $("textarea[name=content]").text(html);
        }
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