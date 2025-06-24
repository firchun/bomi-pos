@extends('layouts.home2')

@section('content')
    {{-- <section class="banner position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="block text-center text-lg-start pe-0 pe-xl-5">
                        <h2 class="text-capitalize mb-4">Permudah pekerjaan kasir dengan Bomi Pos, semua transaksi beres
                            dalam hitungan detik!</h2>
                        <p class="mb-4">Kami telah mengumpulkan fitur terbaik untuk mendukung operasional kasir
                            Anda. Pilih solusi paling terbaik untuk bisnis Anda dengan cepat dan mudah!.
                        </p>
                        <a type="button" class="btn btn-primary" href="{{ route('register') }}">Daftar Sekarang <span style="font-size: 14px;"
                                class="ms-2 fas fa-arrow-right"></span></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5 text-center">
                        <img loading="lazy" decoding="async" src="{{ asset('home/images/home-header.png') }}"
                            alt="banner image" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-title pt-4">
                    <p class="text-purple text-uppercase fw-bold mb-3">Our Services</p>
                    <h1>Our online and offline services</h1>
                    <p>
                        {{ $profile->our_services ?? 'Not Have Our_services' }}
                    </p>
                </div>
            </div>

            <div class="row">
                @if (!empty($profile) && $profile->our_services_items)
                    @foreach (json_decode($profile->our_services_items) as $index => $item)
                        <div class="col-lg-4 col-md-6 service-item">
                            <div class="block">
                                <span
                                    class="colored-box text-center h3 mb-4">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="mb-3 service-title">{{ $item->title }}</h3>
                                <p class="mb-0 service-description">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No services available at the moment.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="about-section section bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="section-title">
                        <p class="text-purple text-uppercase fw-bold mb-3">About Ourselves</p>
                        <h1>{{ $profile->about_ourselves['title'] ?? 'Not have About_ourselves' }}</h1>
                        <p class="lead mb-0 mt-4">
                            {{ $profile->about_ourselves['description'] ?? 'Not have About_ourselves.' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 text-center text-lg-end">
                    <img loading="lazy" decoding="async" src="{{ asset('home/images/aboutUs.png') }}" alt="About Ourselves"
                        class="img-fluid" width="500px">
                </div>
            </div>
        </div>
    </section>

    <section class="section testimonials overflow-hidden bg-tertiary">
        <div class="container">
            <!-- Difference of Us Title and Description -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-purple text-uppercase fw-bold mb-3">Difference Of Us</p>
                        <h1 class="mb-4">Difference Of Us</h1>
                        <p class="lead mb-0">
                            {{ $profile->difference_of_us ?? 'Discover what makes us unique and different from others.' }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Difference of Us Items -->
            <div class="row position-relative">
                @if (!empty($profile->difference_of_us_items))
                    @foreach ($profile->difference_of_us_items as $index => $item)
                        <div class="col-lg-4 col-md-6 pt-1">
                            <div class="shadow rounded bg-white p-4 mt-4">
                                <div class="d-block d-sm-flex align-items-center mb-3">
                                    <div class="mt-3 mt-sm-0 ms-0">
                                        <h4 class="h5 mb-1">{{ $item['title'] ?? 'No Title' }}</h4>
                                    </div>
                                </div>
                                <div class="content">
                                    {{ $item['description'] ?? 'No description available for this item.' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No differences are currently listed. Please check back later.</p>
                @endif
            </div>
        </div>
    </section> --}}
    <section id="hero"
        class=" container mx-auto px-4  mt-[110px] relative w-full h-auto overflow-hidden rounded-[20px] 
     bg-gradient-to-br from-fuchsia-100 to-purple-200 
     dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
     px-6 py-12 md:py-20 lg:py-28 transition-colors duration-300">
        <div class="container mx-auto relative z-10">
            <!-- Heading -->
            <h1
                class="text-zinc-700 text-3xl sm:text-4xl lg:text-5xl font-extrabold font-['Lexend'] max-w-xl mb-6 dark:text-white transition-colors duration-300">
                @if (app()->getLocale() == 'en')
                    Make Cashier Tasks Easier with Bomi POS — Every Transaction Done in Seconds!
                @else
                    Permudah pekerjaan kasir dengan Bomi POS, semua transaksi beres dalam hitungan detik!
                @endif
            </h1>

            <!-- Subheading -->
            <p
                class="text-zinc-600 text-base sm:text-lg lg:text-xl font-semibold font-['Lexend'] max-w-2xl mb-8 dark:text-zinc-400">
                @if (app()->getLocale() == 'en')
                    We’ve gathered the best features to support your cashier operations. Choose the perfect solution for
                    your
                    business—quickly and easily!
                @else
                    Kami telah mengumpulkan fitur terbaik untuk mendukung operasional kasir Anda. Pilih solusi paling
                    terbaik untuk bisnis Anda dengan cepat dan mudah!
                @endif
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="#"
                    class="w-full sm:w-56 h-14 bg-purple-700 rounded-[20px] flex items-center justify-center text-white text-lg sm:text-xl font-semibold font-['Lexend'] transition-all duration-300 hover:scale-105">
                    @if (app()->getLocale() == 'en')
                        Get Started Free
                    @else
                        Mulai Gratis
                    @endif
                </a>
                <a href="#"
                    class="w-full sm:w-64 h-14 bg-neutral-900 rounded-[20px] flex items-center justify-center 
     text-white text-lg sm:text-xl font-semibold font-['Lexend'] 
     transition-all duration-300 transform hover:scale-105 
     dark:bg-white dark:text-neutral-900">
                    @if (app()->getLocale() == 'en')
                        Download Now
                    @else
                        Unduh Sekarang
                    @endif
                    <i class="bi bi-google-play ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Image -->
        <img src="{{ asset('home2') }}/assets/img/hero-image.png" alt="Bomi POS illustration"
            class="absolute right-0 bottom-0 h-full hidden lg:block  object-contain opacity-80 pointer-events-none" />

        <!-- Spotlight gelap -->
        <div id="spotlight"
            class="pointer-events-none absolute w-96 h-96 rounded-full bg-black/25 blur-3xl opacity-0 z-10 transition-opacity duration-300 ease-out mix-blend-multiply">
        </div>
    </section>
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

    <img id="device-image" src="{{ asset('home2') }}/assets/img/teknologi.png" alt="App mockup"
        class="item-center mx-auto mb-10" />
    <section class="relative w-full bg-violet-950 overflow-hidden py-12 dark:bg-black/50 transition-colors duration-300">
        <!-- Title -->
        <h2 class="text-white text-3xl font-extrabold font-['Lexend'] text-center mb-10 px-4">
            @if (app()->getLocale() == 'en')
                The key benefits of using <br />our application
            @else
                Keuntungan utama menggunakan <br />aplikasi kami
            @endif
        </h2>

        <!-- Responsive Container with Scale -->
        <div class="w-full flex justify-center">
            <div
                class="transform origin-top scale-[0.75] sm:scale-[0.85] md:scale-[0.95] lg:scale-100 transition-transform duration-300">
                <div class="flex gap-6">
                    <!-- Left Card -->
                    <div class="w-60 h-96 rounded-3xl bg-gradient-to-br from-purple-600 to-sky-500 p-6">
                        <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                            @if (app()->getLocale() == 'en')
                                Craft Professional-<br />
                                Grade Content <br />
                                with AI
                            @else
                                Buat Konten Profesional-<br />
                                Kelas dengan AI
                            @endif
                        </h3>
                        <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                            @if (app()->getLocale() == 'en')
                                Discover the cutting-edge AI <br />
                                tools that bring your <br />
                                ideas to life with exceptional accuracy.
                            @else
                                Temukan alat AI mutakhir yang <br />
                                menghidupkan ide Anda dengan <br />
                                akurasi yang luar biasa.
                            @endif
                        </p>
                    </div>

                    <!-- Right Cards -->
                    <div class="flex flex-col gap-6">
                        <!-- Top Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-bl from-cyan-400 to-green-500 p-6">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                                @if (app()->getLocale() == 'en')
                                    Boost your Productivity 10X <br />
                                    with our AI agent tools.
                                @else
                                    Tingkatkan Produktivitas Anda 10X <br />
                                    dengan alat agen AI kami.
                                @endif
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                                @if (app()->getLocale() == 'en')
                                    Discover the cutting-edge AI <br />
                                    tools that bring your <br />
                                    ideas to life with exceptional accuracy.
                                @else
                                    Temukan alat AI mutakhir yang <br />
                                    menghidupkan ide Anda dengan <br />
                                    akurasi yang luar biasa.
                                @endif
                            </p>
                        </div>

                        <!-- Bottom Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-br from-orange-500 to-fuchsia-600 p-6 text-right">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                                @if (app()->getLocale() == 'en')
                                    Overcome Writer's <br />Block Today
                                @else
                                    Atasi Writer's <br />Block Hari Ini
                                @endif
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                                @if (app()->getLocale() == 'en')
                                    Discover the cutting-edge AI <br />
                                    tools that bring your <br />
                                    ideas to life with exceptional accuracy.
                                @else
                                    Temukan alat AI mutakhir yang <br />
                                    menghidupkan ide Anda dengan <br />
                                    akurasi yang luar biasa.
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
                    Ada banyak variasi dari Lorem Ipsum yang tersedia, tetapi sebagian besar telah mengalami perubahan dalam
                    beberapa bentuk.
                @endif
            </p>

        </div>

        <!-- Testimonials Section (Grid Layout) -->
        <div class="grid grid-cols-2 gap-4  justify-items-center lg:grid-cols-3 lg:gap-6 ">
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-40 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Ralph Edwards
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Angkringan Firman
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        As a Senior Software Developer, I found TailAdmin perfect for writing code that can be easily
                        used in my
                        projects, some of which are already in production.
                    </p>
                </div>
            </div>
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-80 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Ralph Edwards
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Angkringan Firman
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        As a Senior Software Developer, I found TailAdmin perfect for writing code that can be easily
                        used in my
                        projects, some of which are already in production.
                    </p>
                </div>
            </div>
            <!-- Testimonial 1 -->
            <div
                class="w-full h-auto bg-neutral-100 rounded-[30px] p-6 flex flex-col opacity-40 hover:opacity-100 transition-opacity duration-300 shadow-lg dark:bg-neutral-700 transition-colors duration-300">
                <div class="h-auto bg-white rounded-2xl mb-4 p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <div
                        class="text-black text-base font-semibold font-['Lexend'] dark:text-white transition-colors duration-300">
                        Ralph Edwards
                    </div>
                    <p class="text-stone-500 text-xs font-normal font-['Lexend']">
                        Angkringan Firman
                    </p>
                </div>
                <div class="h-auto bg-white rounded-2xl p-4 dark:bg-neutral-900 transition-colors duration-300">
                    <p
                        class="text-black text-base font-normal font-['Lexend'] dark:text-white transition-colors duration-300">
                        As a Senior Software Developer, I found TailAdmin perfect for writing code that can be easily
                        used in my
                        projects, some of which are already in production.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
