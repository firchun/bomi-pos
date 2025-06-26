@extends('layouts.home2')

@section('title', $shop->name . ' | Bomi POS')
@section('meta-title', $shop->name . ' | Bomi POS')
@section('meta-description', $shop->description)
@section('meta-keywords', $shop->name)

@section('meta-og-title', $shop->name . ' | Bomi POS')
@section('meta-og-description', $shop->description)
@section('meta-og-image', $shop->photo)
@section('meta-og-url', url()->current())
@section('meta-twitter-image', asset('storage/' . $shop->photo))
@section('meta-og-image', asset('storage/' . $shop->photo))

@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .leaflet-container .leaflet-control-container .leaflet-control-attribution {
            display: none !important;
        }
    </style>
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
                    class="absolute top-0 left-5 sm:left-[50px] w-[500px] h-[280px] rounded-2xl shadow-lg opacity-60 blur-sm"
                    alt="Gambar Kiri">

                <!-- Gambar kanan -->
                <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->slug }}"
                    onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                    class="absolute top-0 right-5 sm:right-[50px] w-[500px] h-[280px] rounded-2xl shadow-lg opacity-60 blur-sm"
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
            <div class="w-full flex flex-col lg:flex-row gap-4">
                <!-- MAP -->
                <!-- Tombol hanya muncul di bawah sm -->
                <!-- Peta Tampilan Besar -->
                <div id="map" class="w-full lg:w-1/2 z-10 h-96 rounded-xl shadow mb-4 hidden sm:block"></div>

                <!-- Tombol Peta (untuk layar kecil) -->
                <div class="sm:hidden text-center">
                    <button onclick="showMapPopup()"
                        class="bg-purple-600 text-white px-4 py-2 w-full rounded-xl shadow">Lihat
                        Lokasi</button>
                </div>

                <!-- Popup Peta -->
                <div id="mapPopup" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center">
                    <div class="bg-white dark:bg-zinc-900 p-4 rounded-lg w-11/12 max-w-md relative shadow-xl">
                        <button onclick="hideMapPopup()"
                            class="w-full text-sm text-red-600 font-semibold px-2 py-2 border border-red-500 rounded-xl">Tutup</button>
                        <div id="mapPopupContent" class="w-full h-[70vh] rounded-xl overflow-hidden mt-6"></div>
                    </div>
                </div>
                <!-- INFO shop -->
                <div
                    class="w-full lg:w-1/2 bg-white/30 border-2 border-white backdrop-blur-xl rounded-2xl p-6 shadow-md flex flex-col justify-between dark:bg-zinc-900/50 dark:border-black transition-colors duration-300">
                    <div>
                        <h3
                            class="text-xl sm:text-3xl mb-5 font-extrabold text-fuchsia-700 font-['Lexend'] dark:text-white transition-colors duration-300">
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
                            <div class="hidden sm:inline-block text-neutral-600 dark:text-neutral-300">
                                {{ number_format($averageRating, 1) }}
                                ({{ $shop->ratings->count() }}
                                {{ $shop->ratings->count() === 1 ? 'Review' : 'Reviews' }})
                            </div>
                        </div>
                        <div class="sm:hidden inline-block text-neutral-600 dark:text-neutral-300">
                            {{ number_format($averageRating, 1) }}
                            ({{ $shop->ratings->count() }}
                            {{ $shop->ratings->count() === 1 ? 'Review' : 'Reviews' }})
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="flex gap-4 mt-6 justify-center">
                        @php
                            $text =
                                "🎉 Yuk Kunjungi {$shop->name}!\n\nDi {$shop->name}, kamu bisa menemukan berbagai menu menarik dengan harga terbaik!\n\n👉 Lihat menu lengkapnya di:\n" .
                                url('shop/' . $shop->slug) .
                                "\n\nJangan lupa share ke teman-teman juga ya! 🙌";
                            $encodedText = urlencode($text);
                        @endphp

                        <a href="https://wa.me/?text={{ $encodedText }}" target="_blank"
                            class="bg-green-700 hover:bg-green-800 text-white text-center px-4 py-3 rounded-xl text-md font-medium font-['Lexend']">
                            <i class="bi bi-whatsapp"></i> <span class="hidden sm:inline">Share to Whatsapp</span>
                        </a>
                        <button id="shareBtn"
                            class="bg-purple-700 hover:bg-purple-800 text-white px-4 text-center py-3 rounded-xl text-md font-medium font-['Lexend'] flex items-center gap-2">
                            <i class="bi bi-share-fill"></i>
                            <span class="hidden sm:inline">Share</span>
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
            <button id="openModalBtn"
                class="px-4 py-2 rounded-3xl bg-purple-300 text-purple-800 dark:bg-purple-700 dark:text-white">
                Best Seller
            </button>
            <!-- Modal Background -->
            <div id="modalBestSeller" class="fixed inset-0  backdrop-blur flex items-center justify-center hidden z-50">
                <!-- Modal Content -->
                <div class="bg-white dark:bg-zinc-900  rounded-2xl w-full mx-3 max-w-lg p-6 shadow-lg relative">
                    <h2 class="text-xl font-semibold mb-4 text-center dark:text-white">Best Seller Products</h2>

                    <ul class="divide-y divide-gray-300 dark:divide-gray-700 max-h-96 overflow-y-auto">
                        @forelse ($bestSellerProducts as $product)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <span class="font-semibold dark:text-white">{{ $product->name }}</span><br>

                                </div>
                                <div class="text-purple-700 dark:text-purple-400 font-bold">
                                    @if ($product->discount != 0)
                                        <del> Rp {{ number_format($product->price) }}</del> <br>
                                        <span class="text-red-600">Rp {{ number_format($product->price_final) }}</span>
                                    @else
                                        Rp {{ number_format($product->price) }}
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="py-3 text-center text-gray-500">No best seller products found.</li>
                        @endforelse
                    </ul>

                    <button id="closeModalBtn" class="mt-6 block mx-auto px-6 py-2 rounded-lg bg-red-500 text-white">
                        Close
                    </button>
                </div>
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
                    <span>out of {{ $shop->ratings->count() }} Review <span>
                </p>

            </div>
            <div class="flex justify-center space-x-2 md:space-x4">
                <button onclick="toggleReviewModal()"
                    class="my-[30px] bg-purple-700 rounded-2xl text-white px-5 py-3 hover:bg-yellow-500 duration-300">
                    <i class="bi bi-star-fill"></i> Write a New Review
                </button>
                <button onclick="loadAllComments({{ $shop->id }})"
                    class="my-[30px] bg-yellow-500 rounded-2xl text-white px-5 py-3 hover:bg-purple-500 duration-300">
                    <i class="bi bi-star-fill"></i> All Review
                </button>
            </div>
            <!-- Popup -->
            <div id="commentPopup" class="fixed inset-0 z-50 backdrop-blur  flex items-center justify-center hidden">
                <div
                    class="bg-white/80 dark:bg-zinc-900/80 rounded-xl w-[32rem] max-w-[32rem] max-h-[80vh] relative p-6 mx-3">
                    <!-- Tombol close -->
                    <button onclick="document.getElementById('commentPopup').classList.add('hidden')"
                        class="absolute top-3 right-3 text-gray-700 dark:text-gray-300 hover:text-red-500">
                        <i class="bi bi-x text-red-600 text-3xl"></i>
                    </button>
                    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">All Reviews</h2>

                    <div id="all-ratings-container" class="overflow-y-auto max-h-[60vh]"></div>
                </div>
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
    @if ($ads)
        <div x-data="{ open: Math.random() < 0.5 }" x-show="open"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm overflow-auto">

            <div class="w-full max-w-5xl mx-auto rounded-lg  p-4  overflow-auto">

                <!-- Tombol Tutup -->
                <div class="flex justify-center mb-4">
                    <button @click="open = false"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
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
                    <div
                        class="text-zinc-800 dark:text-white rounded-lg p-4 shadow-md bg-white dark:bg-zinc-700 md:w-[400px] w-full">
                        <h2 class="text-md md:text-xl font-semibold mb-2">{{ $ads->title }}</h2>
                        {{-- <hr class="mb-2 border-zinc-300 dark:border-zinc-600"> --}}
                        <p class="text-sm text-zinc-700 dark:text-zinc-300">
                            <i>{!! $ads->description !!}</i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div id="productModal"
        class="fixed inset-0 z-50 backdrop-blur bg-zinc-900/20 dark:bg-purple-900/20 hidden flex items-center justify-center transition-all duration-300">

        <!-- Container modal dan logo (relative) -->
        <div class="relative w-3/4 max-w-xl">

            <!-- Logo di tengah atas -->
            <img src="{{ asset('home2') }}/assets/svg/logo.svg" alt="logo"
                class="h-25 w-25 absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-[120%] z-10" />

            <!-- Card modal -->
            <div class="bg-white/90 dark:bg-zinc-900/90 rounded-2xl p-6  backdrop-blur-xl relative">
                <div id="modalContent">
                    <!-- Content will be injected via JS -->
                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalBestSeller = document.getElementById('modalBestSeller');

        openModalBtn.addEventListener('click', () => {
            modalBestSeller.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', () => {
            modalBestSeller.classList.add('hidden');
        });

        modalBestSeller.addEventListener('click', (e) => {
            if (e.target === modalBestSeller) {
                modalBestSeller.classList.add('hidden');
            }
        });
    </script>
    <script>
        const latitude = {{ $shop->location->latitude ?? 0 }};
        const longitude = {{ $shop->location->longitude ?? 0 }};
        const shopName = "{{ $shop->name }}";

        // Konten HTML popup untuk marker
        function getPopupHTML() {
            return `
                <div style="text-align: center;" >
                    <strong  style="color: rgb(126, 34, 206);">${shopName}</strong><br>
                    <a href="https://www.google.com/maps?q=${latitude},${longitude}" target="_blank"
                        style="color: #9900CC; text-decoration: underline; display: inline-block; margin-top: 5px;">
                         Buka di Google Maps
                    </a>
                </div>
            `;
        }

        // Inisialisasi Map Utama (besar)
        function initMainMap() {
            const mapContainer = document.getElementById('map');

            if (!mapContainer || window.mainMapInitialized) return;

            if (mapContainer.offsetHeight === 0) {
                setTimeout(initMainMap, 300); // layout belum siap
                return;
            }

            const map = L.map('map').setView([latitude, longitude], 15);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: ''
            }).addTo(map);

            const marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup(getPopupHTML(), {
                    closeButton: false
                })
                .openPopup();

            marker.on('click', () => {
                window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
            });

            window.mainMapInitialized = true;
        }

        // Inisialisasi Map Popup
        function initPopupMap() {
            const popupMapContainer = document.getElementById('mapPopupContent');

            if (!popupMapContainer || window.popupMapInitialized) return;

            const map2 = L.map('mapPopupContent').setView([latitude, longitude], 15);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: ''
            }).addTo(map2);

            const marker2 = L.marker([latitude, longitude]).addTo(map2)
                .bindPopup(getPopupHTML(), {
                    closeButton: false
                })
                .openPopup();

            marker2.on('click', () => {
                window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
            });

            window.popupMapInitialized = true;
        }

        // Tampilkan popup map
        function showMapPopup() {
            document.getElementById('mapPopup').classList.remove('hidden');
            setTimeout(() => initPopupMap(), 200); // beri waktu render
        }

        // Sembunyikan popup map
        function hideMapPopup() {
            document.getElementById('mapPopup').classList.add('hidden');
        }

        // Event: DOM selesai dimuat
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => initMainMap(), 300);
        });

        // Event: Resize ulang (misal baru terlihat)
        window.addEventListener('resize', () => {
            if (!window.mainMapInitialized) initMainMap();
        });
    </script>

    <script>
        const shareBtn = document.getElementById('shareBtn');

        shareBtn.addEventListener('click', async () => {
            const shareData = {
                title: document.title,
                text: 'Check out this awesome product!',
                url: window.location.href
            }

            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                    console.log('Content shared successfully');
                } catch (err) {
                    console.error('Error sharing:', err);
                }
            } else {
                // fallback: contoh ke WhatsApp Web
                const whatsappUrl =
                    `https://wa.me/?text=${encodeURIComponent(shareData.text + ' ' + shareData.url)}`;
                window.open(whatsappUrl, '_blank');
            }
        });
    </script>
    <script>
        function diffForHumans(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);

            const intervals = [{
                    label: 'year',
                    seconds: 31536000
                },
                {
                    label: 'month',
                    seconds: 2592000
                },
                {
                    label: 'day',
                    seconds: 86400
                },
                {
                    label: 'hour',
                    seconds: 3600
                },
                {
                    label: 'minute',
                    seconds: 60
                },
                {
                    label: 'second',
                    seconds: 1
                }
            ];

            for (const interval of intervals) {
                const count = Math.floor(seconds / interval.seconds);
                if (count >= 1) {
                    return `${count} ${interval.label}${count > 1 ? '' : ''} ago`;
                }
            }

            return 'just now';
        }
        document.addEventListener('click', function(e) {
            const card = e.target.closest('.product-card');
            if (card) {
                const product = JSON.parse(card.getAttribute('data-product'));
                const modal = document.getElementById('productModal');
                const modalContent = document.getElementById('modalContent');

                modalContent.innerHTML = `
               <img src="${product.image ? `/${product.image}` : '/images/default-product.png'}"
                    class="w-full h-56 object-cover rounded-lg mb-4" />

                <div class="p-4 relative">
                    <!-- Nama toko di kanan atas untuk sm ke atas -->
                    <span class="xs:hidden sm:inline-block absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $shop->name }}
                    </span>

                    <!-- Harga & Diskon -->
                   ${
                    product.discount != 0
                        ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="mb-1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <del class="text-gray-500 mr-2">Rp ${parseFloat(product.price).toLocaleString()}</del>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <span class="text-sm text-red-600">${product.discount}% Off</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Rp ${parseFloat(product.price_final).toLocaleString()}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `
                        : `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <p class="text-2xl font-bold     text-purple-700 dark:text-purple-400 mb-1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    Rp ${parseFloat(product.price).toLocaleString()}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `
                    }

                    <!-- Nama toko di bawah harga untuk layar kecil -->
                    <span class="xs:inline-block sm:hidden mt-2 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $shop->name }}
                    </span>

                    <!-- Nama Produk -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mt-2 mb-1">${product.name}</p>

                    <!-- Deskripsi -->
                    <div class="text-gray-600 dark:text-zinc-300 text-sm">${product.description}</div>
                </div>
                `;
                modal.classList.remove('hidden');
            }

            // Tutup modal jika klik tombol X
            if (e.target.id === 'closeModal') {
                document.getElementById('productModal').classList.add('hidden');
            }

            // Tutup modal jika klik di luar konten modal
            if (e.target.id === 'productModal') {
                e.target.classList.add('hidden');
            }
        });
    </script>
    <script>
        const shopId = {{ $shop->id }};

        function loadComments(shopId) {
            $.ajax({
                url: `/comment/${shopId}`, // tanpa ?page
                method: 'GET',
                data: {
                    jumlah: 6
                },
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
                                <p>Reviewed in <time datetime="${comment.created_at}"><time>${diffForHumans(comment.created_at)}</time></p>
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

        function loadAllComments(shopId) {
            $.ajax({
                url: `/comment/${shopId}`,
                method: 'GET',
                success: function(response) {
                    const popupContainer = $('#all-ratings-container');
                    popupContainer.empty();

                    if (response.length > 0) {
                        response.forEach(comment => {
                            popupContainer.append(`
                        <article class="bg-white dark:bg-zinc-800 rounded-2xl p-5 mb-4 w-full max-w-2xl break-words border-b border-gray-200 dark:border-gray-700">
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
                                <p>Reviewed in <time datetime="${comment.created_at}">${diffForHumans(comment.created_at)}</time></p>
                            </footer>
                            <div class="text-gray-500 dark:text-gray-400 max-h-40 overflow-y-auto whitespace-pre-line break-words">${comment.comment || ''}</div>
                        </article>
                    `);
                        });
                    } else {
                        popupContainer.append(`<p class="text-center text-muted">No comments available.</p>`);
                    }

                    // Tampilkan popup
                    $('#commentPopup').removeClass('hidden');
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
                            <div class="rounded-2xl overflow-hidden  border border-transparent hover:border-purple-700 shadow-md hover:shadow-xl bg-white dark:bg-zinc-800 transition-colors duration-300 product-card" data-product='${JSON.stringify(product)}'>
                                <img src="${product.image ? `/${product.image}` : '/images/default-product.png'}"
                                    alt="${product.name}"
                                    onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';"
                                    class="w-full h-48 object-cover rounded-t-2xl" />
                                <div class="p-4 relative">
                                    <span class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                                        ${product.category.name || 'Product'}
                                    </span>
                                <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">
                                    ${
                                        product.discount != 0
                                        ? `<del class="text-gray-500 mr-2">Rp ${parseFloat(product.price).toLocaleString()}</del><span class="text-sm text-red-600">${product.discount }% Off</span><br>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Rp ${parseFloat(product.price_final).toLocaleString()}`
                                        : `Rp ${parseFloat(product.price).toLocaleString()}`
                                    }
                                    </p>
                                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">${product.name}</p>
                                    <div class="text-gray-600 dark:text-zinc-300 text-sm">${product.description}</div>
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
