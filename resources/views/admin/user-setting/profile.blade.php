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
                <form method="post" action="{{ route('admin.settings.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ Auth::user()->name }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="birthdate" class="form-control form-control-sm {{ $errors->has('birthdate') ? 'border-danger' : '' }}" value="{{ generate_date_format(Auth::user()->birthdate, 'd/m/y') }}">
                                <span class="input-group-text"><i class="bi-calendar2"></i></span>
                            </div>
                            @if($errors->has('birthdate'))
                            <div class="small text-danger">{{ $errors->first('birthdate') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-M" value="M" {{ Auth::user()->gender == 'M' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender-M">
                                    Laki-Laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-F" value="F" {{ Auth::user()->gender == 'F' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender-F">
                                    Perempuan
                                </label>
                            </div>
                            @if($errors->has('gender'))
                            <div class="small text-danger">{{ $errors->first('gender') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="phone_number" class="form-control form-control-sm {{ $errors->has('phone_number') ? 'border-danger' : '' }}" value="{{ Auth::user()->phone_number }}">
                            @if($errors->has('phone_number'))
                            <div class="small text-danger">{{ $errors->first('phone_number') }}</div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    // Datepicker
    $("input[name=birthdate]").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
    });
</script>

@endsection

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection