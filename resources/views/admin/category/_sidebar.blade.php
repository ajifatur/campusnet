<div class="list-group">
    <a href="{{ route('admin.category.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.category.index'))) && !is_int(strpos(Request::url(), route('admin.category.create'))) ? 'active' : '' }}">Kelola Kategori</a>
    <a href="{{ route('admin.category.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.category.create'))) ? 'active' : '' }}">Tambah Kategori</a>
</div>