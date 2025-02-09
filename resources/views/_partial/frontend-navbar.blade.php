<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <!-- Left Section: Logo -->
        <a class="navbar-brand fw-bold text-primary" href="#">
            <i class="bi bi-facebook fs-2"></i> <!-- Facebook Logo Icon -->
        </a>

        <!-- Search Bar -->
        <form class="d-flex ms-3 position-relative">
            <input class="form-control rounded-pill" type="search" id="searchUser" placeholder="Search Facebook"
                aria-label="Search">
            <ul id="userList" class="list-group position-absolute w-100" style="z-index: 1000; display: none;"></ul>
        </form>


        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center Section: Navigation Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-dark mx-2" href="#">
                        <i class="bi bi-house-door fs-4"></i>
                    </a>
                </li>

                <!-- People Icon with Badge and Dropdown List -->
                <li class="nav-item position-relative">
                    <a class="nav-link text-dark mx-2 people-toggle" href="javascript:void(0);">
                        <i class="bi bi-people fs-4"></i>
                        <span class="badge people-badge totalRequest"></span> <!-- Notification Badge -->
                    </a>
                    <ul class="people-list">
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark mx-2" href="#">
                        <i class="bi bi-bell fs-4"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark mx-2" href="{{ route('messages') }}">
                        <i class="bi bi-chat-dots fs-4"></i>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Right Section: User Profile & Dropdown -->
        <div class="d-flex align-items-center">
            @php
                $user = Auth::user();
                $initials = strtoupper(substr($user->full_name ?? 'U', 0, 1));
            @endphp

            @if ($user && $user->image)
                <img src="{{ asset('uploads/profile/' . $user->image) }}" class="rounded-circle me-2" width="40"
                    height="40" alt="User">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white me-2"
                    style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                    {{ $initials }}
                </div>
            @endif

            <div class="dropdown">
                <button class="btn btn-light border-0 dropdown-toggle" type="button" id="profileDropdown"
                    data-bs-toggle="dropdown">
                    {{ $user->full_name ?? 'User' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item"
                            href="{{ route('profile', ['user_id' => Auth::user()->id]) }}">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
