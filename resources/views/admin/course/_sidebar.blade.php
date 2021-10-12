@if(has_access('CourseController::index', Auth::user()->role_id, false))
<div class="list-group">
    <a href="{{ route('admin.course.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.course.index'))) && !is_int(strpos(Request::url(), route('admin.course.create'))) ? 'active' : '' }}">Kelola Kelas</a>
    <a href="{{ route('admin.course.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.course.create'))) ? 'active' : '' }}">Tambah Kelas</a>
</div>
@endif

@if(has_access('CategoryController::index', Auth::user()->role_id, false))
<div class="list-group mt-3">
    <a href="{{ route('admin.category.index') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.category.index'))) && !is_int(strpos(Request::url(), route('admin.category.create'))) ? 'active' : '' }}">Kelola Kategori</a>
    <a href="{{ route('admin.category.create') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.category.create'))) ? 'active' : '' }}">Tambah Kategori</a>
</div>
@endif