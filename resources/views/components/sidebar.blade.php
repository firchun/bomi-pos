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
                <li class='nav-item {{ request()->is('home') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-gauge"></i><span
                            class="nav-text">Dashboard</span></a>
                </li>
                @if (Auth::user()->role != 'admin')
                    <li class='nav-item {{ request()->is('shop-profiles*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('shop-profiles.index') }}"><i
                                class="fas fa-folder-open"></i><span class="nav-text">Shop Profile</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-folder-open"></i><span
                                class="nav-text">Products</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('categories*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-sitemap"></i><span
                                class="nav-text">Categories</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('ratings*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('ratings.index') }}">
                            <i class="fas fa-comments"></i><span class="nav-text">Comment & Rating</span></a>
                    </li>
                @endif

                @if (Auth::user()->role == 'admin')
                    <li class='nav-item {{ request()->is('users*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-house-user"></i><span
                                class="nav-text">Users</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('admin_profiles') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin_profiles.index') }}"><i class="fas fa-house-user"></i>
                            <span class="nav-text">Admin Profile</span>
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
