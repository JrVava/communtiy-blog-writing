<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container position-relative">
            <!-- Left Section: Logo -->
            <a class="navbar-brand fw-bold text-primary" href="{{ route('posts') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo">
            </a>
            <div class="d-flex align-items-center  order-md-4">
                @php
                    $user = Auth::user();
                @endphp

                

                <div class="dropdown">
                    <button class="user-avatar-btn btn btn-light border-0 dropdown-toggle d-flex gap-2 p-0 align-items-center bg-transparent" type="button" id="profileDropdown"
                        data-bs-toggle="dropdown">
                        @if ($user && $user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle" width="40"
                        height="40" alt="{{ $user->full_name }}">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white"
                        style="width: 40px; height: 40px; font-size: 1rem; font-weight: bold;">
                        {{ $user->initials }}
                    </div>
                @endif
                <span class="d-lg-block d-none">
                        {{ $user->full_name ?? 'User' }}
                    </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="{{ route('profile', ['user_id' => Auth::user()->id]) }}">Profile</a>
                        </li>
                        {{-- <li><a class="dropdown-item" href="#">Settings</a></li> --}}
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            </div>
            <!-- Search Bar -->
            <form class="d-flex ms-3 position-relative">
                <input class="form-control rounded-pill" type="search" id="searchUser" placeholder="Search User"
                    aria-label="Search">
                <ul id="userList" class="list-group position-absolute w-100" style="z-index: 1000; display: none;">
                </ul>
            </form>

            <!-- Center Section: Navigation Links -->
            <div class="navigation-wrapper collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-dark mx-2" href="{{ route('posts') }}">
                            <i class="bi bi-house-door fs-4"></i>
                            <span class="d-lg-none ms-2">User</span>
                        </a>
                    </li>

                    <!-- People Icon with Badge and Dropdown List -->
                    <li class="nav-item position-relative">
                        <a class="nav-link text-dark mx-2 people-toggle" href="javascript:void(0);">
                            <i class="bi bi-people fs-4"></i>
                            <span class="badge people-badge totalRequest"></span> <!-- Notification Badge -->
                            <span class="d-lg-none ms-2">Follow Request</span>
                        </a>
                        <ul class="people-list">
                        </ul>
                    </li>

                    <li class="nav-item position-relative">
                        <a class="nav-link text-dark mx-2 notification-toggle" href="javascript:void(0);">
                            <i class="bi bi-bell fs-4"></i>
                            <span class="badge people-badge totalNotification"></span>
                            <span class="d-lg-none ms-2">Notification</span>
                        </a>
                        <ul class="notification-lists"></ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark mx-2" href="{{ route('messages') }}">
                            <i class="bi bi-chat-dots fs-4"></i>
                            <span class="d-lg-none ms-2">Message</span>
                        </a>
                    </li>
                </ul>
            </div>

                <!-- Navbar Toggler for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

            <!-- Right Section: User Profile & Dropdown -->
           
        </div>
    </nav>
</header>
