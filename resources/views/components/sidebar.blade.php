<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('homepage') }}"><img src="{{ asset('favicon.png') }}" style="height: 30px;"> <span
                    class="text-primary " style="font-weight: 900 !important;">Bomi</span>
                POS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('homepage') }}"><img src="{{ asset('favicon.png') }}" style="height: 30px;"></a>
        </div>
        <div class="sidebar">
            {{-- @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                <div class="mt-4 mb-2 p-3 hide-sidebar-mini">
                    <button class="btn btn-primary btn-lg btn-block btn-icon-split" data-toggle="modal"
                        data-target="#upgradeModal">
                        <i class="fas fa-rocket"></i> Upgrade to Pro
                    </button>
                </div>
            @else
                <div class="mt-4 p-3 hide-sidebar-mini">
                    <button class="btn btn-outline-primary btn-lg btn-block btn-icon-split" data-toggle="modal"
                        data-target="#upgradeModal">
                        <i class="fas fa-rocket"></i> Pro Account
                    </button>
                </div>
            @endif --}}
            @if (Auth::user()->role == 'user')
                <div class=" mb-2 p-3 hide-sidebar-mini">
                    <a class="btn btn-warning btn-lg btn-block btn-icon-split" href="{{ route('user.pos') }}">
                        <i class="fas fa-cash-register"></i>
                        @if (app()->getLocale() == 'en')
                            Open Cashier
                        @else
                            Buka Kasir
                        @endif
                    </a>
                </div>
            @endif
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class='nav-item {{ request()->routeIs('home*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-gauge"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>
                {{-- menu kasir --}}
                @if (Auth::user()->role == 'user')
                    @if (!empty($setting) && $setting->ads)
                        <li class='nav-item {{ request()->routeIs('advertisement*') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('advertisement.index') }}">
                                <i class="fas fa-rectangle-ad"></i><span
                                    class="nav-text">{{ __('general.Advertisement') }}</span>
                            </a>
                        </li>
                    @endif
                    <li class='nav-item {{ request()->is('ratings*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('ratings.index') }}">
                            <i class="fas fa-star"></i><span
                                class="nav-text">{{ __('general.comment & rating') }}</span></a>
                    </li>
                    @if (!empty($setting) && $setting->tables)
                        <li class="menu-header">{{ __('general.Tables') }}</li>
                        <li class='nav-item {{ request()->is('tables*') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('tables.index') }}"><i class="fas fa-table"></i><span
                                    class="nav-text">{{ __('general.Tables') }}</span></a>
                        </li>
                    @endif
                    <li class="menu-header">{{ __('general.product') }}</li>
                    <li class='nav-item {{ request()->is('products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('products.index') }}"><i
                                class="fas fa-folder-open"></i><span
                                class="nav-text">{{ __('general.products') }}</span></a>
                    </li>
                    @if (!empty($setting) && $setting->ingredient)
                        <li class='nav-item {{ request()->is('ingredient') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('ingredient.index') }}"><i class="fas fa-box"></i><span
                                    class="nav-text">{{ __('general.ingredients') }}</span></a>
                        </li>
                    @endif
                    @if (empty($setting) || $setting->calendar)
                        <li class='nav-item {{ request()->is('calendar*') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('calendar') }}"><i class="fas fa-calendar"></i><span
                                    class="nav-text">Calendar</span></a>
                        </li>
                    @endif
                    {{-- <li class='nav-item {{ request()->is('categories*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-sitemap"></i><span
                                class="nav-text">Categories</span></a>
                    </li> --}}


                    <li class="menu-header">{{ __('general.report') }}</li>
                    <li class='nav-item {{ request()->is('daily-report*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('daily.report') }}"><i class="fas fa-chart-line"></i><span
                                class="nav-text">{{ __('general.orders report') }}</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('product-report*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('product.report') }}"><i class="fas fa-chart-line"></i><span
                                class="nav-text">{{ __('general.product report') }}</span></a>
                    </li>
                    @if (!empty($setting) && $setting->ingredient)
                        <li class='nav-item {{ request()->is('ingredient-report*') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('ingredient.report') }}"><i
                                    class="fas fa-chart-line"></i><span
                                    class="nav-text">{{ __('general.ingredient report') }}</span></a>
                        </li>
                    @endif
                    {{-- <li class="nav-item dropdown {{ Request::is('financial*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-money-bill-1-wave"></i><span>
                                {{ __('general.financial statement') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('financial/category') ? 'active' : '' }}">
                                <a href="{{ route('financial.category') }}" class="nav-link">
                                    {{ __('general.categories') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ Request::is('financial/income') ? 'active' : '' }}">
                                <a href="{{ route('financial.income') }}" class="nav-link">
                                    {{ __('general.income') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                            <li class="{{ Request::is('financial/expenses') ? 'active' : '' }}">
                                <a href="{{ route('financial.expenses') }}" class="nav-link">
                                    {{ __('general.expense') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                         
                        </ul>
                    </li> --}}

                    <li class="menu-header">Shop</li>
                    <li class='nav-item {{ request()->is('shop-profiles*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('shop-profiles.index') }}"><i class="fas fa-store"></i><span
                                class="nav-text">Shop Profile</span></a>
                    </li>


                    @if (!App::environment('local'))
                        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-comments"></i><span class="nav-text">Support Chat</span>
                            </a>
                        </li>
                        <li class="menu-header">Setting</li>
                        <li class='nav-item {{ request()->is('settings*') ? 'active' : '' }}'>
                            <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-gears"></i><span
                                    class="nav-text">Application</span></a>
                        </li>
                        @if (!empty($setting) && $setting->local_server)
                            <li class='nav-item {{ request()->is('local-server*') ? 'active' : '' }}'>
                                <a class="nav-link" href="{{ route('local-server.index') }}"><i
                                        class="fas fa-store"></i><span class="nav-text">Server Token</span></a>
                            </li>
                        @endif

                    @endif

                @endif
                {{-- menu admin --}}
                @if (Auth::user()->role == 'admin')
                    <li class="menu-header">Account</li>
                    <li class='nav-item {{ request()->is('users/admin') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.admin') }}"><i class="fas fa-house-user"></i><span
                                class="nav-text">Admin Bomi</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('users') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-house-user"></i><span
                                class="nav-text">Users</span></a>
                    </li>
                    <li class='nav-item {{ request()->is('admin/subscription*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('subscription.index') }}"><i
                                class="fas fa-house-user"></i>
                            <span class="nav-text">Subscription</span>
                        </a>
                    </li>
                    <li class="menu-header">Pages</li>
                    <li class='nav-item {{ request()->is('admin-blogs*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin-blogs.index') }}">
                            <i class="fas fa-newspaper"></i><span class="nav-text">Blogs</span>
                        </a>
                    </li>
                    <li class='nav-item {{ request()->is('admin-products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin-products.index') }}">
                            <i class="fas fa-box"></i><span class="nav-text">Bomi Products</span>
                        </a>
                    </li>
                    <li class='nav-item {{ request()->is('admin_profiles') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin_profiles.index') }}"><i
                                class="fas fa-house-user"></i>
                            <span class="nav-text">Page Settings</span>
                        </a>
                    </li>
                    <li class="menu-header">Support</li>
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-comments"></i>
                            <span class="nav-text">Live Chat</span>
                            <span id="sidebar-unread-count" class="badge badge-pill badge-danger"
                                style="display: none; position: absolute; top: 8px; right: 8px;">0</span>
                        </a>
                    </li>
                @endif
                <li class="menu-header">Akun</li>
                <li class='nav-item {{ request()->is('profile*') ? 'active' : '' }}'>
                    <a class="nav-link" href="{{ route('profile') }}"><i class="fas fa-user"></i><span
                            class="nav-text">Profile</span></a>
                </li>
            </ul>
        </div>
    </aside>
</div>
