@extends('layouts.home2')

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
    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Outlet / {{ $shop->name }}
        </section>
    <!-- images -->
        <section class="mt-10 flex justify-center">
            <div class="relative w-full h-[300px]">
                <!-- Gambar kiri -->
                <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->slug }}"
                    onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                    class="absolute top-0 left-[50px] w-[500px] h-[280px] rounded-2xl shadow-lg opacity-60 blur-sm"
                    alt="Gambar Kiri">

                <!-- Gambar kanan -->
                <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->slug }}"
                    onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                    class="absolute top-0 right-[50px] w-[500px] h-[280px] rounded-2xl shadow-lg opacity-60 blur-sm"
                    alt="Gambar Kanan">

                <!-- Gambar tengah -->
                <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->slug }}"
                    onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-[500px] h-[300px] rounded-2xl shadow-xl z-10"
                    alt="Gambar Tengah">

            </div>
        </section>
        <!-- detail shop -->
        <section class="mt-[50px]">
            <div class="w-full flex flex-col md:flex-row gap-4">
                <!-- MAP -->
                <div class="relative w-full md:w-1/2 h-100 rounded-2xl overflow-hidden shadow-md bg-white/30 border-2 border-white backdrop-blur-xl dark:border-neutral-800 transition-colors duration-300"
                    id="map">

                </div>
                <!-- INFO shop -->
                <div
                    class="w-full md:w-1/2 bg-white/30 border-2 border-white backdrop-blur-xl rounded-2xl p-6 shadow-md flex flex-col justify-between dark:bg-zinc-900/50 dark:border-black transition-colors duration-300">
                    <div>
                        <h3
                            class="text-3xl mb-5 font-extrabold text-fuchsia-700 font-['Lexend'] dark:text-white transition-colors duration-300">
                            {{ $shop->name }}</h3>
                        <p
                            class="text-purple-700 w-fit px-4 py-2 rounded-xl bg-purple-300 dark:bg-purple-800/30 dark:text-purple-300 transition-colors duration-300">
                            <i class="bi bi-shop-window"></i> {{ $shop->shop_type }}
                        </p>
                        <p
                            class="text-neutral-600 text-md font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300">
                            {{ $shop->description }}
                        </p>
                        <p
                            class="text-neutral-600 text-xl font-medium font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300 space-x-5">
                            <i class="bi bi-clock-fill text-purple-700 dark:text-white"></i>
                            {{ (new DateTime($shop->open_time))->format('h:i A') }} -
                            {{ (new DateTime($shop->close_time))->format('h:i A') }}
                        </p>
                        <p
                            class="text-neutral-600 text-xl font-medium font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300 space-x-5">
                            <i class="bi bi-map-fill text-purple-700 dark:text-white"></i> {{ $shop->address }}
                        <div class="flex items-center justify-star space-x-3 mt-[10px] ">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($averageRating))
                                    <i class="bi bi-star-fill text-xl text-yellow-500"></i>
                                @else
                                    <i class="bi bi-star-fill text-xl text-gray-400"></i>
                                @endif
                            @endfor
                            <div class="text-neutral-600 dark:text-neutral-300">
                                {{ number_format($averageRating, 1) }}
                                ({{ $shop->ratings->count() }}
                                {{ $shop->ratings->count() === 1 ? 'Comment' : 'Comments' }})
                            </div>
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="flex gap-4 mt-6">
                        <a href="https://wa.me/?text=Yuk%20Kunjungi%20Caffe/Resto%20Kami!%0A%0ADi%20Caffe/Resto%20kami,%20kamu%20bisa%20menemukan%20berbagai%20menu%20menarik%20dengan%20harga%20terbaik!%0A%0ACek%20langsung%20di%20link%20berikut:%0A{{ url('shop/' . $shop->slug) }}%0A%0AJangan%20lupa%20share%20juga%20ya!"
                            target="_blank"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-xl text-xl font-medium font-['Lexend']">
                            <i class="bi bi-whatsapp"></i> Share to Whatsapp
                        </a>
                        <button
                            class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl text-xl font-medium font-['Lexend']">
                            <i class="bi bi-share-fill"></i> Share
                        </button>

                    </div>
                </div>
            </div>
        </section>
        <!-- Search Section (Trigger) -->
        @include('home-pages._search')

        <!--tab category -->
        <section class="mt-10 flex justify-center space-x-3">
            <div class="bg-white dark:bg-gray-800 p-2 rounded-3xl w-fit max-w-full">
                <!-- Dropdown untuk sm -->
                <select onchange="switchTab(this.value)"
                    class="block sm:hidden w-full px-4 py-2 rounded-xl border border-purple-300 dark:border-purple-600 dark:bg-gray-800 dark:text-white">
                    <option value="all">All</option>
                    @foreach ($categories as $cat)
                        <option value="category-{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>

                <!-- Tab horizontal untuk sm ke atas -->
                <div class="hidden sm:flex space-x-3 text-purple-700 dark:text-purple-300  text-md mt-4 sm:mt-0"
                    id="tabs">
                    <button onclick="switchTab('all')"
                        class="tab-btn px-4 py-2 rounded-2xl bg-purple-300 text-purple-800 dark:bg-purple-700 dark:text-white"
                        id="tab-btn-all">All</button>
                    @foreach ($categories as $cat)
                        <button onclick="switchTab('category-{{ $cat->id }}')"
                            class="tab-btn px-4 py-2 rounded-2xl hover:bg-purple-200 dark:hover:bg-purple-600"
                            id="tab-btn-category-{{ $cat->id }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-2 rounded-3xl w-fit max-w-full">
                <button class="px-4 py-2 rounded-2xl bg-purple-300 text-purple-800 dark:bg-purple-700 dark:text-white">
                    Best Seller
                </button>
            </div>
        </section>

        <!-- list outlet -->
        <section class="container mx-auto mt-8">
            <!-- Semua Produk -->
            <div id="tab-all" class="tab-content grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                <div class="col-span-full text-center text-gray-500">Loading all products...</div>
            </div>

            <!-- Pagination -->
            <div id="product-pagination" class="flex justify-center mt-6"></div>
        </section>

        {{-- rating and reviews --}}
        <section class="mt-[30px] mb-[100px] p-6  sm:w-full mx-auto">
            <h2 class="text-4xl font-bold text-zinc-700 dark:text-white mb-4 text-center">Rating and Reviews</h2>
            <div class="flex items-end justify-center space-x-3">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($averageRating))
                        <i class="bi bi-star-fill text-5xl text-yellow-500"></i>
                    @else
                        <i class="bi bi-star-fill text-5xl text-gray-400"></i>
                    @endif
                @endfor
            </div>
            <div class="flex justify-center mt-3">
                <p class="ms-1  text-xl text-gray-500 dark:text-gray-400"> {{ number_format($averageRating, 1) }}
                    out of {{ $shop->ratings->count() }} Review </p>
            </div>
            <div class="flex justify-center">
                <button onclick="toggleReviewModal()"
                    class="my-[30px] bg-purple-700 rounded-2xl text-white px-5 py-3 hover:bg-yellow-500 duration-300">
                    <i class="bi bi-star-fill"></i> Write a New Review
                </button>
            </div>
            {{-- modal review --}}
            <div id="reviewModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
                <!-- Modal Box -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-2xl p-6 mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Write a New Review</h2>
                        <button onclick="toggleReviewModal()"
                            class="text-zinc-500 hover:text-zinc-800 dark:hover:text-white">
                            ✕
                        </button>

                    </div>
                    <form action="{{ route('shop.rate', $shop->slug) }}" method="POST">
                        @csrf
                        <!-- Star Rating -->
                        <div class="flex justify-center mb-4" id="starContainer">
                            <!-- Stars will be injected here -->

                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill text-3xl text-gray-400 mx-1 cursor-pointer star"
                                    data-rating="{{ $i }}"onclick="setRating({{ $i }})"></i>
                            @endfor
                            <input type="hidden" name="rating" id="rating" />
                        </div>

                        <!-- Review Text -->
                        <textarea id="reviewText" rows="4"
                            class="w-full p-3 border border-purple-700 rounded-lg text-zinc-800 dark:text-white dark:bg-zinc-800"
                            placeholder="Write your review..." name="comment"></textarea>

                        <!-- Buttons -->
                        <div class="flex justify-end mt-4 gap-2">
                            <button type="submit"
                                class="bg-purple-700 text-white px-4 py-2 rounded-xl hover:bg-yellow-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="grid lg:grid-cols-2 mt-[30px] mx-auto gap-6 sm:grid-cols-1" id="ratings-container">
            </div>
        </section>

    </div>
    {{-- ads --}}
    @if($ads)
    <div x-data="{ open: true }" x-show="open"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur overflow-auto">
    
    <div class="w-full max-w-5xl mx-auto rounded-lg shadow-xl p-4  overflow-auto">

        <!-- Tombol Tutup -->
        <div class="flex justify-center mb-4">
            <button @click="open = false" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                Close Ads
            </button>
        </div>

        <!-- Konten -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 justify-center">
            
            <!-- Gambar -->
            <div class="flex justify-center w-full md:w-auto">
                <img src="{{ asset($ads->image) }}" alt="{{ $ads->title }}"
                    class="w-[90vw] max-w-[500px] h-[90vw] max-h-[500px] md:w-[500px] md:h-[500px] object-cover rounded-xl">
            </div>

            <!-- Deskripsi -->
            <div class="text-zinc-800 dark:text-white rounded-lg p-4 shadow-md bg-white dark:bg-zinc-700 w-[400px]">
                <h2 class="text-xl font-semibold mb-2">{{ $ads->title }}</h2>
                <hr class="mb-2 border-zinc-300 dark:border-zinc-600">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    {!! $ads->description !!}
                </p>
            </div>
        </div>
    </div>
</div>
    @endif
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const shopId = {{ $shop->id }};

        function loadComments(shopId) {
            $.ajax({
                url: `/comment/${shopId}`, // tanpa ?page
                method: 'GET',
                success: function(response) {
                    const commentsContainer = $('#ratings-container');
                    commentsContainer.empty();

                    if (response.length > 0) {
                        response.forEach(comment => {
                            commentsContainer.append(`
                      <article class="bg-white/50 dark:bg-zinc-800/70 rounded-2xl p-5 mb-4 w-full max-w-2xl break-words">
                            <div class="flex items-center mb-4">
                                <div class="font-medium dark:text-white">
                                    <p>Customer</p>
                                </div>
                            </div>
                            <div class="flex items-center mb-2 space-x-2 rtl:space-x-reverse">
                                ${'<i class="bi bi-star-fill w-4 h-4 text-yellow-300"></i>'.repeat(comment.rating)}
                                ${'<i class="bi bi-star-fill w-4 h-4 text-gray-500 dark:text-gray-400"></i>'.repeat(5 - comment.rating)}
                            </div>
                            <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                <p>Reviewed in <time datetime="${comment.created_at}">${new Date(comment.created_at).toLocaleDateString()}</time></p>
                            </footer>
                           <div class="text-gray-500 dark:text-gray-400 max-h-40 overflow-y-auto whitespace-pre-line break-words">${comment.comment || ''}</div>
                        </article>
                    `);
                        });
                    } else {
                        commentsContainer.append(`
                    <div class="no-comments">
                        <p class="text-center text-muted">No comments available.</p>
                    </div>
                `);
                    }
                },
                error: function() {
                    alert('Failed to load comments.');
                }
            });
        }

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

        $(document).ready(function() {

            loadProducts(shopId);
            loadComments(shopId);

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

        $(document).ready(function() {
            switchTab('all');
        });

        function switchTab(tabId) {
            // Sembunyikan semua konten tab
            $('.tab-content').addClass('hidden');

            // Tampilkan konten tab yang sesuai
            $('#tab-' + tabId).removeClass('hidden');

            // Ubah styling tombol tab aktif
            $('.tab-btn').removeClass('bg-purple-300 text-purple-800 dark:bg-purple-700 dark:text-white');
            $('#tab-btn-' + tabId).addClass('bg-purple-300 text-purple-800 dark:bg-purple-700 dark:text-white');

            // Load produk untuk tab yang dipilih
            if (tabId === 'all') {
                loadProducts(shopId, 1);
            } else {
                const categoryId = tabId.replace('category-', '');
                loadProducts(shopId, 1, categoryId);
            }
        }

        function loadProducts(shopId, page = 1, categoryId = null) {
            const url = categoryId ?
                `/product/${shopId}?category_page_${categoryId}=${page}` :
                `/product/${shopId}?page=${page}`;

            $.ajax({
                url,
                method: 'GET',
                success: function(response) {
                    const products = response.products?.data || [];

                    // Target container
                    const targetId = categoryId ? `#tab-category-${categoryId}` : '#tab-all';
                    const productsContainer = $(targetId);
                    const paginationContainer = $('#product-pagination');

                    productsContainer.empty();
                    if (!categoryId) paginationContainer.empty(); // pagination hanya untuk semua produk

                    if (products.length > 0) {
                        products.forEach(product => {
                            productsContainer.append(`
                    <div class="rounded-2xl overflow-hidden  border border-transparent hover:border-purple-700 shadow-md hover:shadow-xl bg-white dark:bg-zinc-800 transition-colors duration-300">
                        <img src="${product.image ? `/${product.image}` : '/images/default-product.png'}"
                            alt="${product.name}"
                            onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                            class="w-full h-48 object-cover rounded-t-2xl" />
                        <div class="p-4 relative">
                            <span class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                                ${product.category.name || 'Product'}
                            </span>
                            <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">
                                Rp${parseFloat(product.price).toLocaleString()}
                            </p>
                            <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">${product.name}</p>
                            <p class="text-gray-600 dark:text-zinc-300 text-sm">${product.description}</p>
                        </div>
                    </div>
                    `);
                        });

                        if (!categoryId) {
                            renderPagination(response.products, shopId); // hanya untuk semua
                        }
                    } else {
                        productsContainer.append(
                            `<div class="col-span-full text-center text-gray-500">No products found.</div>`);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Failed to load products.');
                }
            });
        }

        function renderPagination(paginationData, shopId, categoryId = null) {
            const paginationContainer = $('#product-pagination');
            paginationContainer.empty();

            const currentPage = paginationData.current_page;
            const lastPage = paginationData.last_page;

            const nav = $(`
                <nav class="inline-flex items-center rounded-xl shadow-sm bg-white dark:bg-zinc-800 px-2 py-1 space-x-1 transition-colors duration-300">
                </nav>
            `);

            // Previous Button
            // if (currentPage > 1) {
            // Previous Button
            nav.append(`
                <a href="#" onclick="event.preventDefault(); ${currentPage > 1 ? `loadProducts(${shopId}, ${currentPage - 1}, ${categoryId})` : ''}"
                  class="px-3 py-2 text-sm font-medium rounded-md transition ${
                    currentPage > 1
                      ? 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                      : 'text-gray-400 cursor-not-allowed'
                  }">
                    Previous
                </a>
              `);
            // }
            function renderPagination(paginationData, shopId, categoryId = null) {
                const paginationContainer = $('#product-pagination');
                paginationContainer.empty();

                const currentPage = paginationData.current_page;
                const lastPage = paginationData.last_page;

                const nav = $(`
                    <nav class="inline-flex items-center rounded-xl shadow-sm bg-white dark:bg-zinc-800 px-2 py-1 space-x-1 transition-colors duration-300">
                    </nav>
                `);

                // Previous Button
                // if (currentPage > 1) {
                //     nav.append(`
            //       <a href="#" onclick="event.preventDefault(); loadProducts(${shopId}, ${currentPage - 1}, ${categoryId})"
            //         class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
            //           Previous
            //       </a>
            //   `);
                // }
                // Previous Button
                nav.append(`
              <a href="#" onclick="event.preventDefault(); ${currentPage > 1 ? `loadProducts(${shopId}, ${currentPage - 1}, ${categoryId})` : ''}"
                class="px-3 py-2 text-sm font-medium rounded-md transition ${
                  currentPage > 1
                    ? 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                    : 'text-gray-400 cursor-not-allowed'
                }">
                  Previous
              </a>
            `);


                // Generate page numbers
                const maxVisible = 5;
                let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
                let end = Math.min(lastPage, start + maxVisible - 1);

                if (end - start < maxVisible - 1) {
                    start = Math.max(1, end - maxVisible + 1);
                }

                if (start > 1) {
                    nav.append(pageButton(1, shopId, categoryId, currentPage));
                    if (start > 2) {
                        nav.append(`<span class="px-3 py-2 text-sm text-gray-500">...</span>`);
                    }
                }

                for (let i = start; i <= end; i++) {
                    nav.append(pageButton(i, shopId, categoryId, currentPage));
                }

                if (end < lastPage) {
                    if (end < lastPage - 1) {
                        nav.append(`<span class="px-3 py-2 text-sm text-gray-500">...</span>`);
                    }
                    nav.append(pageButton(lastPage, shopId, categoryId, currentPage));
                }

                // Next Button
                // if (currentPage < lastPage) {
                //     nav.append(`
            //       <a href="#" onclick="event.preventDefault(); loadProducts(${shopId}, ${currentPage + 1}, ${categoryId})"
            //         class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
            //           Next
            //       </a>
            //   `);
                // }
                // Next Button
                nav.append(`
                <a href="#" onclick="event.preventDefault(); ${currentPage < lastPage ? `loadProducts(${shopId}, ${currentPage + 1}, ${categoryId})` : ''}"
                  class="px-3 py-2 text-sm font-medium rounded-md transition ${
                    currentPage < lastPage
                      ? 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                      : 'text-gray-400 cursor-not-allowed'
                  }">
                    Next
                </a>
              `);


                paginationContainer.append(
                    $('<div class="flex justify-center mt-10"></div>').append(nav)
                );
            }

            function pageButton(page, shopId, categoryId, currentPage) {
                const isActive = page === currentPage;
                return `
              <a href="#" onclick="event.preventDefault();  loadProducts(${shopId}, ${page}, ${categoryId})"
                class="px-3 py-2 text-sm font-medium ${isActive
                      ? 'text-white bg-purple-600 hover:bg-purple-700'
                      : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'} rounded-md transition">
                  ${page}
              </a>
          `;
            }

            // Generate page numbers
            const maxVisible = 5;
            let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let end = Math.min(lastPage, start + maxVisible - 1);

            if (end - start < maxVisible - 1) {
                start = Math.max(1, end - maxVisible + 1);
            }

            if (start > 1) {
                nav.append(pageButton(1, shopId, categoryId, currentPage));
                if (start > 2) {
                    nav.append(`<span class="px-3 py-2 text-sm text-gray-500">...</span>`);
                }
            }

            for (let i = start; i <= end; i++) {
                nav.append(pageButton(i, shopId, categoryId, currentPage));
            }

            if (end < lastPage) {
                if (end < lastPage - 1) {
                    nav.append(`<span class="px-3 py-2 text-sm text-gray-500">...</span>`);
                }
                nav.append(pageButton(lastPage, shopId, categoryId, currentPage));
            }

            // Next Button
            // if (currentPage < lastPage) {
            // Next Button
            nav.append(`
                  <a href="#" onclick="event.preventDefault(); ${currentPage < lastPage ? `loadProducts(${shopId}, ${currentPage + 1}, ${categoryId})` : ''}"
                    class="px-3 py-2 text-sm font-medium rounded-md transition ${
                      currentPage < lastPage
                        ? 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                        : 'text-gray-400 cursor-not-allowed'
                    }">
                      Next
                  </a>
                `);
            // }

            paginationContainer.append(
                $('<div class="flex justify-center mt-10"></div>').append(nav)
            );
        }

        function pageButton(page, shopId, categoryId, currentPage) {
            const isActive = page === currentPage;
            return `
              <a href="#" onclick="event.preventDefault();  loadProducts(${shopId}, ${page}, ${categoryId})"
                class="px-3 py-2 text-sm font-medium ${isActive
                      ? 'text-white bg-purple-600 hover:bg-purple-700'
                      : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'} rounded-md transition">
                  ${page}
              </a>
          `;
        }
    </script>
@endpush
