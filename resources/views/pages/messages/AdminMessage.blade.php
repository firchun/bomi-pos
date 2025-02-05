@extends('layouts.app')

@section('title', 'Messages')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .user-chat.active {
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 8px;
        }

        /* Chat bubbles for user */
        .text-right p {
            background-color: #007bff;
            /* Blue background for user messages */
            color: white;
            /* White text for user messages */
            padding: 10px;
            border-radius: 15px;
            max-width: 70%;
            /* Max width of 70% */
            margin-left: auto;
            margin-right: 0;
            word-wrap: break-word;
            display: inline-block;
            /* Allows the bubble to resize based on content */
            font-size: 14px;
            /* Adjust font size if necessary */
        }

        /* Chat bubbles for admin */
        .text-left p {
            background-color: #f1f1f1;
            /* Light gray background for admin messages */
            color: #333;
            /* Dark text for admin messages */
            padding: 10px;
            border-radius: 15px;
            max-width: 70%;
            /* Max width of 70% */
            margin-left: 0;
            margin-right: auto;
            word-wrap: break-word;
            display: inline-block;
            /* Allows the bubble to resize based on content */
            font-size: 14px;
            /* Adjust font size if necessary */
        }

        /* CSS for loading message */
        .loading-message p {
            background-color: #ccc;
            /* Gray background */
            color: white;
            /* White text */
            padding: 10px;
            border-radius: 15px;
            max-width: 70%;
            margin-left: auto;
            margin-right: 0;
            word-wrap: break-word;
            display: inline-block;
            font-size: 14px;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.5em;
        }

        .badge-pill {
            border-radius: 10rem;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Messages</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Messages</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <!-- Sidebar: Daftar User -->
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Chat</h4>
                            </div>
                            <div class="card-body">
                                <ul id="user-list" class="list-unstyled list-unstyled-border">
                                    @foreach ($users as $user)
                                        @php
                                            $unreadCount = $user->unreadMessagesCount ?? 0; // Ambil jumlah pesan yang belum dibaca
                                            $shopProfile = $shopProfiles->where('user_id', $user->id)->first();
                                            $photo =
                                                $shopProfile && $shopProfile->photo
                                                    ? asset('storage/' . $shopProfile->photo)
                                                    : asset('default-avatar.png');
                                        @endphp
                                        <li class="media user-chat" data-user-id="{{ $user->id }}">
                                            <img class="mr-3 rounded-circle" src="{{ $photo }}" alt="avatar"
                                                style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
                                            <div class="media-body" style="cursor: pointer;">
                                                <div class="media-title">{{ $user->name }}</div>
                                                <span class="text-small text-muted">
                                                    {{ $user->messages->last()->message ?? 'No messages yet' }}
                                                </span>
                                                <span class="badge badge-pill badge-danger unread-count"
                                                    style="display: none;">0</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Box -->
                    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Chat</h4>
                            </div>
                            <div class="card-body" id="chat-box">
                                <div id="chat-messages"
                                    style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                    <p>Select a user to start chatting.</p>
                                </div>
                                <form id="chat-form">
                                    @csrf
                                    <input type="hidden" id="current-user-id">
                                    <div class="input-group mt-3">
                                        <textarea class="form-control" id="message-input" placeholder="Type your message"></textarea>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const csrfToken = '{{ csrf_token() }}'; // CSRF token untuk mencegah serangan CSRF
            let currentUserId = null; // ID pengguna yang sedang dipilih
            let refreshInterval = null; // Interval untuk memuat pesan baru secara berkala
            let isScrolledToBottom = true; // Menandai apakah admin berada di bawah kotak pesan

            // Fungsi untuk memperbarui jumlah pesan belum dibaca
            const updateUnreadCounts = () => {
                $.ajax({
                    url: '{{ route('admin.getUnreadCounts') }}', // Endpoint untuk mendapatkan jumlah pesan belum dibaca
                    method: 'GET',
                    success: (response) => {
                        // Perbarui sidebar
                        const totalUnread = response.totalUnread;
                        const sidebarBadge = $('#sidebar-unread-count');
                        if (totalUnread > 0) {
                            sidebarBadge.text(totalUnread).show();
                        } else {
                            sidebarBadge.hide();
                        }

                        // Perbarui user list
                        response.userUnreadCounts.forEach((user) => {
                            const userBadge = $(
                                `.user-chat[data-user-id="${user.id}"] .unread-count`);
                            if (user.unreadCount > 0) {
                                userBadge.text(user.unreadCount).show();
                            } else {
                                userBadge.hide();
                            }
                        });
                    },
                    error: (xhr) => {
                        console.error('Error fetching unread counts:', xhr.responseText);
                    },
                });
            };

            // Fungsi untuk memuat pesan terbaru antara admin dan pengguna
            const loadMessages = (userId) => {
                if (!userId) return; // Jika tidak ada pengguna yang dipilih, hentikan eksekusi

                $.ajax({
                    url: '{{ route('admin.getMessages') }}', // Endpoint untuk mengambil pesan
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        user_id: userId, // Kirim ID pengguna yang dipilih
                    },
                    success: (response) => {
                        const messages = response.messages; // Dapatkan daftar pesan dari respons
                        const chatBox = $('#chat-messages');
                        chatBox.empty(); // Kosongkan kotak pesan sebelum menampilkan pesan baru

                        // Tampilkan pesan di kotak pesan
                        messages.forEach((message) => {
                            const alignment = message.is_admin ? 'text-right' :
                                'text-left'; // Tampilkan pesan berdasarkan pengirim
                            chatBox.append(
                                `<div class="${alignment}"><p>${message.message}</p></div>`
                            );
                        });

                        // Jika admin berada di bawah kotak pesan, scroll otomatis ke bawah
                        if (isScrolledToBottom) {
                            chatBox.scrollTop(chatBox[0].scrollHeight);
                        }

                        // Perbarui jumlah pesan belum dibaca setelah memuat pesan
                        updateUnreadCounts();
                    },
                    error: (xhr) => {
                        console.error('Error loading messages:', xhr.responseText);
                    },
                });
            };

            // Fungsi untuk mengirim pesan ke pengguna
            const sendMessage = () => {
                const message = $('#message-input').val().trim();

                if (!message || !currentUserId)
                    return; // Pastikan pesan tidak kosong dan ada pengguna yang dipilih

                // Bersihkan input dan tambahkan bubble "Sending..."
                $('#message-input').val('');
                const chatBox = $('#chat-messages');
                const tempBubbleId = `temp-bubble-${Date.now()}`; // ID unik untuk bubble sementara
                chatBox.append(
                    `<div id="${tempBubbleId}" class="loading-message text-right text-muted"><p>Sending...</p></div>`
                );
                chatBox.scrollTop(chatBox[0].scrollHeight); // Scroll otomatis ke bawah

                $.ajax({
                    url: '{{ route('admin.sendMessage') }}', // Endpoint untuk mengirim pesan
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        user_id: currentUserId, // Kirim ID pengguna yang dipilih
                        message: message, // Isi pesan
                    },
                    success: (response) => {
                        // Ganti bubble "Sending..." dengan pesan sebenarnya
                        $(`#${tempBubbleId}`).replaceWith(
                            `<div class="text-right"><p>${response.message.message}</p></div>`
                        );
                        chatBox.scrollTop(chatBox[0].scrollHeight); // Scroll otomatis ke bawah
                        updateUnreadCounts(); // Perbarui jumlah pesan belum dibaca
                    },
                    error: (xhr) => {
                        // Hapus bubble "Sending..." dan tampilkan error
                        $(`#${tempBubbleId}`).remove();
                        console.error('Error sending message:', xhr.responseText);
                        alert('Failed to send message. Please try again.');
                    },
                });
            };

            // Event listener ketika admin memilih pengguna
            $('#user-list').on('click', '.user-chat', function() {
                const userId = $(this).data('user-id');
                if (currentUserId === userId) return; // Cegah memuat ulang untuk pengguna yang sama

                currentUserId = userId; // Simpan ID pengguna yang dipilih

                // Hapus highlight dari semua pengguna, tambahkan highlight ke pengguna yang dipilih
                $('.user-chat').removeClass('active');
                $(this).addClass('active');
                $(this).find('.unread-count').hide(); // Hapus notifikasi untuk pengguna yang dipilih

                // Hentikan interval sebelumnya dan muat pesan untuk pengguna yang dipilih
                clearInterval(refreshInterval);
                loadMessages(userId);

                // Set interval untuk memuat pesan baru setiap 3 detik
                refreshInterval = setInterval(() => loadMessages(userId), 3000);
            });

            // Event listener untuk mengirim pesan saat form dikirim
            $('#chat-form').on('submit', function(e) {
                e.preventDefault(); // Cegah submit form secara default
                sendMessage(); // Kirim pesan
            });

            // Event listener untuk menangkap tombol Enter pada input pesan
            $('#message-input').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Cegah perilaku default tombol Enter
                    sendMessage(); // Kirim pesan
                }
            });

            // Event listener untuk mendeteksi scroll pada kotak pesan
            $('#chat-messages').on('scroll', function() {
                const chatBox = $('#chat-messages');
                const scrollPosition = chatBox.scrollTop();
                const scrollHeight = chatBox[0].scrollHeight;
                const clientHeight = chatBox[0].clientHeight;

                // Periksa apakah admin berada di bawah kotak pesan
                isScrolledToBottom = scrollHeight - scrollPosition <= clientHeight + 1;
            });

            // Jalankan pembaruan jumlah pesan belum dibaca secara berkala
            setInterval(updateUnreadCounts, 5000);
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
