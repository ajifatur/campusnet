@extends('faturhelper::layouts/admin/main')

@section('title', 'Profil')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Profil</h1>
</div>
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->avatar != '' ? asset('assets/images/avatar/'.Auth::user()->avatar) : asset('assets/images/default/user.jpg') }}" class="rounded-circle" height="150" width="150" alt="Foto">
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Profil Pengguna</h5></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Nama:</div>
                        <div>{{ $user->name }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Tanggal Lahir:</div>
                        <div>{{ date('d/m/Y', strtotime($user->attribute->birthdate)) }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Jenis Kelamin:</div>
                        <div>{{ gender($user->attribute->gender) }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Email:</div>
                        <div>{{ $user->email }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Username:</div>
                        <div>{{ $user->username }}</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Kunjungan Terakhir:</div>
                        <div>{{ date('d/m/Y, H:i', strtotime($user->last_visit)) }} WIB</div>
                    </li>
                    <li class="list-group-item px-0 py-1 d-sm-flex justify-content-between">
                        <div>Registrasi:</div>
                        <div>{{ date('d/m/Y, H:i', strtotime($user->created_at)) }} WIB</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection