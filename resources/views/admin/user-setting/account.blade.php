@extends('campusnet::layouts/admin/main')

@section('title', 'Pengaturan Akun')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Pengaturan Akun</h1>
</div>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="list-group">
            <a href="{{ route('admin.settings.profile') }}" class="list-group-item list-group-item-action py-2 px-3 {{ is_int(strpos(Request::url(), route('admin.settings.profile'))) ? 'active' : '' }}">Profil</a>
            <a href="{{ route('admin.settings.account') }}" class="list-group-item list-group-item-action py-2 px-3 {{ is_int(strpos(Request::url(), route('admin.settings.account'))) ? 'active' : '' }}">Akun</a>
            <a href="{{ route('admin.settings.password') }}" class="list-group-item list-group-item-action py-2 px-3 {{ is_int(strpos(Request::url(), route('admin.settings.password'))) ? 'active' : '' }}">Kata Sandi</a>
        </div>
    </div>
	<div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form method="post" action="{{ route('admin.settings.account.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="email" name="email" class="form-control form-control-sm {{ $errors->has('email') ? 'border-danger' : '' }}" value="{{ Auth::user()->email }}" autofocus>
                            @if($errors->has('email'))
                            <div class="small text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="username" class="form-control form-control-sm {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ Auth::user()->username }}">
                            @if($errors->has('username'))
                            <div class="small text-danger">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2 col-md-3"></div>
                        <div class="col-lg-10 col-md-9">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi-save me-1"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
	</div>
</div>

@endsection