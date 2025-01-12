@extends('layouts.home')

@section('title', $shop->name)
@section('meta-title', $shop->name)
@section('meta-description', $shop->description)
@section('meta-keywords', $shop->name)

@section('meta-og-title', $shop->name)
@section('meta-og-description', $shop->description)
@section('meta-og-image', $shop->photo)
@section('meta-og-url', url()->current())

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
                            <p><strong>Open Hours:</strong>
                                {{ (new DateTime($shop->open_time))->format('h:i A') }} -
                                {{ (new DateTime($shop->close_time))->format('h:i A') }}
                            </p>
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

                            <!-- Tombol Bagikan -->
                            <div class="mt-3 d-flex">
                                <a href="https://wa.me/?text={{ urlencode(url('shop/' . $shop->slug)) }}" target="_blank"
                                    class="btn btn-success btn-lg d-flex align-items-center me-2">
                                    <i class="fab fa-whatsapp me-1"></i> Bagikan ke WhatsApp
                                </a>

                                <!-- Tombol Share Lainnya -->
                                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#shareModal">
                                    <i class="fas fa-share-alt"></i> Share
                                </button>
                            </div>

                            <!-- Modal Opsi Share -->
                            <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel"
                                style="z-index: 2000 !important;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="shareModalLabel">Bagikan ke Media Sosial</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Kontainer Tombol Share -->
                                            <div class="d-flex flex-column align-items-center">
                                                <!-- Share ke Facebook -->
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #007bff !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-facebook-f"></i> Facebook
                                                </a>

                                                <!-- Share ke Instagram -->
                                                <a href="https://www.instagram.com/?url={{ urlencode(url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #dc3545 !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-instagram"></i> Instagram
                                                </a>

                                                <!-- Share ke Twitter -->
                                                <a href="https://twitter.com/intent/tweet?text={{ urlencode(url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #17a2b8 !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-twitter"></i> Twitter
                                                </a>

                                                <!-- Share ke WhatsApp -->
                                                <a href="https://wa.me/?text={{ urlencode(url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #28a745 !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

                    if (products.length > 0) {
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
                    } else {
                        productsContainer.append(`
                            <div class="col-12">
                                <p class="text-center text-muted">No products available.</p>
                            </div>
                        `);
                    }

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

                    if (response.data.length > 0) {
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
                    } else {
                        commentsContainer.append(`
                            <div class="no-comments">
                                <p class="text-center text-muted">No comments available.</p>
                            </div>
                        `);
                    }

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
