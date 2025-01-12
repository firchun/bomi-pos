@extends('layouts.home')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->name }}" class="img-fluid rounded"
                        style="max-height: 300px; object-fit: cover;">
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="section-title">
                        <h2 class="h1 mb-4">{{ $shop->name }}</h2>
                        <p class="text-purple text-uppercase fw-bold mb-3">{{ $shop->shop_type }}</p>
                        <div class="content pe-0 pe-lg-5">
                            <p>{{ $shop->description }}</p>
                            <p><strong>Open Hours:</strong> {{ $shop->open_time }} - {{ $shop->close_time }}</p>
                            <p><strong>Address:</strong> {{ $shop->address }}</p>
                            <div class="d-flex align-items-center">
                                <!-- Bintang Rating -->
                                <span class="text-warning me-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($averageRating))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <!-- Rata-rata Rating dan Jumlah Komentar -->
                                <span class="ms-2">
                                    {{ number_format($averageRating, 1) }}
                                    ({{ $shop->ratings->count() }}
                                    {{ $shop->ratings->count() === 1 ? 'Comment' : 'Comments' }})
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('shop-pages.partials-shop.products', ['categories' => $categories, 'products' => $products])
    @include('shop-pages.partials-shop.ratings', ['shop' => $shop, 'ratings' => $ratings])
    
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadProducts(shopId, page = 1) {
            $.ajax({
                url: `/product/${shopId}?page=${page}`,
                method: 'GET',
                success: function(response) {
                    const productsContainer = $('#products-container');
                    productsContainer.empty();

                    // Memastikan data produk adalah array
                    const products = response.products.data || [];

                    products.forEach(product => {
                        productsContainer.append(`
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="${product.image ? `/${product.image}` : '/images/default-product.png'}" 
                                     class="card-img-top" 
                                     alt="${product.name}" 
                                     style="height: 300px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">${product.description}</p>
                                    <p class="text-purple"><strong>Price:</strong> Rp${parseFloat(product.price).toLocaleString()}</p>
                                </div>
                            </div>
                        </div>
                `);
                    });

                    $('#product-pagination').html(renderPagination(response.products, 'products', shopId));
                },
                error: function() {
                    alert('Failed to load products.');
                }
            });
        }

        function loadProductsByCategory(shopId, page = 1) {
            $.ajax({
                url: `/product/${shopId}?page=${page}`,
                method: 'GET',
                success: function(response) {
                    const categories = response.categories || []; // Pastikan server mengirim data kategori
                    const products = response.products.data || []; // Data produk dari server

                    categories.forEach(category => {
                        const categoryContainer = $(`#category-${category.id}-products`);
                        categoryContainer.empty(); // Bersihkan kontainer kategori

                        // Filter produk berdasarkan kategori
                        const categoryProducts = products.filter(product => product.category_id ===
                            category.id);

                        if (categoryProducts.length > 0) {
                            categoryProducts.forEach(product => {
                                categoryContainer.append(`
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="${product.image ? `/${product.image}` : '/images/default-product.png'}" 
                                         class="card-img-top" 
                                         alt="${product.name}" 
                                         style="height: 300px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">${product.description}</p>
                                        <p class="text-purple"><strong>Price:</strong> Rp${parseFloat(product.price).toLocaleString()}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                            });
                        } else {
                            categoryContainer.append(`
                        <div class="col-12">
                            <p class="text-center text-muted">No products available in this category.</p>
                        </div>
                    `);
                        }
                    });

                    // Menampilkan pagination produk
                    $('#product-pagination').html(renderPagination(response.products, 'products', shopId));
                },
                error: function() {
                    alert('Failed to load products by category.');
                }
            });
        }

        function loadComments(shopId, page = 1) {
            $.ajax({
                url: `/comment/{{ $shop->id }}?page=${page}`,
                method: 'GET',
                success: function(response) {
                    const commentsContainer = $('#ratings-container');
                    commentsContainer.empty();

                    response.data.forEach(comment => {
                        commentsContainer.append(`
                            <div class="rating-item">
                                <strong>Anonymous</strong>
                                <span class="text-warning">
                                    ${'★'.repeat(comment.rating)}${'☆'.repeat(5 - comment.rating)}
                                </span>
                                <p>${comment.comment || ''}</p>
                                <small class="text-muted">${new Date(comment.created_at).toLocaleDateString()}</small>
                            </div>
                            <hr>
                        `);
                    });

                    $('#comment-pagination').html(renderPagination(response, 'comments', shopId));
                },
                error: function() {
                    alert('Failed to load comments.');
                }
            });
        }

        function renderPagination(pagination, type, shopId) {
            let html = '';
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
            <button class="btn ${pagination.current_page === i ? 'btn-primary' : 'btn-light'} mx-1"
                onclick="load${type.charAt(0).toUpperCase() + type.slice(1)}(${shopId}, ${i})">
                ${i}
            </button>
        `;
            }
            return html;
        }

        $(document).ready(function() {
            const shopId = {{ $shop->id }};
            loadProducts(shopId);
            loadComments(shopId);
            loadProductsByCategory(shopId);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');

                    // Set the rating in the hidden input
                    ratingInput.value = rating;

                    // Remove "checked" class from all stars
                    stars.forEach(star => {
                        star.classList.remove('checked');
                    });

                    // Add "checked" class to the selected stars
                    for (let i = 0; i < rating; i++) {
                        stars[i].classList.add('checked');
                    }
                });
            });
        });
    </script>
@endpush
