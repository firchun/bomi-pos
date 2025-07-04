<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" />
    <title>@yield('title', 'Bomi POS - Aplikasi Kasir Terbaik')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('home2') }}/assets/svg/logo.svg" type="image/png" />

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', 'Bomi Pos adalah aplikasi dan web kasir untuk usaha retail dan restoran. Kelola penjualan, stok, laporan, dan pembayaran dengan mudah dan cepat.')">
    <meta name="keywords" content="@yield('meta-keywords', 'aplikasi kasir, web kasir, kasir restoran, kasir retail, aplikasi POS, sistem kasir online, software kasir, Bomi Pos')">
    <meta name="author" content="Bomi Pos">
    <meta name="robots" content="index, follow" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="@yield('meta-og-title', 'Bomi Pos - Aplikasi dan Web Kasir untuk Retail & Restoran')" />
    <meta property="og:description" content="@yield('meta-og-description', 'Gunakan Bomi Pos untuk mengelola penjualan, stok, keuangan, dan laporan usaha Anda secara efisien. Cocok untuk UMKM hingga bisnis skala besar.')" />
    <meta property="og:image" content="@yield('meta-og-image', asset('home2/assets/img/logo-bomipos.png'))" />
    <meta property="og:url" content="@yield('meta-og-url', url()->current())" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('meta-twitter-title', 'Bomi Pos - Solusi Kasir Modern untuk Bisnis Anda')" />
    <meta name="twitter:description" content="@yield('meta-twitter-description', 'Bomi Pos menyediakan sistem kasir online berbasis aplikasi dan web untuk mendukung operasional toko dan restoran Anda.')" />
    <meta name="twitter:image" content="@yield('meta-twitter-image', asset('home2/assets/img/logo-bomipos.png'))" />
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @layer utilities {
            .animate-scroll {
                animation: scroll-horizontal 20s linear infinite;
            }

            @keyframes scroll-horizontal {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-10%);
                }
            }
        }

        @media (max-width: 499px) {
            .xs\:block {
                display: block !important;
            }

            .xs\:inline-block {
                display: inline-block !important;
            }

            .xs\:flex {
                display: flex !important;
            }

            .xs\:hidden {
                display: none !important;
            }
        }

        @media (min-width: 500px) {

            .xs\:block,
            .xs\:inline-block,
            .xs\:flex {
                display: none !important;
            }
        }
    </style>
    <style>
        #spotlight {
            position: absolute;
            width: 300px;
            height: 300px;
            background-color: rgba(123, 0, 255, 0.3);
            /* atau gunakan warna gelap */
            border-radius: 9999px;
            pointer-events: none;
            mix-blend-mode: multiply;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease, left 0.05s linear, top 0.05s linear;
            opacity: 0;
            z-index: 5;
            filter: blur(80px);
            /* untuk efek cahaya halus */
        }
    </style>
    @stack('css')
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>

</head>

<body
    class="min-h-screen bg-[url('{{ asset('home2') }}/assets/svg/background.svg')] bg-cover bg-center scroll-smooth dark:bg-[url('{{ asset('home2') }}/assets/svg/background-dark.svg')] transition-colors duration-600">
    <!-- Loading Screen -->
    <div id="loading"
        class="flex items-center justify-center h-screen w-screen bg-white/50 backdrop-blur-lg z-50 fixed top-0 left-0 dark:bg-black/50 transition-colors duration-300">
        <div class="flex flex-col items-center">
            <!-- Logo -->
            <img src="{{ asset('home2') }}/assets/svg/logo.svg" alt="Logo" class="w-16 h-16 mb-4" />
            <p class="text-purple-700 font-medium text-sm">Loading...</p>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container mx-auto px-4 ">
        <!-- 🔵 Banner di atas header -->
        <header
            class="fixed top-0 left-0 w-full z-50 bg-white/2 backdrop-blur-lg p-6 dark:bg-black/10 transition-colors duration-300">
            <div class="container mx-auto flex justify-between items-center px-4">
                <a href="{{ url('/') }}">
                    <!-- Logo -->
                    <img src="{{ asset('home2') }}/assets/svg/logo.svg" alt="logo" class="h-10">
                </a>
                <!-- Navigation (Hidden on small screens) -->
                <nav class="space-x-10 hidden lg:flex ">

                    <!-- Dropdown -->
                    <div class="relative group">
                        <button
                            class="text-sm font-semibold text-purple-700 dark:text-white   @if (Request::is('bisnis*')) border border-purple-700 rounded-full px-4
                               shadow-sm shadow-purple-700 shadow-inner bg-white/40
                               @else hover:border hover:border-purple-700  hover:bg-white/40 hover:rounded-full hover:px-4  hover:shadow-sm hover:shadow-purple-700 hover:shadow-inner @endif">
                            @if (app()->getLocale() == 'en')
                                Bussiness
                            @else
                                Bisnis
                            @endif
                            <i class="bi bi-chevron-down"></i>
                        </button>

                        <!-- Invisible hover area untuk menahan dropdown -->
                        <div class="absolute top-full left-0 w-full h-6 group-hover:block"></div>

                        <div
                            class="absolute left-0 mt-2 hidden group-hover:flex bg-white dark:bg-zinc-800 shadow-lg rounded-lg p-3 lg:w-[600px] w-[400px] z-50 transition-all duration-200">
                            <div class="grid lg:grid-cols-3 grid-cols-2 gap-2">

                                <!-- F&B -->
                                <a href="{{ route('bisnis.fb') }}"
                                    class="block bg-purple-50 dark:bg-zinc-700 p-2 rounded-lg dark:hover:bg-zinc-800 hover:bg-purple-100 transition">
                                    <h3 class="text-md font-semibold text-purple-700 mb-2 dark:text-white">F&B</h3>
                                    <p class="text-[12px] text-gray-600 dark:text-gray-300">
                                        @if (app()->getLocale() == 'en')
                                            Suitable for restaurants, coffee shops, beverages, fast food, bakeries,
                                            and catering.
                                        @else
                                            Cocok untuk restoran, kedai kopi, minuman, cepat saji, toko roti, dan
                                            katering.
                                        @endif
                                    </p>
                                </a>

                                <!-- Retail -->
                                <a href="{{ route('bisnis.retail') }}"
                                    class="block bg-purple-50 dark:bg-zinc-700  p-2 rounded-lg dark:hover:bg-zinc-800 hover:bg-purple-100 transition">
                                    <h3 class="text-md font-semibold text-purple-700 mb-2 dark:text-white">Retail</h3>
                                    <p class="text-[12px] text-gray-600 dark:text-gray-300">
                                        @if (app()->getLocale() == 'en')
                                            Suitable for supermarkets, minimarkets, boutiques, clothing stores,
                                            electronics stores, convenience stores, and showrooms.
                                        @else
                                            Cocok untuk supermarket, minimarket, toko butik, toko baju, toko elektronik,
                                            toko serba ada, dan showroom.
                                        @endif

                                    </p>
                                </a>

                                <!-- Jasa -->
                                <a href="{{ route('bisnis.jasa') }}"
                                    class="block bg-purple-50 dark:bg-zinc-700  p-2 rounded-lg dark:hover:bg-zinc-800 hover:bg-purple-100 transition">
                                    <h3 class="text-md font-semibold text-purple-700 mb-2 dark:text-white">Jasa</h3>
                                    <p class="text-[12px] text-gray-600 dark:text-gray-300">
                                        @if (app()->getLocale() == 'en')
                                            Suitable for pet shops, salons, spas, beauty clinics, barbershops, travel
                                            agencies, guest houses, hotels, workshops, and laundry services.
                                        @else
                                            Cocok untuk pet shop, salon, spa, klinik kecantikan, barbershop, travel,
                                            guest
                                            house, hotel, bengkel, laundry.
                                        @endif
                                    </p>
                                </a>

                            </div>
                        </div>
                    </div>


                    <a href="{{ route('blogs') }}"
                        class="text-sm font-semibold text-purple-700 dark:text-white transition-all duration-300  
                        @if (Request::is('blogs*')) border border-purple-700 rounded-full px-4
                               shadow-sm shadow-purple-700 shadow-inner bg-white/40
                               @else hover:border hover:border-purple-700 hover:bg-white/40 hover:rounded-full hover:px-4  hover:shadow-sm hover:shadow-purple-700 hover:shadow-inner @endif">Blog</a>
                    <a href="{{ route('shop-page') }}"
                        class="text-sm font-semibold text-purple-700 dark:text-white transition-all duration-300  
                        @if (Request::is('shop-page') || Request::is('shop*')) border border-purple-700 rounded-full px-4
                               shadow-sm shadow-purple-700 shadow-inner bg-white/40
                               @else hover:border hover:border-purple-700 hover:bg-white/40 hover:rounded-full hover:px-4  hover:shadow-sm hover:shadow-purple-700 hover:shadow-inner @endif">Outlet</a>
                    <a href="{{ url('bomi-products') }}"
                        class="text-sm font-semibold text-purple-700 dark:text-white transition-all duration-300  
                        @if (Request::is('bomi-products')) border border-purple-700 rounded-full px-4
                               shadow-sm shadow-purple-700 shadow-inner bg-white/40
                               @else hover:border hover:border-purple-700  hover:bg-white/40 hover:rounded-full hover:px-4  hover:shadow-sm hover:shadow-purple-700 hover:shadow-inner @endif">
                        @if (app()->getLocale() == 'en')
                            Packages & Pricing
                        @else
                            Paket & Harga
                        @endif
                    </a>
                </nav>

                <!-- Login Button -->
                <div class="flex items-center space-x-5">
                    <button type="button" onclick="toggleSearchNavModal()"
                        class="text-lg font-semibold text-purple-700 dark:text-white transition-colors duration-300 ">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="#" id="toggleDark"
                        class="text-lg font-semibold text-purple-700 dark:text-white transition-colors duration-300 ">
                        <i id="darkIcon" class="bi bi-brightness-high"></i>
                    </a>
                    <form id="languageForm" action="{{ route('change.language') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="language" id="languageInput" value="">
                    </form>

                    <a href="#" id="toggleLanguage"
                        class="text-lg font-semibold text-purple-700 dark:text-white transition-colors duration-300 border border-purple-700 rounded-xl px-2">
                        <i id="langIcon" class="bi bi-translate "></i>
                        <span id="langText" class="text-sm">En</span>
                    </a>
                    @guest
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-purple-700  hidden  md:block dark:text-white transition-colors duration-300">
                            @if (app()->getLocale() == 'en')
                                Sign In
                            @else
                                Masuk
                            @endif
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-purple-700 text-white rounded-xl hidden md:block 
          hover:shadow-sm transform transition-transform  hover:scale-115 dark:bg-white dark:text-purple-700 transition-colors duration-300">
                            @if (app()->getLocale() == 'en')
                                Get Started
                            @else
                                Mulai Sekarang
                            @endif
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 bg-purple-700 text-white rounded-xl hidden md:block 
      hover:shadow-sm transform transition-transform  hover:scale-115 dark:bg-white dark:text-purple-700 transition-colors duration-300">
                            Dashboard <i class="bi bi-arrow-right-short"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm font-semibold text-red-500 hidden md:block dark:text-red-600 transition-colors duration-300">
                                @if (app()->getLocale() == 'en')
                                    Sign Out
                                @else
                                    Keluar
                                @endif
                            </button>
                        </form>
                    @endguest
                </div>

                <!-- Hamburger Menu for small screens -->
                <button
                    class="lg:hidden text-purple-700 bg-white/40 rounded-md p-2 dark:text-zinc-300 transition-colors"
                    id="hamburgerBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu (Hidden by default) -->
            <div class="lg:hidden hidden bg-white/70 px-10 py-4 rounded-md mt-4" id="mobileMenu">
                {{-- <a href="{{ url('/') }}"
                    class="block text-sm font-semibold text-purple-700 py-2 dark:text-zinc-800 transition-colors">Home</a> --}}
                <!-- Accordion: Bisnis -->
                <div x-data="{ open: false }" class="py-2">
                    <button @click="open = !open"
                        class="flex justify-between items-center w-full text-sm font-semibold text-purple-700 py-2">
                        @if (app()->getLocale() == 'en')
                            Bussiness
                        @else
                            Bisnis
                        @endif
                        <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" class="pl-4 pt-2 space-y-2">
                        <a href="{{ route('bisnis.fb') }}" class="block text-sm text-gray-700 py-1">F&B</a>
                        <a href="{{ route('bisnis.retail') }}" class="block text-sm text-gray-700 py-1">Retail</a>
                        <a href="{{ route('bisnis.jasa') }}" class="block text-sm text-gray-700 py-1">Jasa</a>
                    </div>
                </div>
                <a href="{{ route('blogs') }}"
                    class="block text-sm font-semibold text-purple-700 py-2 dark:text-zinc-800 transition-colors">Blog</a>
                <a href="{{ route('shop-page') }}"
                    class="block text-sm font-semibold text-purple-700 py-2 dark:text-zinc-800 transition-colors">Outlet</a>
                <a href="{{ url('bomi-products') }}"
                    class="block text-sm font-semibold text-purple-700 py-2 dark:text-zinc-800 transition-colors">
                    @if (app()->getLocale() == 'en')
                        Packages & Pricing
                    @else
                        Paket & Harga
                    @endif
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        class="block text-sm font-semibold text-purple-700 py-2 dark:text-zinc-800 transition-colors">
                        @if (app()->getLocale() == 'en')
                            Sign
                            In
                        @else
                            Masuk
                        @endif
                    </a>
                    <a href="{{ route('register') }}"
                        class="py-2  text-purple-700 mt-[20px] rounded-xl 
          hover:shadow-sm transform transition-transform  hover:scale-115  dark:text-zinc-800 transition-colors duration-300">
                        @if (app()->getLocale() == 'en')
                            Get Started
                        @else
                            Mulai Sekarang
                        @endif
                        <i class="bi bi-arrow-right-short"></i>
                    @else
                        <a href="{{ route('home') }}"
                            class="py-2  text-purple-700 mt-[20px] rounded-xl 
          hover:shadow-sm transform transition-transform  hover:scale-115  dark:text-zinc-800 transition-colors duration-300">
                            Dashboard <i class="bi bi-arrow-right-short"></i>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm font-semibold text-red-700   dark:text-red-400 transition-colors duration-300">
                                    @if (app()->getLocale() == 'en')
                                        Sign Out
                                    @else
                                        Keluar
                                    @endif
                                </button>
                            </form>
                        @endguest

                    </a>
            </div>
        </header>
    </div>
    @yield('content')
    @include('home-pages._searchNav')
    <div
        class="fixed bottom-10 right-10 flex flex-col items-end space-y-2 z-50 p-3 bg-white/20 dark:bg-black/10 backdrop-blur-sm rounded-full">
        <a href="https://wa.me/682248493036" target="_blank"
            class="group flex items-center gap-2 px-5 py-3 bg-green-500 text-white font-semibold rounded-full shadow-lg hover:bg-green-600 transition-all duration-800 overflow-hidden">
            <i class="bi bi-whatsapp text-4xl"></i>
            <span
                class="max-w-0 opacity-0 overflow-hidden group-hover:max-w-xs group-hover:opacity-100 transition-all duration-600 ease-in-out whitespace-nowrap">
                WhatsApp
            </span>
        </a>
    </div>

    <footer class="bg-[#1B0054] text-white px-8 py-12 dark:bg-black/50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-5 gap-8 text-sm ">

            <!-- Logo & Description -->
            <div class="space-y-4 col-span-1">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('home2') }}/assets/svg/logo.svg" alt="Logo" class="h-10">

                </div>
                <p class="text-gray-400 hover:text-white">
                    @if (app()->getLocale() == 'en')
                        We’ve gathered the best features to support your cashier operations.
                        Choose the perfect solution for your business quickly and easily!
                    @else
                        Kami telah mengumpulkan fitur-fitur terbaik untuk mendukung operasional kasir Anda.
                        Pilih solusi yang paling tepat untuk bisnis Anda dengan cepat dan mudah!
                    @endif
                </p>
            </div>

            <!-- Services -->
            <div>
                <h3 class="font-bold mb-2">Services</h3>
                <ul class="space-y-1 ">
                    <li><a href="{{ route('bomi-products.home') }}"
                            class="text-gray-400 hover:text-white">Pricing</a></li>
                    <li><a href="{{ route('bomi-products.home') }}" class="text-gray-400 hover:text-white">Bomi
                            Product</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Help Docs</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Terms and Conditions</a></li>
                </ul>
            </div>

            <!-- Features -->
            <div>
                <h3 class="font-bold mb-2">Features</h3>
                <ul class="space-y-1">
                    <li><a href="#" class="text-gray-400 hover:text-white">POS Application</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Dasboard Sales</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Manajemen Resto</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Ingredient Manajemen</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Financial Report</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Sales Report</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div>
                <h3 class="font-bold mb-2">Account</h3>
                <ul class="space-y-1 ">
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Sign In</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white">Sign Up</a></li>
                    <li><a href="{{ route('password.request') }}" class="text-gray-400 hover:text-white">Reset
                            Password</a></li>
                </ul>
            </div>
            <!-- Newsletter -->
            <div>
                <h3 class="font-bold mb-2">Stay in Touch</h3>
                <p class="text-[#D1CDE6] mb-2">
                    subscribe now for exclusive insights and offers!
                </p>
                <div class="space-y-2">
                    <input type="email" placeholder="Email Address"
                        class="w-full px-4 py-2 rounded-md text-black-300 border border-white rounded-xl" />
                    <button
                        class="w-full py-4 bg-white/70 text-[#1B0054] font-semibold py-2 rounded-xl hover:bg-white transition duration-300">
                        Subscribe Now
                    </button>
                </div>
            </div>
        </div>
        <!-- Bottom copyright -->
        <div class="mt-12 text-center text-xs text-[#D1CDE6]">
            © {{ date('Y') }} Bomi POS . All Rights Reserved.
        </div>
    </footer>
    @stack('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggleBtn = document.getElementById("toggleLanguage");
            const langInput = document.getElementById("languageInput");
            const langText = document.getElementById("langText");
            const form = document.getElementById("languageForm");

            // Simpan status bahasa di localStorage
            let currentLang = localStorage.getItem("lang") || "{{ app()->getLocale() }}";

            function updateUI() {
                langText.textContent = currentLang === "en" ? "Id" : "En";
            }

            updateUI();

            toggleBtn.addEventListener("click", (e) => {
                e.preventDefault();

                const newLang = currentLang === "en" ? "id" : "en";
                langInput.value = newLang;
                localStorage.setItem("lang", newLang);
                form.submit();
            });
        });
    </script>
    <script>
        // review
        let selectedRating = 0;

        function toggleReviewModal() {
            const modal = document.getElementById('reviewModal');
            modal.classList.toggle('hidden');
        }

        function setRating(rating) {
            selectedRating = rating;
            const stars = document.querySelectorAll('#starContainer i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star-fill', 'text-yellow-400');
                } else {
                    star.classList.remove('bi-star-fill', 'text-yellow-400');
                    star.classList.add('bi-star-fill');
                }
            });
        }

        function submitReview() {
            const review = document.getElementById('reviewText').value;
            console.log('Rating:', selectedRating);
            console.log('Review:', review);

            // TODO: Kirim ke backend di sini pakai AJAX jika perlu

            toggleReviewModal(); // Tutup modal
            // Reset
            setRating(0);
            document.getElementById('reviewText').value = '';
        }
        // search
        function toggleReviewModal() {
            const modalReview = document.getElementById("reviewModal");
            modalReview.classList.toggle("hidden");
            modalReview.classList.toggle("flex");
        }

        function toggleSearchModal() {
            const modal = document.getElementById("searchModal");
            modal.classList.toggle("hidden");
            modal.classList.toggle("flex");
        }

        function toggleSearchNavModal() {
            const modalNav = document.getElementById("searchNavModal");
            modalNav.classList.toggle("hidden");
            modalNav.classList.toggle("flex");
        }
        // Loading Screen
        window.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.getElementById("loading").style.display = "none";
                document.getElementById("content").classList.remove("hidden");
            }, 500); // 2 detik
        });
        // slider
        function slider() {
            return {
                images: [
                    'https://placehold.co/588x384?text=1',
                    'https://placehold.co/588x384?text=2',
                    'https://placehold.co/588x384?text=3'
                ],
                current: 0,
                start() {
                    setInterval(() => {
                        this.current = (this.current + 1) % this.images.length;
                    }, 3000);
                }
            }
        }
        //darkmode
        const toggleDark = document.getElementById('toggleDark');
        const icon = document.getElementById('darkIcon');

        // Cek dan terapkan mode saat halaman dimuat
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
            icon.classList.remove('bi-brightness-high');
            icon.classList.add('bi-moon');
        } else {
            document.documentElement.classList.remove('dark');
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-brightness-high');
        }

        toggleDark.addEventListener('click', function(e) {
            e.preventDefault();
            document.documentElement.classList.toggle('dark');

            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                icon.classList.remove('bi-brightness-high');
                icon.classList.add('bi-moon');
            } else {
                localStorage.setItem('theme', 'light');
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-brightness-high');
            }
        });
        // Toggle mobile menu visibility
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        hamburgerBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        //spotlight
        const hero = document.getElementById('hero');
        const spotlight = document.getElementById('spotlight');

        let mouseX = 0;
        let mouseY = 0;
        let animationFrameId;

        function updateSpotlight() {
            spotlight.style.left = `${mouseX}px`;
            spotlight.style.top = `${mouseY}px`;
            spotlight.style.opacity = '1';
            animationFrameId = requestAnimationFrame(updateSpotlight);
        }

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            mouseX = e.clientX - rect.left;
            mouseY = e.clientY - rect.top;

            if (!animationFrameId) {
                updateSpotlight();
            }
        });

        hero.addEventListener('mouseleave', () => {
            spotlight.style.opacity = '0';
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
        });
        //tab 
        const tabMobile = document.getElementById('tab-mobile');
        const tabWeb = document.getElementById('tab-web');
        const deviceImage = document.getElementById('device-image');

        tabMobile.addEventListener('click', () => {
            deviceImage.src = '{{ asset('home2') }}/assets/img/app-android.jpg';
            tabMobile.classList.add('bg-fuchsia-300');
            tabMobile.classList.add('dark:bg-neutral-500/50');
            tabWeb.classList.remove('dark:bg-neutral-500/50');
            tabWeb.classList.remove('bg-fuchsia-300');
        });

        tabWeb.addEventListener('click', () => {
            deviceImage.src = '{{ asset('home2') }}/assets/img/app-web.png';
            tabWeb.classList.add('dark:bg-neutral-500/50');
            tabMobile.classList.remove('dark:bg-neutral-500/50');
            tabWeb.classList.add('bg-fuchsia-300');
            tabMobile.classList.remove('bg-fuchsia-300');
        });
    </script>
</body>

</html>
