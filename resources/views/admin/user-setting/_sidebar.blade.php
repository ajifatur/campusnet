<div class="list-group">
    <a href="{{ route('admin.settings.profile') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.settings.profile'))) ? 'active' : '' }}">Profil</a>
    <a href="{{ route('admin.settings.account') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.settings.account'))) ? 'active' : '' }}">Akun</a>
    <a href="{{ route('admin.settings.password') }}" class="list-group-item list-group-item-action {{ is_int(strpos(Request::url(), route('admin.settings.password'))) ? 'active' : '' }}">Kata Sandi</a>
</div>