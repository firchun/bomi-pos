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
                    {{-- <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div> --}}
                </div>
                <div id="notification-list" class="dropdown-list-content dropdown-list-icons dropdown-list-message"
                    tabindex="2" style="overflow: hidden; outline: currentcolor;">
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('notifications.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>


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
                <div class="d-sm-none d-lg-inline-block">{{ __('general.hi') }}, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Akun</div>
                <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                    @if (auth()->user()->role != 'admin')
                        @if (auth()->user()->is_subscribed && now()->lt(auth()->user()->subscription_expires_at))
                            <span class="badge badge-success p-1">Pro</span>
                        @else
                            <span class="badge badge-danger p-1">Free</span>
                        @endif
                    @endif
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
<!-- Modal Notifikasi -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">Notification Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="notification-message"></p>
                <small class="text-muted" id="notification-date"></small>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/id.js"></script>
    <script>
        dayjs.extend(dayjs_plugin_relativeTime);
        dayjs.locale('en');

        function loadNotifications() {
            $.ajax({
                url: '{{ route('data-notification') }}',
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
                            <a href="#" class="dropdown-item dropdown-item-unread" data-message="${notification.message.replace(/"/g, '&quot;')}" data-date="${notification.created_at}">
                                <div class="dropdown-item-icon bg-primary text-white">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <b>${notification.message || 'You have a new message.'}</b><br>
                                    <small>${dayjs(notification.created_at).fromNow()}</small>
                                </div>
                            </a>
                        `;
                            });
                        }
                        $('#notification-list').html(html);

                        // Pasang event click setelah notifikasi di-render
                        $('#notification-list .dropdown-item').on('click', function(e) {
                            e.preventDefault();
                            const message = $(this).data('message');
                            const date = dayjs($(this).data('date')).format('dddd, D MMMM YYYY HH:mm');

                            $('#notification-message').text(message);
                            $('#notification-date').text(date);
                            $('#notificationModal').modal('show');
                        });
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
