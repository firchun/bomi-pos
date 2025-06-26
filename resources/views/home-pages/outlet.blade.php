@extends('layouts.home2')

@section('content')
    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Outlet
        </section>
        <!-- Search Section (Trigger) -->

        @include('home-pages._search')
        <!-- list outlet -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[50px] px-4 container mx-auto">
            @foreach ($shops as $shop)
                <!-- Card  -->
                <a href="{{ route('shop.details', $shop->slug) }}" class="block group">
                    <div
                        class="bg-white dark:bg-zinc-800/70 rounded-xl shadow-sm overflow-hidden transition-all duration-300 group-hover:shadow-md group-hover:ring-1 group-hover:ring-purple-400">
                        <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->slug }}"
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
        @include('home-pages.components.hero', [
            'class' => 'mb-10',
        ])
    </div>
@endsection
