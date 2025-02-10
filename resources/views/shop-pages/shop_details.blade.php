@extends('layouts.home')

@section('title', $shop->name)
@section('meta-title', $shop->name)
@section('meta-description', $shop->description)
@section('meta-keywords', $shop->name)

@section('meta-og-title', $shop->name)
@section('meta-og-description', $shop->description)
@section('meta-og-image', $shop->photo)
@section('meta-og-url', url()->current())

@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

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
                                <a href="https://wa.me/?text=Yuk%20Kunjungi%20Caffe/Resto%20Kami!%0A%0ADi%20Caffe/Resto%20kami,%20kamu%20bisa%20menemukan%20berbagai%20menu%20menarik%20dengan%20harga%20terbaik!%0A%0ACek%20langsung%20di%20link%20berikut:%0A{{url('shop/' . $shop->slug)}}%0A%0AJangan%20lupa%20share%20juga%20ya!" 
                                    target="_blank"
                                    class="btn btn-success d-flex align-items-center me-2">
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
                                                <!-- Share ke Facebook Messenger -->
                                                <a href="https://m.me/?link={{ urlencode(url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #007bff !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-facebook-messenger"></i> Messenger
                                                </a>

                                                <!-- Share ke Instagram DM -->
                                                <a href="https://www.instagram.com/direct/inbox/" target="_blank"
                                                    style="color: white !important; background-color: #dc3545 !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-instagram"></i> Instagram DM
                                                </a>

                                                <!-- Share ke Twitter DM -->
                                                <a href="https://twitter.com/messages/compose?text={{ urlencode('Cek toko ini: ' . url('shop/' . $shop->slug)) }}"
                                                    target="_blank"
                                                    style="color: white !important; background-color: #17a2b8 !important; border-radius: 10px !important; padding: 10px 20px; text-decoration: none !important; 
                                                    margin-bottom: 10px; display: inline-block; text-align: center; font-size: 14px; width: 100%;">
                                                    <i class="fab fa-twitter"></i> Twitter DM
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

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-4">
                    <div class="section-title text-center">
                        <p class="text-purple text-uppercase fw-bold mb-3">Find Us Here</p>
                        <h1>Discover the Location of {{ $shop->name }}</h1>
                    </div>

                    <div class="mt-5">
                        <div id="map" style="height: 400px; width: 100%; margin-top: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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

        function loadProductsByCategory(shopId, categoryId, page = 1) {
            $.ajax({
                url: `/product/${shopId}?category_page_${categoryId}=${page}`,
                method: 'GET',
                success: function(response) {
                    const categoryContainer = $(`#category-${categoryId}-products`);
                    categoryContainer.empty();

                    const categoryProducts = response.categoryProducts[categoryId]?.data || [];

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

                    // Render pagination khusus untuk kategori ini
                    $(`#category-${categoryId}-pagination`).html(renderPagination(response.categoryProducts[
                        categoryId], 'category', shopId, categoryId));
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

        function renderPagination(pagination, type, shopId, categoryId = null) {
            let html = '';
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `
                    <button class="btn ${pagination.current_page === i ? 'btn-primary' : 'btn-light'} mx-1"
                        onclick="${type === 'products' ? `loadProducts(${shopId}, ${i})` : `loadProductsByCategory(${shopId}, ${categoryId}, ${i})`}">
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
            @foreach ($categories as $category)
                loadProductsByCategory(shopId, {{ $category->id }});
            @endforeach
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

        document.addEventListener('DOMContentLoaded', function() {
            const latitude = {{ $shop->location->latitude ?? 0 }};
            const longitude = {{ $shop->location->longitude ?? 0 }};
            const shopName = "{{ $shop->name }}";

            // Inisialisasi peta
            const map = L.map('map').setView([latitude, longitude], 15);

            // Tambahkan tile layer dari Esri Satellite (peta satelit)
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '© Esri & OpenStreetMap contributors'
                }).addTo(map);

            // Tambahkan marker ke lokasi toko
            const marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup(`
                <div style="text-align: center;">
                    <strong>${shopName}</strong><br>
                    <a href="https://www.google.com/maps?q=${latitude},${longitude}" target="_blank" 
                    style="color: #9900CC; text-decoration: underline; display: inline-block; margin-top: 5px;">
                        🗺️ Buka di Google Maps
                    </a>
                </div>
            `)
                .openPopup();

            // Tambahkan event agar marker bisa diklik untuk membuka Google Maps
            marker.on('click', function() {
                window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
            });
        });
    </script>
@endpush
