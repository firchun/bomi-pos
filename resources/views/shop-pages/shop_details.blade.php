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
    {{-- <section class="section">
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
    </section> --}}
    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Outlet / {{ $shop->name }}
        </section>
        <!-- images -->
        <section class="mt-10 flex justify-center"
        x-data="{ 
          activeIndex: 0, 
          images: ['sample.png', 'sample.png', 'sample.png'],
          baseUrl: '{{ asset('home2/assets/img') }}' 
        }">
 <div class="relative w-[988px] h-96">
   <!-- Background Left -->
   <template x-for="(img, i) in images" :key="i">
     <img x-show="activeIndex !== i" 
          :src="`${baseUrl}/${img}`"
          class="w-[494px] h-80 absolute left-0 top-[29px] rounded-2xl filter blur-sm opacity-50 transition-all duration-500"
          alt="Gambar Belakang Kiri" />
   </template>

   <!-- Background Right -->
   <template x-for="(img, i) in images" :key="i">
     <img x-show="activeIndex !== i" 
          :src="`${baseUrl}/${img}`"
          class="w-[494px] h-80 absolute right-0 top-[29px] rounded-2xl filter blur-sm opacity-50 transition-all duration-500"
          alt="Gambar Belakang Kanan" />
   </template>

   <!-- Gambar Utama -->
   <img :src="`${baseUrl}/${images[activeIndex]}`"
        class="w-[588px] h-96 absolute left-1/2 top-0 -translate-x-1/2 rounded-2xl z-10 shadow-lg transition-all duration-500"
        alt="Gambar Utama Tengah" />

   <!-- Navigasi -->
   <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-4 z-20">
     <template x-for="(img, index) in images" :key="index">
       <button @click="activeIndex = index"
               :class="{ 'bg-purple-700': activeIndex === index, 'bg-gray-300': activeIndex !== index }"
               class="w-3 h-3 rounded-full transition-all duration-300"></button>
     </template>
   </div>
 </div>
</section>
        <!-- detail shop -->
        <section class="mt-[50px]">
            <div class="w-full  flex flex-col md:flex-row gap-4">
                <!-- MAP -->
                <div
                    class="relative w-full md:w-1/2 h-100 rounded-2xl overflow-hidden shadow-md bg-white/30 border-2 border-white backdrop-blur-xl dark:border-neutral-800 transition-colors duration-300">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63305.99282765082!2d140.38573601755773!3d-8.519153991693504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4412b6fb293a1d%3A0x3eeb6cc898dc5b68!2sMerauke%2C%20Papua!5e0!3m2!1sen!2sid!4v1683982358256!5m2!1sen!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <!-- Tombol Route -->

                </div>

                <!-- INFO TOKO -->
                <div
                    class="w-full md:w-1/2 bg-white/30 border-2 border-white backdrop-blur-xl rounded-2xl p-6 shadow-md flex flex-col justify-between dark:bg-zinc-900/50 dark:border-black transition-colors duration-300">
                    <div>
                        <h3
                            class="text-3xl font-extrabold text-fuchsia-700 font-['Lexend'] dark:text-white transition-colors duration-300">
                            ANGKRINGAN FIRMAN</h3>
                        <p
                            class="text-neutral-600 text-xl font-medium font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300">
                            Menjual jajanan angkringan seperti sate-satean, nasi kucing, dll.
                        </p>
                        <p
                            class="text-neutral-600 text-xl font-medium font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300">
                            Open Hours: 05:00 PM - 10:00 PM
                        </p>
                        <p
                            class="text-neutral-600 text-xl font-medium font-['Lexend'] mt-2 dark:text-neutral-300 transition-colors duration-300">
                            Address: Jl Gak Merauke
                        </p>
                    </div>

                    <!-- Share Buttons -->
                    <div class="flex gap-4 mt-6">
                        <a href="https://wa.me/?text=Kunjungi%20Angkringan%20Firman" target="_blank"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-xl text-xl font-medium font-['Lexend']">
                            Share to Whatsapp
                        </a>
                        <button
                            class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl text-xl font-medium font-['Lexend']">
                            Share
                        </button>
                        <a href="https://www.google.com/maps" target="_blank"
                            class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl text-xl font-medium font-['Lexend']">
                            Route Maps
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!--tab category -->
        <section class="mt-[30px] flex items-center justify-between">
            <div class="bg-white  dark:bg-gray-800 p-4 rounded-3xl w-fit mx-auto">
                <div class="flex space-x-6 text-purple-700 dark:text-purple-300 font-semibold text-lg">
                    <!-- Tab Aktif -->
                    <button class="bg-purple-300 text-purple-800 px-4 py-2 rounded-2xl dark:bg-purple-700 dark:text-white">
                        All Category
                    </button>

                    <!-- Tab Lainnya -->
                    <button class="hover:text-purple-900 dark:hover:text-white">Foods</button>
                    <button class="hover:text-purple-900 dark:hover:text-white">Drinks</button>
                    <button class="hover:text-purple-900 dark:hover:text-white">Snacks</button>
                    <button class="hover:text-purple-900 dark:hover:text-white">Others</button>
                </div>
            </div>
        </section>
        <!-- Search Section (Trigger) -->
        <section
            class="mt-[30px] flex space-x-4 items-center justify-between bg-white/30 dark:bg-zinc-800/70 rounded-2xl p-5 cursor-pointer"
            onclick="toggleSearchModal()">
            <input type="text"
                class="p-3 border border-purple-700 rounded-2xl w-full bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800 transition-colors duration-300 cursor-pointer"
                placeholder="Search Product" readonly />
        </section>

        <!-- Modal Overlay -->
        <div id="searchModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
            <!-- Modal Box -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-2xl p-6 mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Search Product</h2>
                    <button onclick="toggleSearchModal()" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-white">
                        ✕
                    </button>
                </div>
                <input type="search"
                    class="w-full p-3 border border-purple-700 rounded-2xl text-purple-700 bg-white dark:bg-zinc-800 dark:text-white transition-colors duration-300"
                    placeholder="Type to search..." autofocus />
                <!-- Optional: Results -->
                <!-- Optional: Results -->
                <div class="mt-6 space-y-3">
                    <!-- Result item -->
                    <div
                        class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                        <div>
                            <div class="text-zinc-800 dark:text-white font-medium">Nasi Goreng Spesial</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet: Angkringan Firman</div>
                        </div>
                        <div class="text-purple-700 font-semibold text-sm">Rp 18.000</div>
                    </div>

                    <!-- Result item -->
                    <div
                        class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                        <div>
                            <div class="text-zinc-800 dark:text-white font-medium">Es Teh Manis</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet: Angkringan Firman</div>
                        </div>
                        <div class="text-purple-700 font-semibold text-sm">Rp 5.000</div>
                    </div>

                    <!-- Result item -->
                    <div
                        class="flex items-center justify-between p-3 bg-zinc-100 dark:bg-zinc-800 rounded-xl transition hover:bg-purple-100 dark:hover:bg-purple-900 cursor-pointer">
                        <div>
                            <div class="text-zinc-800 dark:text-white font-medium">Mie Rebus Telur</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">Outlet: Angkringan Firman</div>
                        </div>
                        <div class="text-purple-700 font-semibold text-sm">Rp 12.000</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- list outlet -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[50px] px-4 container mx-auto">


            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Foods
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Nasi Kucing</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>
            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Foods
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Nasi Kucing</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>
            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Foods
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Nasi Kucing</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>
            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Drinks
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Es Teh</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>
            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Drinks
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Es Teh</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>
            <div
                class="max-w-xs rounded-2xl overflow-hidden shadow-md bg-white dark:bg-zinc-800 transition-colors duration-300">
                <!-- Gambar -->
                <img src="{{ asset('home2') }}/assets/img/sample.png" alt="Nasi Kucing"
                    class="w-full h-48 object-cover rounded-t-2xl" />

                <!-- Konten -->
                <div class="p-4 relative">
                    <!-- Badge kategori -->
                    <span
                        class="absolute top-4 right-4 bg-purple-100 text-purple-700 dark:bg-purple-800/30 dark:text-purple-300 text-sm font-medium px-3 py-1 rounded-full">
                        Drinks
                    </span>

                    <!-- Harga -->
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-1">Rp 5.000</p>

                    <!-- Judul -->
                    <p class="text-lg font-semibold text-purple-700 dark:text-white mb-1">Es Teh</p>

                    <!-- Deskripsi -->
                    <p class="text-gray-600 dark:text-zinc-300 text-sm">
                        Ini Nasi kucing dengan isian teri dan tempe dengan racikan khas jawa timur
                    </p>
                </div>
            </div>

        </section>
        <!-- pagination -->
        <div class="flex justify-center my-10">
            <nav
                class="inline-flex items-center rounded-xl shadow-sm bg-white dark:bg-zinc-800 px-2 py-1 space-x-1 transition-colors duration-300">
                <!-- Previous Button -->
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    Previous
                </a>

                <!-- Page Numbers -->
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700 transition">
                    1
                </a>
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    2
                </a>
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    3
                </a>
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    ...
                </a>
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    100
                </a>
                <!-- Next Button -->
                <a href="#"
                    class="px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md transition">
                    Next
                </a>
            </nav>
        </div>


    </div>
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
