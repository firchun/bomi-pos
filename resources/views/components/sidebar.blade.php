<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('homepage') }}">Bomi POS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('homepage') }}">BP</a>
        </div>
        <div class="sidebar">
            @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                <div class="mt-4 mb-2 p-3 hide-sidebar-mini">
                    <button class="btn btn-primary btn-lg btn-block btn-icon-split" data-toggle="modal"
                        data-target="#upgradeModal">
                        <i class="fas fa-rocket"></i> Upgrade to Pro
                    </button>
                </div>
            @else
                <div class="mt-4 mb-2 p-3 hide-sidebar-mini">
                    <button class="btn btn-outline-primary btn-lg btn-block btn-icon-split" data-toggle="modal"
                        data-target="#upgradeModal">
                        <i class="fas fa-rocket"></i> Pro Account
                    </button>
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
                    {{-- <li class='nav-item'>
                        <a class="nav-link" href="{{ route('user.pos') }}"><i
                                class="fas fa-folder-open"></i><span class="nav-text badge bg-danger rounded-pill ms-2 px-3 py-1 text-white">POS SOON</span></a>
                    </li> --}}

                    <li class="menu-header">Inventory</li>
                    <li class='nav-item {{ request()->is('products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-folder-open"></i><span
                                class="nav-text">{{ __('general.products') }}</span></a>
                    </li>
                    {{-- <li class='nav-item {{ request()->is('categories*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('categories.index') }}"><i class="fas fa-sitemap"></i><span
                                class="nav-text">Categories</span></a>
                    </li> --}}

                    <li class="menu-header">Rating</li>
                    <li class='nav-item {{ request()->is('ratings*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('ratings.index') }}">
                            <i class="fas fa-star"></i><span
                                class="nav-text">{{ __('general.comment & rating') }}</span></a>
                    </li>
                    <li class="menu-header">{{ __('general.report') }}</li>
                    <li class="nav-item dropdown {{ Request::is('financial*') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown">
                            <i class="fas fa-money-bill-1-wave"></i><span>
                                {{ __('general.financial statement') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            {{-- categories --}}
                            <li class="{{ Request::is('financial/category') ? 'active' : '' }}">
                                <a href="{{ route('financial.category') }}" class="nav-link">
                                    {{ __('general.categories') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                            {{-- Menu Income --}}
                            <li class="{{ Request::is('financial/income') ? 'active' : '' }}">
                                <a href="{{ route('financial.income') }}" class="nav-link">
                                    {{ __('general.income') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                            {{-- pengeluaran --}}
                            <li class="{{ Request::is('financial/expenses') ? 'active' : '' }}">
                                <a href="{{ route('financial.expenses') }}" class="nav-link">
                                    {{ __('general.expense') }}
                                    @if (!auth()->user()->is_subscribed || now()->gt(auth()->user()->subscription_expires_at))
                                        <span class="badge badge-danger m-2 p-1">Pro</span>
                                    @endif
                                </a>
                            </li>
                            {{-- laba rugi  --}}
                            {{-- <li><a href="">Profit & Loss</a></li> --}}
                            {{-- kas harian --}}
                            {{-- <li><a href="">Daily Cash</a></li> --}}
                            {{-- neraca saldo --}}
                            {{-- <li><a href="">Trial Balance</a></li> --}}
                            {{-- piutang --}}
                            {{-- <li><a href="">Receivables</a></li> --}}
                            {{-- pencatatan modal dan prive --}}
                            {{-- <li><a href="">Capital & Withdrawal</a></li> --}}
                            {{-- jurnal --}}
                            {{-- <li><a href="">Journal</a></li> --}}
                            {{-- perpajakan --}}
                            {{-- <li><a href="">Taxation</a></li> --}}
                        </ul>
                    </li>
                    <li class='nav-item {{ request()->is('daily-report*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('daily.report') }}"><i class="fas fa-chart-line"></i><span
                                class="nav-text">{{ __('general.daily order') }}</span></a>
                    </li>
                    <li class="menu-header">Shop Setting</li>
                    <li class='nav-item {{ request()->is('shop-profiles*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('shop-profiles.index') }}"><i class="fas fa-store"></i><span
                                class="nav-text">Shop Profile</span></a>
                    </li>
                    <li class="menu-header">Support</li>
                    <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-comments"></i><span class="nav-text">{{ __('general.messages') }}</span>
                        </a>
                    </li>
                @endif
                {{-- menu admin --}}
                @if (Auth::user()->role == 'admin')
                    <li class="menu-header">Account</li>
                    <li class='nav-item {{ request()->is('users*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-house-user"></i><span
                                class="nav-text">Users</span></a>
                    </li>
                    <li class="menu-header">Inventory</li>
                    <li class='nav-item {{ request()->is('admin-products*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin-products.index') }}">
                            <i class="fas fa-box"></i><span class="nav-text">Admin Products</span>
                        </a>
                    </li>
                    <li class="menu-header">Chat</li>
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-comments"></i>
                            <span class="nav-text">Messages</span>
                            <span id="sidebar-unread-count" class="badge badge-pill badge-danger"
                                style="display: none; position: absolute; top: 8px; right: 8px;">0</span>
                        </a>
                    </li>
                    <li class="menu-header">Admin</li>
                    <li class='nav-item {{ request()->is('admin_profiles') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('admin_profiles.index') }}"><i
                                class="fas fa-house-user"></i>
                            <span class="nav-text">Admin Profile</span>
                        </a>
                    </li>
                    <li class="menu-header">Subscription</li>
                    <li class='nav-item {{ request()->is('subscription*') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('subscription.index') }}"><i
                                class="fas fa-house-user"></i>
                            <span class="nav-text">Update Subscription</span>
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
