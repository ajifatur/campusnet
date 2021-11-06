
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{ route('home') }}" target="_blank">
                    <span class="align-middle">CampusNet</span>
                </a>
				<ul class="sidebar-nav">
					<li class="sidebar-item {{ Request::url() == route('admin.dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
					</li>
					
                	@if(has_access('CourseController::index', Auth::user()->role_id, false) || has_access('CategoryController::index', Auth::user()->role_id, false) || has_access('MediaController::index', Auth::user()->role_id, false) || has_access('UserController::index', Auth::user()->role_id, false))
						<li class="sidebar-header">Data</li>
						@if(has_access('CourseController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.course.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.course.index') }}">
								<i class="align-middle" data-feather="tv"></i> <span class="align-middle">Kelas</span>
							</a>
						</li>
						@endif
						@if(has_access('CategoryController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.category.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.category.index') }}">
								<i class="align-middle" data-feather="tag"></i> <span class="align-middle">Kategori</span>
							</a>
						</li>
						@endif
						@if(has_access('MediaController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.media.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.media.index') }}">
								<i class="align-middle" data-feather="book"></i> <span class="align-middle">Media</span>
							</a>
						</li>
						@endif
						@if(has_access('UserController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.user.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.user.index') }}">
								<i class="align-middle" data-feather="user"></i> <span class="align-middle">Pengguna</span>
							</a>
						</li>
						@endif
					@endif

                	@if(has_access('RoleController::index', Auth::user()->role_id, false))
						<li class="sidebar-header">Master</li>
						@if(has_access('RoleController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.role.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.role.index') }}">
								<i class="align-middle" data-feather="shuffle"></i> <span class="align-middle">Role</span>
							</a>
						</li>
						@endif
					@endif

                	@if(has_access('PermissionController::index', Auth::user()->role_id, false))
						<li class="sidebar-header">Pengaturan</li>
						@if(has_access('PermissionController::index', Auth::user()->role_id, false))
						<li class="sidebar-item {{ is_int(strpos(Request::url(), route('admin.permission.index'))) ? 'active' : '' }}">
							<a class="sidebar-link" href="{{ route('admin.permission.index') }}">
								<i class="align-middle" data-feather="shield"></i> <span class="align-middle">Hak Akses</span>
							</a>
						</li>
						@endif
					@endif
				</ul>
			</div>
		</nav>
