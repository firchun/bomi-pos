@extends('layouts.app')

@section('title', 'Comment & Rating')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .rating-stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .rating-item {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .rating-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #rating-summary {
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            background-color: #ffffff;
        }

        #rating-summary ul li {
            font-size: 14px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1><i class="fa fa-star"></i> Comment & Rating</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Comment & Rating</div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')

                    <!-- Search Bar -->
                    <div class="form-group">
                        <input type="search" id="search-keyword" class="form-control" placeholder="Search comments...">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-8">

                    <!-- Comment Container -->
                    <div id="ratings-container"></div>

                    <!-- Pagination -->
                    <div id="comment-pagination" class="mt-3 text-center"></div>

                </div>
                <div class="col-4">
                    <!-- Summary Rating -->
                    <div id="rating-summary" class="mb-4">
                        <h5>Rating Summary</h5>
                        <h1 id="average-rating" class="text-warning">-</h1>
                        </p>
                        <p><strong>Total Reviews:</strong> <span id="total-reviews">-</span></p>
                        <ul class="list-unstyled mb-0">
                            <li class="text-warning">5 ★ : <span id="star-5">0</span></li>
                            <li class="text-warning">4 ★ : <span id="star-4">0</span></li>
                            <li class="text-warning">3 ★ : <span id="star-3">0</span></li>
                            <li class="text-danger">2 ★ : <span id="star-2">0</span></li>
                            <li class="text-danger">1 ★ : <span id="star-1">0</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        function loadComments(shopId, page = 1, keyword = '') {
            $.ajax({
                url: `/comment/${shopId}?page=${page}&keyword=${keyword}`,
                method: 'GET',
                success: function(response) {
                    const container = $('#ratings-container');
                    container.empty();

                    if (response.length === 0) {
                        container.append('<p class="text-muted">No comments found.</p>');
                    }

                    // Summary Variables
                    let totalRating = 0;
                    let totalReviews = response.length;
                    let starCounts = [0, 0, 0, 0, 0]; // Index 0 = ★1, Index 4 = ★5

                    response.forEach(rating => {
                        totalRating += rating.rating;
                        starCounts[rating.rating - 1] += 1;

                        container.append(`
                        <div class="rating-item shadow-sm">
                            <div class="rating-header">
                                <strong>${rating.user?.name || 'Anonymous'}</strong>
                                <span class="badge badge-info">${new Date(rating.created_at).toLocaleDateString()}</span>
                            </div>
                            <div class="rating-stars mt-1 mb-2">
                                ${'★'.repeat(rating.rating)}${'☆'.repeat(5 - rating.rating)}
                            </div>
                            <p>" ${rating.comment || ''} "</p>
                            <button class="btn btn-danger btn-sm mt-2" onclick="deleteComment(${rating.id})">Delete comment</button>
                        </div>
                    `);
                    });

                    // Update summary UI
                    const avg = totalReviews > 0 ? (totalRating / totalReviews).toFixed(1) : 0;
                    $('#average-rating').text(avg + ' ★');
                    $('#total-reviews').text(totalReviews);
                    $('#star-5').text(starCounts[4]);
                    $('#star-4').text(starCounts[3]);
                    $('#star-3').text(starCounts[2]);
                    $('#star-2').text(starCounts[1]);
                    $('#star-1').text(starCounts[0]);

                    $('#comment-pagination').html(renderPagination(response, shopId, keyword));
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

        function renderPagination(pagination, shopId, keyword = '') {
            let html = '';
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
                <button class="btn ${pagination.current_page === i ? 'btn-primary' : 'btn-light'} mx-1"
                    onclick="loadComments(${shopId}, ${i}, '${keyword}')">
                    ${i}
                </button>
            `;
            }
            return html;
        }

        $(document).ready(function() {
            const shopId = {{ $shop->id }};
            loadComments(shopId);

            $('#search-keyword').on('keyup', function() {
                const keyword = $(this).val();
                loadComments(shopId, 1, keyword);
            });
        });
    </script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
