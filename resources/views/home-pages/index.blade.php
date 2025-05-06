@extends('layouts.home2')

@section('content')
    <section id="hero"
        class=" container mx-auto px-4  mt-[110px] relative w-full h-auto overflow-hidden rounded-[20px] 
     bg-gradient-to-br from-fuchsia-100 to-purple-200 
     dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
     px-6 py-12 md:py-20 lg:py-28 transition-colors duration-300">
        <div class="container mx-auto relative z-10">
            <!-- Heading -->
            <h1
                class="text-zinc-700 text-3xl sm:text-4xl lg:text-5xl font-extrabold font-['Lexend'] max-w-xl mb-6 dark:text-white transition-colors duration-300">
                Make Cashier Tasks Easier with Bomi POS — Every Transaction Done in Seconds!
            </h1>

            <!-- Subheading -->
            <p
                class="text-zinc-600 text-base sm:text-lg lg:text-xl font-semibold font-['Lexend'] max-w-2xl mb-8 dark:text-zinc-400">
                We’ve gathered the best features to support your cashier operations. Choose the perfect solution for
                your
                business—quickly and easily!
            </p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="href="{{route('register')}}""
                    class="w-full sm:w-56 h-14 bg-purple-700 rounded-[20px] flex items-center justify-center text-white text-lg sm:text-xl font-semibold font-['Lexend'] transition-all duration-300 hover:scale-105">
                    Get Started Free
                </a>
                <a href="#"
                    class="w-full sm:w-64 h-14 bg-neutral-900 rounded-[20px] flex items-center justify-center 
     text-white text-lg sm:text-xl font-semibold font-['Lexend'] 
     transition-all duration-300 transform hover:scale-105 
     dark:bg-white dark:text-neutral-900">
                    Download Now
                    <i class="bi bi-google-play ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Image -->
        <img src="{{ asset('home2') }}/assets/img/hero-image2.png" alt="Bomi POS illustration"
        class="absolute right-10 bottom-10 h-3/4 hidden lg:block rounded-lg  object-contain opacity-80 pointer-events-none" />

        <!-- Spotlight gelap -->
        <div id="spotlight"
            class="pointer-events-none absolute w-96 h-96 rounded-full bg-black/25 blur-3xl opacity-0 z-10 transition-opacity duration-300 ease-out mix-blend-multiply">
        </div>
    </section>
    <section class="mt-20 container mx-auto px-4 h-full">
        <!-- Heading -->
        <div
            class="text-center text-zinc-700 text-3xl font-extrabold font-['Lexend'] mb-10 dark:text-white transition-colors duration-300">
            Manage your cashier anytime, <br />
            anywhere, on any device.
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
            The key benefits of using <br />our application
        </h2>

        <!-- Responsive Container with Scale -->
        <div class="w-full flex justify-center">
            <div
                class="transform origin-top scale-65  sm:scale-[0.80] md:scale-[0.95] lg:scale-100 transition-transform duration-300">
                <div class="flex gap-6 flex-col sm:flex-row justify-center">
                    <!-- Left Card -->
                    <div class="w-96 h-auto sm:w-60 sm:h-96 rounded-3xl bg-gradient-to-br from-purple-600 to-sky-500 p-6">
                        <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                          Craft Professional-Grade Retail Management
                          with Bomi POS
                        </h3>
                        <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                          Discover the smart features of Bomi POS — an AI-enhanced solution that simplifies your sales, inventory, and reporting, so you can focus on growing your business.
                        </p>
                    </div>

                    <!-- Right Cards -->
                    <div class="flex flex-col gap-6">
                        <!-- Top Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-bl from-cyan-400 to-green-500 p-6">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                              Boost Your Business 10X with Bomi POS
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                              Discover smart POS tools designed to simplify sales, manage stock, and generate accurate reports — built to help your business grow.
                            </p>
                        </div>

                        <!-- Bottom Right Card -->
                        <div class="w-96 h-40 rounded-3xl bg-gradient-to-br from-orange-500 to-fuchsia-600 p-6 text-right">
                            <h3 class="text-white text-lg font-extrabold font-['Lexend'] mb-2 leading-snug">
                              Overcome Operational Chaos Today
                            </h3>
                            <p class="text-white text-[10px] font-normal font-['Lexend'] leading-relaxed">
                              Discover powerful POS tools from Bomi POS that streamline sales, inventory, and reporting — all with precision and ease.
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
                What Clients Say?
            </h2>
            <p class="text-zinc-600 text-xl font-normal font-['Lexend'] dark:text-zinc-400 transition-colors duration-300">
                There are many variations of passages of Lorem Ipsum available but the <br />
                majority have suffered alteration in some form.
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
@endsection
