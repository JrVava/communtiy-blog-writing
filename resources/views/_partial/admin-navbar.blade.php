<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item @if (Route::currentRouteName() == 'dashboard') active @endif">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item @if (Route::currentRouteName() == 'users') active @endif">
                <a class="sidebar-link" href="{{ route('users') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Users</span>
                </a>
            </li>

            <li class="sidebar-item @if (Route::currentRouteName() == 'users-post') active @endif">
                <a class="sidebar-link" href="{{ route('users-post') }}">
                    <i class="align-middle" data-feather="users-post"></i>
                    <span class="align-middle">Posts</span>
                </a>
            </li>
        </ul>
</nav>
