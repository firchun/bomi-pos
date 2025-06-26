<div class="navbar-bg"
    style="{{ Auth::user()->role == 'admin' || Auth::user()->role == 'staff' ? 'background-color:#00008B !important;' : '' }}">
</div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"
                        style="cursor: pointer"></i></a></li>
        </ul>
    </form>
    @if (App::environment('local'))
        <ul class="navbar-nav navbar-right">
            <li class="dropdown dropdown-list-toggle">
                <a href="#" class="nav-link nav-link-lg" data-toggle="tooltip" data-placement="bottom"
                    title="{{ \App\Helpers\Network::isOnline() ? 'Online Network' : 'Local Network' }}">
                    @if (\App\Helpers\Network::isOnline())
                        <i class="fas fa-wifi"></i>
                    @else
                        <i class="fas fa-network-wired"></i>
                    @endif
                </a>
            </li>
        </ul>
    @endif
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
        @if (Auth::user()->role != 'admin' && Auth::user()->role != 'staff')
            <a href="#" class="nav-link nav-link-lg beep" data-toggle="modal" data-target="#helpModal">
                <i class="fas fa-question"></i>
                <div class="d-sm-none d-lg-inline-block">
                    {{ __('general.Help') }}
                </div>
            </a>
        @endif


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
                <a href="{{ route('settings.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-gears"></i>Setting
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
<!-- Modal help -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><i class="fa fa-circle-info"></i> {{ __('general.Help') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (app()->getLocale() == 'en')
                    <h4>How to Use the Application</h4>
                    <ol>
                        <li>Complete your store data (store name, address, location, opening hours, and photo).</li>
                        <li>Create products in the <strong>Products</strong> menu.</li>
                        <li>Add raw materials in the <strong>Raw Materials</strong> menu.</li>
                        <li>Assign raw materials to each product by clicking the <strong>“Raw Materials”</strong> button
                            on the product.</li>
                        <li>Download the <strong>BOMI POS</strong> on google playstore.</li>
                        <li>Log in to the cashier app using the same account.</li>
                        <li>Enjoy the <strong>Dashboard</strong> features, product management, and comprehensive
                            reports.</li>
                        <li>We’re happy you’re using our application.<br><strong>Warm regards from the BOMI POS
                                team!</strong></li>
                    </ol>
                @else
                    <h4>Langkah-Langkah Penggunaan Aplikasi</h4>
                    <ol>
                        <li>Lengkapi data toko Anda (nama toko, alamat, lokasi, jam buka, dan foto).</li>
                        <li>Buat produk pada menu <strong>Produk</strong>.</li>
                        <li>Tambahkan bahan baku pada menu <strong>Bahan Baku</strong>.</li>
                        <li>Masukkan bahan baku ke dalam produk dengan klik tombol <strong>“Bahan Baku”</strong> pada
                            masing-masing produk.</li>
                        <li>Unduh aplikasi <strong>BOMI POS</strong> pada google playstore</li>
                        <li>Login ke aplikasi kasir menggunakan akun yang sama.</li>
                        <li>Nikmati fitur <strong>Dashboard</strong>, manajemen produk, dan laporan yang lengkap.</li>
                        <li>Kami senang Anda menggunakan aplikasi kami.<br><strong>Salam hangat dari tim BOMI
                                POS!</strong></li>
                    </ol>
                @endif
                <div class="text-center">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-lg btn-primary"><i
                            class="fa fa-message"></i> Support on live chat</a>
                    <a href="https://wa.me/6282248493036?text=Halo%20tim%20BOMI%20POS%2C%20saya%20ingin%20bertanya%20tentang%20penggunaan%20aplikasi%20BOMI%20POS.%20Mohon%20bantuannya."
                        class="btn btn-lg btn-success" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i> Support on Whatsapp
                    </a>
                </div>
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
