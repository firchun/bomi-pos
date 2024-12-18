<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Bomi POS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">BP</a>
        </div>
        <ul class="sidebar-menu">
            <li class='nav-item {{ request()->is('home') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-gauge"></i>Dashboard</a>
            </li>
            @if (Auth::user()->role != 'admin')
                <li class='nav-item {{ request()->is('products*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('products.index') }}"><i
                            class="fas fa-folder-open"></i>Products</a>
                </li>
                <li class='nav-item {{ request()->is('categories*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('categories.index') }}"><i
                            class="fas fa-sitemap"></i>Categories</a>
                </li>
            @endif

            @if (Auth::user()->role == 'admin')
                <li class='nav-item {{ request()->is('users*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-house-user"></i>Users</a>
                </li>
            @endif
            <li class='nav-item {{ request()->is('profile*') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ route('profile') }}"><i class="fas fa-user"></i>Profile</a>
            </li>

</div>
