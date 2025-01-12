@extends('layouts.app')

@section('title', 'Comment & Rating')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Comment & Rating</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Comment & Rating</div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Dropdown untuk memilih toko -->
                            <div class="mb-4">
                                <label for="shop-select">Select Shop:</label>
                                <select id="shop-select" class="form-control" onchange="loadComments(this.value)">
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}"
                                            {{ $selectedShop && $shop->id == $selectedShop->id ? 'selected' : '' }}>
                                            {{ $shop->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kontainer untuk komentar -->
                            <div id="ratings-container">

                            </div>

                            <!-- Pagination -->
                            <div id="comment-pagination" class="mt-3">
                                @if ($ratings)
                                    {{ $ratings->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadComments(shopId, page = 1) {
            $.ajax({
                url: `/comment/${shopId}?page=${page}`,
                method: 'GET',
                success: function(response) {
                    const container = $('#ratings-container');
                    container.empty();

                    response.data.forEach(rating => {
                        container.append(`
                    <div class="rating-item">
                        <strong>Anonymous</strong>
                        <span class="text-warning">
                            ${'★'.repeat(rating.rating)}${'☆'.repeat(5 - rating.rating)}
                        </span>
                        <p>${rating.comment || ''}</p>
                        <small class="text-muted">${new Date(rating.created_at).toLocaleDateString()}</small>
                        <button class="btn btn-danger btn-sm mt-2 mr-2" onclick="deleteComment(${rating.id})">Delete</button>
                    </div>
                    <hr>
                `);
                    });

                    $('#comment-pagination').html(renderPagination(response, shopId));
                },
                error: function(xhr) {
                    alert(`Failed to load comments. Error: ${xhr.responseText}`);
                }
            });
        }

        function deleteComment(commentId) {
            if (confirm('Are you sure you want to delete this comment?')) {
                $.ajax({
                    url: `/ratings/delete/${commentId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to delete comment.');
                    }
                });
            }
        }

        function renderPagination(pagination, shopId) {
            let html = '';
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
                    <button class="btn ${pagination.current_page === i ? 'btn-primary' : 'btn-light'} mx-1"
                        onclick="loadComments(${shopId}, ${i})">
                        ${i}
                    </button>
                `;
            }
            return html;
        }

        $(document).ready(function() {
            const shopId = {{ $shop->id }};
            loadComments(shopId);
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
