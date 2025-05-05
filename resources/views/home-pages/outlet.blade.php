@extends('layouts.home2')

@section('content')

    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Outlet
        </section>
        <!-- Search Section (Trigger) -->
        <section
            class="mt-[30px] flex space-x-4 items-center justify-between bg-white/30 dark:bg-zinc-800/70 rounded-2xl p-5 cursor-pointer"
            onclick="toggleSearchModal()">
            <input type="text"
                class="p-3 border border-purple-700 rounded-2xl w-full bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800 transition-colors duration-300 cursor-pointer"
                placeholder="Search Outlet or Product" readonly />
        </section>

        <!-- Modal Overlay -->
        <div id="searchModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center">
            <!-- Modal Box -->
            <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-2xl p-6 mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Search outlet or Product</h2>
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
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[50px] px-4 container mx-auto ">
         
            @foreach ($shops as $shop)
                <!-- Card  -->
                <a href="{{ route('shop.details', $shop->slug) }}" class="block group">
                    <div
                        class="bg-white dark:bg-zinc-800/70 rounded-xl shadow-sm overflow-hidden transition-all duration-300 group-hover:shadow-md group-hover:ring-1 group-hover:ring-purple-400">
                        <img src="{{ asset('storage/' . $shop->photo) }}" 
                        alt="{{ $shop->slug }}"
                        class="w-full h-40 object-cover"
                        onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';">

                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-purple-700 dark:text-white font-['Lexend'] ">
                                {{ $shop->name }}
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300 font-['Lexend'] mt-2 mb-4">
                                {{ implode(' ', array_slice(explode(' ', $shop->description), 0, 15)) }}
                                @if (str_word_count($shop->description) > 15)
                                    ...
                                @endif
                            </p>
                            <hr>
                            <p class="mt-2 font-semibold font-['Lexend'] text-zinc-600 dark:text-zinc-300">
                                Open : {{ (new DateTime($shop->open_time))->format('h:i A') }} -
                                {{ (new DateTime($shop->close_time))->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </section>
        <!-- pagination -->
        {{-- <div class="flex justify-center mt-10">
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
        </div> --}}
        {{ $shops->links('vendor.pagination.tailwind') }}
        <!-- hero -->
        <section id="hero"
            class="mb-[100px] mt-[50px] relative w-full h-auto overflow-hidden rounded-[20px] 
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
                    <a href="{{route('register')}}"
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
    </div>
@endsection
