<div class="list-group">
    <a href="{{ route('admin.user.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.user.index'))) && !is_int(strpos(Request::url(), route('admin.user.create'))) ? 'active' : '' }}">Kelola Pengguna</a>
    <a href="{{ route('admin.user.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.user.create'))) ? 'active' : '' }}">Tambah Pengguna</a>
</div>