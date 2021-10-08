<div class="list-group">
    <a href="{{ route('admin.media.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.media.index'))) && !is_int(strpos(Request::url(), route('admin.media.create'))) ? 'active' : '' }}">Kelola Media</a>
    <!-- <a href="{{ route('admin.media.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.media.create'))) ? 'active' : '' }}">Tambah Media</a> -->
</div>