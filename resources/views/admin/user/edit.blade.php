@extends('campusnet::layouts/main')

@section('content')

<div class="row">
    <div class="col-lg-2 col-md-3">
        @include('campusnet::admin/user/_sidebar')
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
                <form method="post" action="{{ route('admin.user.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Nama <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="name" class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" value="{{ $user->name }}" autofocus>
                            @if($errors->has('name'))
                            <div class="small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group input-group-sm">
                                <input type="text" name="birthdate" class="form-control form-control-sm {{ $errors->has('birthdate') ? 'border-danger' : '' }}" value="{{ date('d/m/Y', strtotime($user->birthdate)) }}" autocomplete="off">
                                <span class="input-group-text {{ $errors->has('birthdate') ? 'border-danger' : '' }}"><i class="bi-calendar2"></i></span>
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
                                <input class="form-check-input" type="radio" name="gender" id="gender-M" value="M" {{ $user->gender == 'M' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender-M">
                                    Laki-Laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="gender-F" value="F" {{ $user->gender == 'F' ? 'checked' : '' }}>
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
                            <input type="text" name="phone_number" class="form-control form-control-sm {{ $errors->has('phone_number') ? 'border-danger' : '' }}" value="{{ $user->phone_number }}">
                            @if($errors->has('phone_number'))
                            <div class="small text-danger">{{ $errors->first('phone_number') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="email" name="email" class="form-control form-control-sm {{ $errors->has('email') ? 'border-danger' : '' }}" value="{{ $user->email }}">
                            @if($errors->has('email'))
                            <div class="small text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <input type="text" name="username" class="form-control form-control-sm {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ $user->username }}">
                            @if($errors->has('username'))
                            <div class="small text-danger">{{ $errors->first('username') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Kata Sandi</label>
                        <div class="col-lg-10 col-md-9">
                            <div class="input-group">
                                <input type="password" name="password" class="form-control form-control-sm {{ $errors->has('password') ? 'border-danger' : '' }}">
                                <button type="button" class="btn btn-sm {{ $errors->has('password') ? 'btn-outline-danger' : 'btn-outline-secondary' }} btn-toggle-password"><i class="bi-eye"></i></button>
                            </div>
                            <div class="small text-muted">Kosongi saja jika tidak ingin mengganti kata sandi.</div>
                            @if($errors->has('password'))
                            <div class="small text-danger">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Role <span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-5">
                            <select name="role" class="form-select form-select-sm {{ $errors->has('role') ? 'border-danger' : '' }}">
                                <option value="" disabled selected>--Pilih--</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                            <div class="small text-danger">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-2 col-md-3 col-form-label">Status <span class="text-danger">*</span></label>
                        <div class="col-lg-10 col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-1" value="1" {{ $user->status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-0" value="0" {{ $user->status == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-0">
                                    Tidak Aktif
                                </label>
                            </div>
                            @if($errors->has('status'))
                            <div class="small text-danger">{{ $errors->first('status') }}</div>
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
    Spandiv.DatePicker("input[name=birthdate]");
</script>

@endsection

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection