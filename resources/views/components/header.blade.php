<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"
                        style="cursor: pointer"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">


        <li class="dropdown dropdown-list-toggle ">
            <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"
                aria-expanded="false"><i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right ">
                <div class="dropdown-header">Notification
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div id="notification-list" class="dropdown-list-content dropdown-list-message" tabindex="2"
                    style="overflow: hidden; outline: currentcolor;">
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
        </li> --}}

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
                <i class="fas fa-globe"></i>
                <div class="d-sm-none d-lg-inline-block">
                    {{ app()->getLocale() === 'en' ? 'English' : 'Bahasa Indonesia' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('general.choose language') }}</div>

                <form action="{{ route('change.language') }}" method="POST">
                    @csrf
                    <input type="hidden" name="language" value="en">
                    <button type="submit" class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                        English
                    </button>
                </form>
                <form action="{{ route('change.language') }}" method="POST">
                    @csrf
                    <input type="hidden" name="language" value="id">
                    <button type="submit" class="dropdown-item {{ app()->getLocale() === 'id' ? 'active' : '' }}">
                        Bahasa Indonesia
                    </button>
                </form>
            </div>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Akun</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
@push('scripts')
    <script>
        function loadNotifications() {
            $.ajax({
                url: '{{ route('data-notification') }}', // sesuaikan dengan route di web.php
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        let html = '';
                        if (response.data.length === 0) {
                            html =
                                '<div class="dropdown-item text-center text-muted">No new notifications</div>';
                        } else {
                            response.data.forEach(function(notification) {
                                html += `
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-desc">
                                        <b class="text-${notification.type}">${notification.message || 'You have a new message.'}</b><br>
                                        <small >${new Date(notification.created_at).toLocaleString('id-ID')}</small>
                                    </div>
                                </a>
                            `;
                            });
                        }
                        $('#notification-list').html(html);
                    }
                },
                error: function(xhr) {
                    console.error('Gagal mengambil notifikasi:', xhr);
                }
            });
        }

        // Jalankan ketika dropdown dibuka
        $('.message-toggle').on('click', function() {
            loadNotifications();
        });
    </script>
@endpush
