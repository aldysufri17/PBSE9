<div class="display-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-bars"></i></a></li>
    </ul>
</div>
<ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('backend/assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->name}}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="#" class="dropdown-item has-icon">
                <i class="fa fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <form id="logout" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <a href="#" onclick="logout()" class="dropdown-item has-icon text-danger">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </form>
        </div>
    </li>
</ul>

@push('scripts')
    <script>
        function logout() {
            document.getElementById("logout").submit();
        }
    </script>
@endpush
