@extends('layouts.app')

@section('title', 'All Notifications')

@push('style')
    <style>
        .notification-read {
            background-color: #f9f9f9;
        }

        .notification-unread {
            background-color: #eaf6ff;
            border-left: 3px solid #007bff;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>All Notifications</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">Notifications</div>
                </div>
            </div>

            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @forelse($notifications as $notification)
                            <div
                                class="mb-3 p-3 rounded {{ $notification->read_at ? 'notification-read' : 'notification-unread' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $notification->message }}</strong>
                                        <br>
                                        <small class="text-muted" data-time="{{ $notification->created_at }}">
                                            {{ $notification->created_at }}
                                        </small>
                                    </div>
                                    @if (!$notification->read_at)
                                        <form method="POST"
                                            action="{{ route('notifications.markAsRead', $notification->id) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-light">Mark as Read</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No notifications found.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dayjs/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs/plugin/relativeTime.js"></script>
    <script>
        dayjs.extend(dayjs_plugin_relativeTime);
        document.querySelectorAll('[data-time]').forEach(function(el) {
            const time = el.getAttribute('data-time');
            el.textContent = dayjs(time).fromNow();
        });
    </script>
@endpush
