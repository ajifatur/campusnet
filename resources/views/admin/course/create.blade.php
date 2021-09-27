@extends('campusnet::layouts/main')

@section('content')

<div class="card">
    <div class="card-header h5">Tambah Kelas</div>
    <div class="card-body">
        <form method="post" action="{{ route('admin.course.store') }}" enctype="multipart/form-data">
            @csrf
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
                <label class="col-lg-2 col-md-3 col-form-label">Kategori <span class="text-danger">*</span></label>
                <div class="col-lg-4 col-md-5">
                    <select name="category" class="form-select form-select-sm {{ $errors->has('category') ? 'border-danger' : '' }}">
                        <option value="" disabled selected>--Pilih--</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                    <div class="small text-danger">{{ $errors->first('category') }}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <label class="col-lg-2 col-md-3 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                <div class="col-lg-10 col-md-9">
                    <textarea name="description" class="form-control form-control-sm {{ $errors->has('description') ? 'border-danger' : '' }}" rows="3">{{ old('description') }}</textarea>
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
                    <a href="#" class="btn btn-sm btn-secondary"><i class="bi-arrow-left me-1"></i> Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection