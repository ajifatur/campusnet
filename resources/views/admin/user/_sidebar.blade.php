@if(has_access('UserController::index', Auth::user()->role_id, false))
<div class="list-group">
    <a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.user.index'))) && !is_int(strpos(Request::url(), route('admin.user.create'))) ? 'active' : '' }}">Kelola Pengguna</a>
    <a href="{{ route('admin.user.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.user.create'))) ? 'active' : '' }}">Tambah Pengguna</a>
</div>
@endif

@if(has_access('RoleController::index', Auth::user()->role_id, false))
<div class="list-group mt-3">
    <a href="{{ route('admin.role.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.role.index'))) && !is_int(strpos(Request::url(), route('admin.role.create'))) ? 'active' : '' }}">Kelola Role</a>
    <a href="{{ route('admin.role.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.role.create'))) ? 'active' : '' }}">Tambah Role</a>
</div>
@endif

@if(has_access('PermissionController::index', Auth::user()->role_id, false))
<div class="list-group mt-3">
    <a href="{{ route('admin.permission.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.permission.index'))) && !is_int(strpos(Request::url(), route('admin.permission.create'))) ? 'active' : '' }}">Kelola Hak Akses</a>
    <a href="{{ route('admin.permission.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.permission.create'))) ? 'active' : '' }}">Tambah Hak Akses</a>
</div>
@endif