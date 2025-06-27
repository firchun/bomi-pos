@extends('layouts.home2')

@section('content')
    <div class="container mx-auto px-4 mt-[110px]">
        <!-- broadcom -->
        @include('home-pages.components.breadcrumbs', [
            'title' => 'Blogs',
        ])
        <!-- Search Section (Trigger) -->

        {{-- @include('home-pages._search') --}}
        <!-- list outlet -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-[50px] px-4 container mx-auto">
            @foreach ($blogs as $item)
                <!-- Card  -->
                <a href="{{ route('blog-detail', $item->slug) }}" class="block group">
                    <div
                        class="bg-white dark:bg-zinc-800/70 rounded-xl shadow-sm overflow-hidden transition-all duration-300 group-hover:shadow-md group-hover:ring-1 group-hover:ring-purple-400">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->slug }}"
                            class="w-full min-h-50  object-cover"
                            onerror="this.onerror=null;this.src='{{ asset('home2/assets/img/sample.png') }}';">

                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-purple-700 dark:text-white font-['Lexend'] ">
                                {{ $item->title }}
                            </h3>
                            <div class="text-sm text-zinc-600 dark:text-zinc-300 font-['Lexend'] mt-2 mb-4">
                                {!! implode(' ', array_slice(explode(' ', $item->content), 0, 15)) !!}
                                @if (str_word_count($item->content) > 15)
                                    ...
                                @endif
                            </div>
                            <hr class="my-2">
                            <p class="mt-2 text-sm font-['Lexend'] text-zinc-600 dark:text-zinc-300">
                                Author : {{ $item->user->name }} |
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </section>
        <!-- pagination -->

        {{ $blogs->links('vendor.pagination.tailwind') }}
        <!-- hero -->
        @include('home-pages.components.hero', [
            'class' => 'mb-10',
        ])
    </div>
@endsection
