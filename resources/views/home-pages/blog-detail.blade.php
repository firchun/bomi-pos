@extends('layouts.home2')

@section('content')
    <div class="container mx-auto px-4 mt-[110px]">

        <!-- Breadcrumb -->
        @include('home-pages.components.breadcrumbs', [
            'before' => 'Blogs',
            'url_before' => url('blogs'),
            'title' => $blog->title,
        ])

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Blog Content -->
            <div class="md:col-span-2 bg-white/60 dark:bg-zinc-800/60 rounded-xl overflow-hidden shadow p-0">
                @if ($blog->thumbnail)
                    <div class="w-full h-[400px]">
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6">
                    <h1 class="text-3xl font-bold text-purple-700 mb-2 dark:text-white">{{ $blog->title }}</h1>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span>By {{ $blog->user->name ?? 'Admin' }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $blog->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="prose max-w-none dark:prose-invert dark:text-white">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar: Other Blogs -->
            <div class="bg-white/60 dark:bg-zinc-800/60 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-purple-700 mb-4 dark:text-white">Blog Lainnya</h2>
                <ul class="space-y-3">
                    @foreach ($otherBlogs as $item)
                        <li>
                            <a href="{{ route('blog-detail', $item->slug) }}" class="text-purple-700 hover:underline">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- 3 Blog Terbaru -->
        <div class="mt-12 mb-10">
            <h2 class="text-2xl font-semibold text-purple-700 mb-6 dark:text-white">Blog Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($latestBlogs as $item)
                    <div
                        class="bg-white/60 dark:bg-zinc-800/60 rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                        @if ($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-purple-700 mb-2 dark:text-white">
                                <a href="{{ route('blog-detail', $item->slug) }}">{{ $item->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {!! Str::limit(strip_tags($item->content), 100) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    @include('home-pages.components.hero', [
        'class' => 'mb-10',
    ])
@endsection
