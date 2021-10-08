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
                <div class="alert {{ Session::get('status') == 1 ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form method="post" action="{{ route('admin.settings.password.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kata Sandi Lama <span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-5">
                            <div class="input-group">
                                <input type="password" name="old_password" class="form-control form-control-sm {{ $errors->has('old_password') ? 'border-danger' : '' }}">
                                <button type="button" class="btn btn-sm {{ $errors->has('old_password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                            @if($errors->has('old_password'))
                            <div class="small text-danger">{{ $errors->first('old_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-5">
                            <div class="input-group">
                                <input type="password" name="new_password" class="form-control form-control-sm {{ $errors->has('new_password') ? 'border-danger' : '' }}">
                                <button type="button" class="btn btn-sm {{ $errors->has('new_password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                            @if($errors->has('new_password'))
                            <div class="small text-danger">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-5">
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control form-control-sm {{ $errors->has('confirm_password') ? 'border-danger' : '' }}">
                                <button type="button" class="btn btn-sm {{ $errors->has('confirm_password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                            @if($errors->has('confirm_password'))
                            <div class="small text-danger">{{ $errors->first('confirm_password') }}</div>
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

@section('js')

<script type="text/javascript">
    // Button Toggle Password
    $(document).on("click", ".btn-toggle-password", function(e) {
        e.preventDefault();
        var type = $(this).parents(".input-group").find("input").attr("type");
        var icon = $(this).parents(".input-group").find("i").attr("class");
        type === "password" ? $(this).parents(".input-group").find("input").attr("type","text") : $(this).parents(".input-group").find("input").attr("type","password");
        icon === "bi-eye" ? $(this).parents(".input-group").find("i").attr("class","bi-eye-slash") : $(this).parents(".input-group").find("i").attr("class","bi-eye");
    });
</script>

@endsection