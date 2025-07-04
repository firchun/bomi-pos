@extends('layouts.home2')

@section('content')
    @include('home-pages.components.hero', ['class' => 'mt-[110px]'])
    <section class="mt-20 container mx-auto px-4 h-full">
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
    <section class="relative w-full bg-violet-950 overflow-hidden py-12 dark:bg-black/50 transition-colors duration-300">
        <!-- Title -->
        <h2 class="text-white text-3xl font-extrabold font-['Lexend'] text-center mb-10 px-4">
            @if (app()->getLocale() == 'en')
                The key benefits of using <br />our application
            @else
                Manfaat utama menggunakan <br />aplikasi kami
            @endif
        </h2>
        <!-- Responsive Container with Scale -->
        <div class="w-full flex justify-center">
            <div
                class="transform origin-top scale-65  sm:scale-[0.80] md:scale-[0.95] lg:scale-100 transition-transform duration-300">
                <div class="flex gap-6 flex-col sm:flex-row justify-center">
                    <!-- Left Card -->
                    <div class="w-96 h-auto sm:w-60 sm:h-96 rounded-3xl bg-gradient-to-br from-purple-600 to-sky-500 p-6">
                        <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                            @if (app()->getLocale() == 'en')
                                Craft Professional-Grade Retail Management
                                with Bomi POS
                            @else
                                Ciptakan Manajemen Ritel Kelas Profesional
                                dengan Bomi POS
                            @endif
                        </h3>
                        <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                            @if (app()->getLocale() == 'en')
                                Discover the smart features of Bomi POS — an AI-enhanced solution that simplifies your
                                sales,
                                inventory, and reporting, so you can focus on growing your business.
                            @else
                                Temukan fitur cerdas Bomi POS — solusi yang ditingkatkan AI yang menyederhanakan penjualan,
                                inventaris, dan pelaporan Anda, sehingga Anda dapat fokus pada pertumbuhan bisnis Anda.
                            @endif
                        </p>
                    </div>
                    <!-- Right Cards -->
                    <div class="flex flex-col gap-6">
                        <!-- Top Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-bl from-cyan-400 to-green-500 p-6">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                                @if (app()->getLocale() == 'en')
                                    Boost Your Business 10X with Bomi POS
                                @else
                                    Tingkatkan Bisnis Anda 10X dengan Bomi POS
                                @endif
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                                @if (app()->getLocale() == 'en')
                                    Discover smart POS tools designed to simplify sales, manage stock, and generate accurate
                                    reports — built to help your business grow.
                                @else
                                    Temukan alat POS cerdas yang dirancang untuk menyederhanakan penjualan, mengelola stok,
                                    dan menghasilkan laporan yang akurat — dibuat untuk membantu bisnis Anda tumbuh.
                                @endif
                            </p>
                        </div>
                        <!-- Bottom Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-br from-orange-500 to-fuchsia-600 p-6 text-right">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                                @if (app()->getLocale() == 'en')
                                    Overcome Operational Chaos Today
                                @else
                                    Atasi Kekacauan Operasional Hari Ini
                                @endif
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                                @if (app()->getLocale() == 'en')
                                    Discover powerful POS tools from Bomi POS that streamline sales, inventory, and
                                    reporting —
                                    all with precision and ease.
                                @else
                                    Temukan alat POS yang kuat dari Bomi POS yang menyederhanakan penjualan, inventaris, dan
                                    pelaporan — semuanya dengan presisi dan kemudahan.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container mx-auto px-4 mt-20 mb-20">
        <!-- Title Section -->
        <div class="text-center mb-10">
            <h2
                class="text-zinc-700 text-3xl font-extrabold font-['Lexend'] dark:text-white transition-colors duration-300">
                @if (app()->getLocale() == 'en')
                    What Clients Say?
                @else
                    Apa Kata Klien Kami?
                @endif
            </h2>
            <p class="text-zinc-600 text-xl font-normal font-['Lexend'] dark:text-zinc-400 transition-colors duration-300">
                @if (app()->getLocale() == 'en')
                    There are many variations of passages of Lorem Ipsum available but the <br />
                    majority have suffered alteration in some form.
                @else
                    Ada banyak variasi dari teks Lorem Ipsum yang tersedia, tetapi sebagian besar telah mengalami
                    perubahan dalam beberapa bentuk.
                @endif
            </p>
        </div>

        <!-- Testimonials Section (Grid Layout) -->
        <div class="grid grid-cols-1 gap-4  justify-items-center md:grid-cols-2 lg:grid-cols-3 lg:gap-6 ">
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-40 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Customers
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Pemilik Kafe
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        Bomi POS sangat membantu usaha kafe saya. Transaksi jadi cepat dan laporan langsung rapi
                    </p>
                </div>
            </div>
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-80 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Customers
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Pemilik Kafe
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        Dulu stok sering berantakan. Sekarang semua tercatat otomatis. Terima kasih Bomi POS!
                    </p>
                </div>
            </div>
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-40 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Customer
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Pemilik Kafe
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        Training-nya singkat tapi jelas. Setelah itu, langsung bisa dipakai tanpa ribet.
                    </p>
                </div>
            </div>
        </div>
    </section>
    @include('home-pages.components.hero2', [
        'class' => 'mb-10',
    ])
@endsection
