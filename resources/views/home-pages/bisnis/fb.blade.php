@extends('layouts.home2')

@section('content')
    @include('home-pages.components.hero2', [
        'class' => 'mt-[110px]',
    ])
    <section class=" mt-4 container mx-auto px-4 h-full">
        <!-- Heading -->
        <div
            class="text-center text-zinc-700 text-3xl font-extrabold font-['Lexend'] mb-10 dark:text-white transition-colors duration-300">
            @if (app()->getLocale() == 'en')
                Manage your cashier anytime, <br />
                anywhere, on any device.
            @else
                Kelola kasir Anda kapan saja, <br />
                di mana saja, di perangkat apa pun.
            @endif
        </div>

        <!-- Tabs -->
        <div class="flex justify-center items-center gap-4 mb-8">
            <div
                class="bg-white rounded-3xl px-3 py-2 flex gap-4 items-center dark:bg-neutral-800  transition-colors duration-300">
                <!-- Tab: Mobile -->
                <div id="tab-mobile"
                    class="tab-button bg-fuchsia-300 rounded-2xl px-4 py-2 cursor-pointer flex items-center gap-2 dark:bg-neutral-500/50 transition-colors duration-300">
                    <i class="bi bi-phone text-purple-700 text-xl dark:text-white transition-colors duration-300"></i>
                    <span
                        class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">Mobile
                        App</span>
                </div>

                <!-- Tab: Web -->
                <div id="tab-web" class="tab-button cursor-pointer flex items-center gap-2 px-4 py-2 rounded-2xl">
                    <i class="bi bi-laptop text-purple-700 text-xl dark:text-white transition-colors duration-300"></i>
                    <span
                        class="text-purple-700 text-xl font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">Web
                        App</span>
                </div>
            </div>
        </div>

        <!-- Device mockup image -->
        <div class="flex justify-center mb-12 h-auto">
            <div class="relative w-full max-w-4xl">
                <img id="device-image" src="{{ asset('home2') }}/assets/img/app-android.jpg" alt="App mockup"
                    class="w-full h-auto mx-auto transition duration-300" />
            </div>
        </div>
    </section>
    <div class="overflow-hidden whitespace-nowrap mb-4">
        <div class="animate-scroll flex w-max">
            @for ($i = 0; $i < 10; $i++)
                {{-- repeat 10 times --}}
                <img id="device-image" src="{{ asset('home2') }}/assets/img/teknologi-bomi.svg" alt="App mockup"
                    class="inline-block mx-4 h-8" />
            @endfor
        </div>
    </div>

    <section class="bg-white/50 dark:bg-black/30 backdrop-blur py-10 my-[50px]">
        <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-5  mt-3">
            <!-- Image & QR -->
            <div class="relative w-full md:w-[60%] mb-10 md:mb-0 flex justify-center">
                <div class="relative w-[60%] h-auto">
                    <img src="{{ asset('home2') }}/assets/img/scan-qr.svg" alt="QR Menu" class="">
                </div>
            </div>

            <!-- Text -->
            <div class="w-full md:w-[40%] text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold">
                    <span class="text-purple-700 dark:text-white">Dine in,</span><br>
                    <span class="text-purple-700 dark:text-white">Pesan Mudah Tanpa Waiters</span>
                </h2>
                <p class="mt-4 text-gray-400 dark:text-gray-300 leading-relaxed">
                    Langsung scan QR dari meja, pesan, dan bayar tanpa antre. Nikmati kemudahan tanpa hambatan.
                </p>
            </div>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-5 mt-4">

            <!-- Text -->
            <div class="w-full md:w-[40%] text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold">
                    <span class="text-purple-700 dark:text-white">Transaksi Cepat,</span><br>
                    <span class="text-purple-700 dark:text-white">Tanpa Tunggu & Ribet</span>
                </h2>
                <p class="mt-4 text-gray-400 dark:text-gray-300 leading-relaxed">
                    transaksi cepat dan mudah dengan sistem pembayaran terintegrasi. Pelanggan dapat membayar langsung
                    melalui aplikasi, mengurangi waktu tunggu dan meningkatkan kepuasan.
                </p>
            </div>
            <div class="relative w-full md:w-[60%] mb-10 md:mb-0 flex justify-center">
                <div class="relative w-[70%] h-auto">
                    <img src="{{ asset('home2') }}/assets/img/app-android.jpg" alt="QR Menu" class="">
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-5 mt-4">
            <!-- Image & QR -->

            <div class="relative w-full md:w-[60%] mb-10 md:mb-0 flex justify-center">
                <div class="relative w-[70%] h-auto">
                    <img src="{{ asset('home2') }}/assets/img/app-web.png" alt="QR Menu" class="">
                </div>
            </div>
            <!-- Text -->
            <div class="w-full md:w-[40%] text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold">
                    <span class="text-purple-700 dark:text-white">Pantau Usaha Anda,</span><br>
                    <span class="text-purple-700 dark:text-white">Kapan Saja & Di Mana Saja</span>
                </h2>
                <p class="mt-4 text-gray-400 dark:text-gray-300 leading-relaxed">
                    Sistem kami memungkinkan Anda memantau aktivitas pemesanan, transaksi, dan performa restoran langsung
                    dari smartphone atau laptop—dimanapun Anda berada.
                </p>
            </div>

        </div>
        <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-20 py-5 mt-4">
            <!-- Text -->
            <div class="w-full md:w-[40%] text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold">
                    <span class="text-purple-700 dark:text-white">ONLINE/OFFLINE</span><br>
                    <span class="text-purple-700 dark:text-white">Transaksi tanpa takut internet</span>
                </h2>
                <p class="mt-4 text-gray-400 dark:text-gray-300 leading-relaxed">
                    Sistem kami dirancang untuk tetap berfungsi meskipun koneksi internet terputus. Semua data
                    transaksi akan disimpan secara lokal dan disinkronkan otomatis saat koneksi kembali tersedia.
                </p>
            </div>
            <!-- Image & QR -->

            <div class="relative w-full md:w-[60%] mb-10 md:mb-0 flex justify-center">
                <div class="relative w-[70%] h-auto">
                    <img src="{{ asset('home2') }}/assets/img/offline.png" alt="QR Menu" class="">
                </div>
            </div>


        </div>
    </section>

    @include('home-pages.components.hero', [
        'class' => 'mb-10',
    ])
@endsection
