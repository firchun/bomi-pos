@extends('layouts.app')

@section('title', 'User Messages')

@push('style')
    <style>
        .admin-chat.active {
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 8px;
        }

        #chat-messages {
            height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
        }

        /* Chat bubbles */
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
            /* This allows the bubble to resize based on content */
        }

        .text-left p {
            background-color: #f1f1f1;
            /* Light grey for admin messages */
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
            /* This allows the bubble to resize based on content */
        }

        .badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 50%;
        }

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
                    <!-- Sidebar: List Admin -->
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Recent Chat</h4>
                            </div>
                            <div class="card-body">
                                <ul id="admin-list" class="list-unstyled list-unstyled-border">
                                    @foreach ($admins as $admin)
                                        <li class="media admin-chat" data-admin-id="{{ $admin->id }}">
                                            <i class="fas fa-user-circle mr-3" style="font-size: 50px; color: #6c757d;"></i>
                                            <div class="media-body" style="cursor: pointer">
                                                <div class="media-title">{{ $admin->name }}</div>
                                                <span class="text-small text-muted">
                                                    {{ $admin->messages->last()->message ?? 'No messages yet' }}
                                                </span>
                                                <span class="badge badge-danger unread-count"
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
                            <div class="card-body">
                                <div id="chat-messages"
                                    style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                    <p>Select an admin to start chatting.</p>
                                </div>
                                <form id="chat-form">
                                    @csrf
                                    <div class="input-group mt-3">
                                        <textarea class="form-control" id="message-input" placeholder="Type your message"></textarea>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Send</button>
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
    const csrfToken = '{{ csrf_token() }}'; // CSRF token to prevent CSRF attacks
    let currentAdminId = null; // The ID of the selected admin
    let refreshInterval = null; // Interval for periodically loading new messages
    let isScrolledToBottom = true; // Flag to track if user is scrolled to the bottom of the chat box

    // Function to load the last message for all admins when the page is loaded
    const loadLastMessagesForAllAdmins = () => {
        $('.admin-chat').each(function() {
            const adminId = $(this).data('admin-id');
            const adminChatItem = $(this);

            $.ajax({
                url: '{{ route('user.getMessages') }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    admin_id: adminId,
                },
                success: (response) => {
                    const lastMessage = response.messages.length > 0 ?
                        response.messages[response.messages.length - 1].message :
                        'No messages yet';
                    adminChatItem.find('.text-muted').text(lastMessage);

                    const unreadCount = response.unread_count[adminId] || 0;
                    const unreadBadge = adminChatItem.find('.unread-count');
                    if (unreadCount > 0) {
                        unreadBadge.text(unreadCount).show();
                    } else {
                        unreadBadge.hide();
                    }
                },
                error: (xhr) => {
                    console.error('Error loading last message for admin:', xhr.responseText);
                },
            });
        });
    };

    // Function to load messages based on the selected admin
    const loadChatMessages = (adminId) => {
        if (!adminId) return;

        $.ajax({
            url: '{{ route('user.getMessages') }}',
            method: 'POST',
            data: {
                _token: csrfToken,
                admin_id: adminId,
            },
            success: (response) => {
                const messages = response.messages;
                const chatBox = $('#chat-messages');
                chatBox.empty();

                messages.forEach((message) => {
                    const alignment = message.is_admin ? 'text-left' : 'text-right';
                    chatBox.append(
                        `<div class="${alignment}"><p>${message.message}</p></div>`
                    );
                });

                if (isScrolledToBottom) {
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }

                updateLastMessageInList(messages);
            },
            error: (xhr) => {
                console.error('Error loading messages:', xhr.responseText);
            },
        });
    };

    // Function to update the last message in the admin list
    const updateLastMessageInList = (messages) => {
        if (messages.length > 0) {
            const lastMessage = messages[messages.length - 1].message;
            const lastMessageSpan = $(`.admin-chat[data-admin-id="${currentAdminId}"]`).find('.text-muted');

            if (lastMessageSpan.length) {
                lastMessageSpan.text(lastMessage);
            }
        }
    };

    // Function to send a message to the admin
    const sendMessage = () => {
        const message = $('#message-input').val().trim();

        if (!message || !currentAdminId) return;

        // Clear input and show "Sending..." bubble
        $('#message-input').val('');
        const chatBox = $('#chat-messages');
        const tempBubbleId = `temp-bubble-${Date.now()}`; // Unique ID for the temporary bubble
        chatBox.append(
            `<div id="${tempBubbleId}" class="loading-message text-right text-muted"><p>Sending...</p></div>`
        );
        chatBox.scrollTop(chatBox[0].scrollHeight);

        $.ajax({
            url: '{{ route('user.sendMessage') }}',
            method: 'POST',
            data: {
                _token: csrfToken,
                admin_id: currentAdminId,
                message: message,
            },
            success: (response) => {
                $(`#${tempBubbleId}`).replaceWith(
                    `<div class="text-right"><p>${response.message.message}</p></div>`
                );
                chatBox.scrollTop(chatBox[0].scrollHeight);

                updateLastMessageInList([response.message]);
            },
            error: (xhr) => {
                $(`#${tempBubbleId}`).remove();
                console.error('Error sending message:', xhr.responseText);
                alert('Failed to send message. Please try again.');
            },
        });
    };

    // Event listener when a user selects an admin to chat with
    $('#admin-list').on('click', '.admin-chat', function() {
        const adminId = $(this).data('admin-id');
        currentAdminId = adminId;

        $(this).find('.unread-count').hide();

        $('.admin-chat').removeClass('active');
        $(this).addClass('active');

        clearInterval(refreshInterval);
        loadChatMessages(adminId);

        refreshInterval = setInterval(() => loadChatMessages(adminId), 3000);
    });

    // Event listener when the chat form is submitted
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });

    // Event listener when the user presses the Enter key in the message input
    $('#message-input').on('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Event listener to track if the user has manually scrolled
    $('#chat-messages').on('scroll', function() {
        const chatBox = $('#chat-messages');
        const scrollPosition = chatBox.scrollTop();
        const scrollHeight = chatBox[0].scrollHeight;
        const clientHeight = chatBox[0].clientHeight;

        isScrolledToBottom = scrollHeight - scrollPosition <= clientHeight + 1;
    });

    loadLastMessagesForAllAdmins();
});

    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
