@extends('campusnet::layouts/admin/main')

@section('title', 'Kelola Hak Akses')

@section('content')

<div class="d-sm-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-2 mb-sm-0">Kelola Hak Akses</h1>
    <a href="{{ route('admin.permission.create') }}" class="btn btn-sm btn-primary"><i class="bi-plus me-1"></i> Tambah Hak Akses</a>
</div>
<div class="row">
	<div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(Session::get('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="alert-message">{{ Session::get('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <p class="fst-italic small text-muted"><i class="bi-info-circle me-1"></i> Tekan dan geser hak akses di bawah ini untuk mengurutkannya.</p>
                <div class="table-responsive">
                    <table class="table table-sm table-sm table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Akses</th>
                                @foreach($roles as $role)
                                <th width="70" class="small">
                                    {{ $role->name }}
                                    <br>
                                    <span class="fw-normal fst-italic text-muted">({{ $role->code }})</span>
                                </th>
                                @endforeach
                                <th width="60">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="sortable-permission">
                            @foreach($permissions as $permission)
                            <tr data-id="{{ $permission->id }}">
                                <td>
                                    {{ $permission->name }}
                                    <br>
                                    <span class="small text-muted">{{ $permission->code }}</span>
                                </td>
                                @foreach($roles as $role)
                                <td width="70" align="center">
                                    <input class="form-check-input" type="checkbox" data-role="{{ $role->id }}" data-permission="{{ $permission->id }}" {{ in_array($role->id, $permission->roles()->pluck('role_id')->toArray()) ? 'checked' : '' }}>
                                </td>
                                @endforeach
                                <td width="60">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.permission.edit', ['id' => $permission->id]) }}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit"><i class="bi-pencil"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $permission->id }}" data-bs-toggle="tooltip" title="Hapus"><i class="bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>

<form class="form-delete d-none" method="post" action="{{ route('admin.permission.delete') }}">
    @csrf
    <input type="hidden" name="id">
</form>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 d-none">
    <div class="toast align-items-center text-white bg-success border-0" id="toast-sort" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    // Button Delete
    Spandiv.ButtonDelete(".btn-delete", ".form-delete");

    // Sortable Permission
    Spandiv.Sortable(".sortable-permission", function(event, ui) {
        var items = $(this).find(".ui-sortable-handle");
        var ids = [];
        $(items).each(function(key,elem) {
            ids.push($(elem).data("id"));
        });
        $.ajax({
            type: "post",
            url: "{{ route('admin.permission.sort') }}",
            data: {_token: "{{ csrf_token() }}", ids: ids},
            success: function(response) {
                Spandiv.Toast("#toast-sort", response);
            }
        });
    });
    
    // Change Status
    $(document).on("change", ".form-check-input", function(e){
        e.preventDefault();
        var permission = $(this).data("permission");
        var role = $(this).data("role");
        $.ajax({
            type: "post",
            url: "{{ route('admin.permission.change') }}",
            data: {_token: "{{ csrf_token() }}", permission: permission, role: role},
            success: function(response){
                Spandiv.Toast("#toast-sort", response);
            }
        });
    });
</script>

@endsection

@section('css')

<style type="text/css">
    .table-sm > :not(caption) > * > * {padding: .25rem .5rem;}
    .table tr th {text-align: center;}
    .table tr th, .table tr td {vertical-align: middle;}
</style>

@endsection