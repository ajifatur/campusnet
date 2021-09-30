<div class="list-group">
    <a href="{{ route('admin.course.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.course.index'))) && !is_int(strpos(Request::url(), route('admin.course.create'))) ? 'active' : '' }}">Kelola Kelas</a>
    <a href="{{ route('admin.course.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.course.create'))) ? 'active' : '' }}">Tambah Kelas</a>
</div>