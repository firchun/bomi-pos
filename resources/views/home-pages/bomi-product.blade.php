@extends('layouts.home2')

@section('title', 'Harga dan Paket Bomi POS')
@section('meta-title', 'Harga dan Paket Bomi POS' . ' | Bomi POS')
@section('meta-description', 'Langganan bomi pos dan dapatkan penwarangan terbaru tentang produk kami.')
@section('meta-keywords',
    'Harga dan Paket Bomi POS, Bomi POS, harga , price, paket, subscription, akun bomi pos,
    langganan bomi pos')

@section('meta-og-title', 'Harga dan Paket Bomi POS' . ' | Bomi POS')
@section('meta-og-description', 'Langganan bomi pos dan dapatkan penwarangan terbaru tentang produk kami.')
@section('meta-og-url', url()->current())

@section('content')
    <div class="container mx-auto px-4 mt-[110px]">
        <!-- broadcom -->
        @include('home-pages.components.breadcrumbs', [
            'title' => App::getLocale() == 'en' ? 'Price & Packages' : 'Paket & Harga',
        ])
        <!-- hero -->
        @include('home-pages.components.hero_device')
        <!-- pricing -->
        <section class="mt-20 container mx-auto px-4 h-full" x-data="{ tab: 'economical' }">
            <!-- Heading -->
            <div
                class="text-center text-zinc-700 text-3xl font-extrabold font-['Lexend'] mb-5 dark:text-white transition-colors duration-300">
                @if (App::getLocale() == 'en')
                    Bomi Products for Your Smarter
                    <br>Cashier System
                @else
                    Bomi Produk untuk Sistem Kasir Anda yang <br>Lebih Cerdas
                @endif
            </div>

            <div
                class="text-center justify-start text-neutral-500 dark:text-neutral-200 text-lg font-medium font-['Lexend'] mb-5">
                @if (App::getLocale() == 'en')
                    Complete POS solution from Bomi for fast transactions, <br />organized stock, and automated reports
                @else
                    Solusi POS lengkap dari Bomi untuk transaksi cepat, <br />stok terorganisir, dan laporan otomatis
                @endif
            </div>

            <!-- Tabs -->
            <div class="flex justify-center items-center gap-4 mb-8">
                <div
                    class="bg-white rounded-3xl px-3 py-2 flex gap-4 items-center dark:bg-neutral-800 transition-colors duration-300">

                    <!-- Tab: Account -->
                    <div id="tab-account" @click="tab = 'economical'"
                        :class="tab === 'economical' ? 'bg-fuchsia-300 dark:bg-neutral-500/50' : 'bg-transparent'"
                        class="tab-button rounded-2xl px-4 py-2 cursor-pointer flex items-center gap-2 transition-colors duration-300">

                        <span
                            class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                            @if (App::getLocale() == 'en')
                                Economical
                            @else
                                Ekonomis
                            @endif
                        </span>
                    </div>
                    <!-- Tab: Devices -->
                    <div id="tab-devices" @click="tab = 'monthly'"
                        :class="tab === 'monthly' ? 'bg-fuchsia-300 dark:bg-neutral-500/50' : 'bg-transparent'"
                        class="tab-button rounded-2xl px-4 py-2 cursor-pointer flex items-center gap-2 transition-colors duration-300">

                        <span
                            class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                            @if (App::getLocale() == 'en')
                                Monthly
                            @else
                                Bulanan
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!--price -->
            <div class="flex justify-center py-10 px-10 mx-auto mb-10 transition duration-300"
                x-show="tab === 'economical'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
                    <!-- Free Account -->
                    @foreach ($packagesAccountEcomnomical as $item)
                        <div
                            class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between w-full sm:w-3/4 hover:scale-105 border border-transparent border hover:ring-purple-700  transition-transform duration-300">
                            <!-- Konten Atas -->
                            <div>
                                <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300"{{ $item->name }}</h3>
                                    <div class="flex align-star mt-2">
                                        <p class="text-6xl font-bold text-white">
                                            {{ $item->price == 0 ? 'FREE' : $item->price }}</p>
                                        <span class="ml-2 text-sm font-bold text-neutral-200">/ {{ $item->type }}</span>
                                    </div>
                                    <hr class="my-4 border-white border-t-2 ">
                                    <ul class="text-neutral-900 dark:text-neutral-200 font-semibold space-y-2 text-lg">
                                        @foreach ($item->features as $feat)
                                            <li><i class="bi bi-check-square-fill text-white"></i> {{ $feat }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                            @guest
                                <a href="{{ route('register') }}"
                                    class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white hover:text-purple-700 transition duration-300 text-center">
                                    @if (App::getLocale() == 'en')
                                        Get Started
                                    @else
                                        Mulai Sekarang
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('home') }}"
                                    class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white hover:text-purple-700 transition duration-300 text-center">
                                    @if (App::getLocale() == 'en')
                                        Order Now
                                    @else
                                        Pesan Sekarang
                                    @endif
                                </a>
                            @endguest
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- {{ $packages }} --}}
            <div class="flex justify-center py-10 px-10 mx-auto mb-10 transition duration-300" x-show="tab === 'monthly'">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
                    <!-- Free Account -->
                    @foreach ($packagesAccountMonthly as $item)
                        <div
                            class="bg-gradient-to-br from-fuchsia-400 to-purple-400 dark:from-fuchsia-700/30 dark:to-purple-800/30 rounded-3xl p-6 h-full text-white  flex flex-col justify-between w-full sm:w-3/4 hover:scale-105 border border-transparent border hover:ring-purple-700  transition-transform duration-300">
                            <!-- Konten Atas -->
                            <div>
                                <h3 class="text-xl font-bold text-purple-700 dark:text-purple-300"{{ $item->name }}</h3>
                                    <div class="flex align-star mt-2">
                                        <p class="text-6xl font-bold text-white">
                                            {{ $item->price == 0 ? 'FREE' : $item->price }}</p>
                                        <span class="ml-2 text-sm font-bold text-neutral-200">/ {{ $item->type }}</span>
                                    </div>
                                    <hr class="my-4 border-white border-t-2 ">
                                    <ul class="text-neutral-900 dark:text-neutral-200 font-semibold space-y-2 text-lg">
                                        @foreach ($item->features as $feat)
                                            <li><i class="bi bi-check-square-fill text-white"></i> {{ $feat }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                            @guest
                                <a href="{{ route('register') }}"
                                    class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white hover:text-purple-700 transition duration-300 text-center">
                                    @if (App::getLocale() == 'en')
                                        Get Started
                                    @else
                                        Mulai Sekarang
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('home') }}"
                                    class="w-full bg-purple-700 py-3  mt-4 rounded-2xl font-bold text-xl hover:bg-white hover:text-purple-700 transition duration-300 text-center">
                                    @if (App::getLocale() == 'en')
                                        Order Now
                                    @else
                                        Pesan Sekarang
                                    @endif
                                </a>
                            @endguest
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="container mx-auto px-4 my-[50px] max-w-5xl">
            <h2 class="text-3xl font-bold text-center text-purple-900 dark:text-purple-200 mb-2">
                @if (App::getLocale() == 'en')
                    Bomi POS Devices
                @else
                    Perangkat Kasir Bomi POS
                @endif
            </h2>
            <p class="text-center text-gray-500 dark:text-gray-400 mb-8">
                @if (App::getLocale() == 'en')
                    Devices to support your cashier system, from thermal printers, barcode scanners, to cash drawers.
                @else
                    Perangkat untuk dukung sistem kasir Anda, mulai dari printer thermal, barcode scanner, hingga cash
                    drawer.
                @endif
            </p>
            <!-- Alpine Modal Container -->
            <div x-data="{ openModal: false, selected: null, packages: {{ Js::from($packages) }} }">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                    <template x-for="(item, index) in packages" :key="index">
                        <div @click="selected = item; openModal = true"
                            class="cursor-pointer bg-white dark:bg-black/20 rounded-2xl p-4 shadow hover:shadow-lg dark:shadow-purple-900 transition duration-300">
                            <img :src="item.image_url" alt="" class="w-full h-70  object-cover" />
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400" x-text="item.tag"></div>
                            <div class="font-bold text-lg text-purple-700 dark:text-white" x-text="item.name"></div>
                            <div class="text-purple-700 dark:text-purple-600 font-semibold"
                                x-text="`Rp ${Number(item.price).toLocaleString()}`"></div>
                        </div>
                    </template>
                </div>

                <!-- Modal -->
                <div x-show="openModal"
                    class="fixed inset-0  bg-black/40 dark:bg-black/0 backdrop-blur-sm flex items-center justify-center z-50"
                    x-transition>
                    <div class="bg-white dark:bg-black/90 dark:backdrop-blur-2xl rounded-2xl shadow-xl max-w-4xl w-full overflow-hidden relative"
                        @click.away="openModal = false">
                        <button class="absolute top-2 right-2 text-gray-500" @click="openModal = false">✕</button>
                        <div class="flex flex-col md:flex-row gap-6 p-6">
                            <div class="md:w-3/4">
                                <img :src="selected?.image_url" alt="" class="w-full h-auto object-contain">
                            </div>
                            <div class="md:w-1/2">
                                <div class="text-sm dark:text-white text-blue-600 font-medium" x-text="selected?.tag">
                                </div>
                                <h2 class="text-xl font-bold dark:text-white mt-1" x-text="selected?.name"></h2>
                                <div class="dark:text-white text-lg font-semibold bg-gray-100 dark:bg-gray-700 p-2 mt-2 rounded"
                                    x-text="`Rp ${Number(selected?.price).toLocaleString()}`"></div>

                                <ul class="mt-3 space-y-1 text-sm">
                                    <template x-for="feature in selected?.features">
                                        <li class="flex items-center gap-2 text-purple-700 dark:text-white">
                                            ✅ <span x-text="feature"></span>
                                        </li>
                                    </template>
                                </ul>
                                <div class="mt-4">
                                    <a :href="selected?.link_direct" target="_blank"
                                        class="block w-full text-center bg-purple-700 text-white dark:bg-white/80 dark:hover:bg-white dark:text-black py-4 rounded-xl hover:bg-purple-900">
                                        <i class="bi bi-whatsapp text-xl"></i>
                                        @if (App::getLocale() == 'en')
                                            Order
                                            Now
                                        @else
                                            Pesan Sekarang
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('home-pages.components.hero2', [
            'class' => 'mb-10',
        ])
        <section class="container mx-auto px-4 mb-10">
            <div class="max-w-2xl w-full mx-auto">
                <h2 class="text-3xl font-bold text-center text-purple-900 dark:text-purple-200 mb-2">
                    @if (App::getLocale() == 'en')
                        Frequently Asked Questions
                    @else
                        Pertanyaan yang Sering Diajukan
                    @endif
                </h2>
                <p class="text-center text-gray-500 dark:text-gray-400 mb-8">
                    @if (App::getLocale() == 'en')
                        Answered all frequently asked questions, Still confused? <br />
                        feel free contact with us
                    @else
                        Jawab semua pertanyaan yang sering diajukan, Masih bingung? <br />
                        silakan hubungi kami
                    @endif
                </p>

                <div x-data="{ selected: null }" class="space-y-4">

                    <!-- FAQ Item -->
                    @if (App::getLocale() == 'en')
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 1 ? selected = 1 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Do I get free updates?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 1" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                Yes, Bomi POS provides free updates regularly to ensure better performance, security
                                improvements, and new features for your cafe or retail operations.
                            </div>
                        </div>
                    @else
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 1 ? selected = 1 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Apakah saya mendapatkan pembaruan gratis?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 1" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                Ya, Bomi POS menyediakan pembaruan gratis secara berkala untuk memastikan kinerja yang lebih
                                baik, peningkatan keamanan, dan fitur baru untuk operasional kafe atau ritel Anda.
                            </div>
                        </div>
                    @endif

                    <!-- FAQ Item -->
                    @if (App::getLocale() == 'en')
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 2 ? selected = 2 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                What does the number of "Projects" refer to?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 2" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                In Bomi POS, "Projects" refer to the different outlets or business branches you manage using
                                a
                                single account — such as multiple cafes, kiosks, or stores.
                            </div>
                        </div>
                    @else
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 2 ? selected = 2 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Apa yang dimaksud dengan jumlah "Proyek"?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 2" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                Di Bomi POS, "Proyek" mengacu pada berbagai outlet atau cabang bisnis yang Anda kelola
                                menggunakan
                                satu akun — seperti beberapa kafe, kios, atau toko.
                            </div>
                        </div>
                    @endif

                    <!-- FAQ Item -->
                    @if (App::getLocale() == 'en')
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 3 ? selected = 3 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Can I upgrade to a higher plan?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 3" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                Absolutely! You can upgrade to the Pro plan anytime to access advanced features such as
                                financial reports, ingredient tracking, and detailed sales analytics.
                            </div>
                        </div>
                    @else
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 3 ? selected = 3 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Bisakah saya meningkatkan ke paket yang lebih tinggi?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 3" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                Tentu saja! Anda dapat meningkatkan ke paket Pro kapan saja untuk mengakses fitur lanjutan
                                seperti laporan keuangan, pelacakan bahan, dan analitik penjualan terperinci.
                            </div>
                        </div>
                    @endif

                    <!-- FAQ Item -->
                    @if (App::getLocale() == 'en')
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 4 ? selected = 4 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                What does "Unlimited Projects" mean?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 4" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                "Unlimited Projects" means you can create and manage as many outlets or stores as you want
                                within the platform, without any additional charges per location.
                            </div>
                        </div>
                    @else
                        <div class="border-b border-gray-300 dark:border-gray-600">
                            <button @click="selected !== 4 ? selected = 4 : selected = null"
                                class="w-full text-left py-4 flex justify-between items-center font-semibold text-gray-800 dark:text-white">
                                Apa yang dimaksud dengan "Proyek Tak Terbatas"?
                                <span class="text-2xl">+</span>
                            </button>
                            <div x-show="selected === 4" x-collapse class="text-gray-600 dark:text-gray-300 pb-4">
                                "Proyek Tak Terbatas" berarti Anda dapat membuat dan mengelola sebanyak mungkin outlet atau
                                toko yang Anda inginkan dalam platform, tanpa biaya tambahan per lokasi.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event listener untuk tombol "Baca Selengkapnya"
            document.querySelectorAll('.view-product').forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description') ||
                        'No description available';
                    const price = parseFloat(this.getAttribute('data-price')).toLocaleString();
                    const photo = this.getAttribute('data-photo') ?
                        `/storage/${this.getAttribute('data-photo')}` :
                        '/images/default-product.png';
                    const phone = this.getAttribute('data-phone');

                    document.getElementById('modalProductName').textContent = name;
                    document.getElementById('modalProductDescription').textContent = description;
                    document.getElementById('modalProductPrice').textContent = price;
                    document.getElementById('modalProductImage').setAttribute('src', photo);

                    if (phone) {
                        const waLink =
                            `https://wa.me/${phone}?text=Halo,%20saya%20tertarik%20dengan%20produk%20${name}`;
                        document.getElementById('modalProductWhatsapp').setAttribute('href',
                            waLink);
                        document.getElementById('modalProductWhatsapp').style.display = 'block';
                    } else {
                        document.getElementById('modalProductWhatsapp').style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
