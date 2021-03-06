@extends('faturhelper::layouts/admin/main')

@section('title', 'Edit Topik di '.$course->name.': '.$topic->name)

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit Topik</h1>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.topic.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $topic->id }}">
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ $topic->name }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-lg-2 col-md-3 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <textarea name="description" class="form-control form-control-sm {{ $errors->has('description') ? 'border-danger' : '' }}" rows="3">{{ $topic->description }}</textarea>
                            @if($errors->has('description'))
                            <div class="small text-danger">{{ $errors->first('description') }}</div>
                            @endif
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