@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/user-setting/_sidebar')
    </div>
    <div class="col-lg-10 col-md-9">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
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