<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Bomi POS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">BP</a>
        </div>
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class='nav-item {{ request()->routeIs('home') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-gauge"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>                
                @if (Auth::user()->role != 'admin')
                    {{-- <li class='nav-item'>
                        <a class="nav-link" href="{{ route('user.pos') }}"><i
                                class="fas fa-folder-open"></i><span class="nav-text badge bg-danger rounded-pill ms-2 px-3 py-1 text-white">POS SOON</span></a>
                    </li> --}}

                    <li class="menu-header">Inventory</li>
                    <li class='nav-item {{ request()->is('products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-folder-open"></i><span
                                class="nav-text">Products</span></a>
                    </li>
                    {{-- <li class='nav-item {{ request()->is('categories*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-sitemap"></i><span
                                class="nav-text">Categories</span></a>
                    </li> --}}

                    <li class="menu-header">Chat</li>
                    <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-comments"></i><span class="nav-text">Messages</span>
                        </a>
                    </li>
                    <li class='nav-item {{ request()->is('ratings*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('ratings.index') }}">
                            <i class="fas fa-star"></i><span class="nav-text">Comment & Rating</span></a>
                    </li>

                    <li class="menu-header">User</li>
                    <li class='nav-item'>
                        <a class="nav-link" href="{{ route('daily.report') }}"><i
                                class="fas fa-chart-line"></i><span class="nav-text">Report</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('shop-profiles*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('shop-profiles.index') }}"><i
                                class="fas fa-store"></i><span class="nav-text">Shop Profile</span></a>
                    </li>
                @endif

                @if (Auth::user()->role == 'admin')
                    <li class='nav-item {{ request()->is('users*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-house-user"></i><span
                                class="nav-text">Users</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('admin_profiles') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin_profiles.index') }}"><i
                                class="fas fa-house-user"></i>
                            <span class="nav-text">Admin Profile</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-comments"></i>
                            <span class="nav-text">Messages</span>
                            <span id="sidebar-unread-count" class="badge badge-pill badge-danger"
                                style="display: none; position: absolute; top: 8px; right: 8px;">0</span>
                        </a>
                    </li>
                @endif
                <li class='nav-item {{ request()->is('profile*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('profile') }}"><i class="fas fa-user"></i><span
                            class="nav-text">Profile</span></a>
                </li>
            </ul>
        </div>
    </aside>
</div>
