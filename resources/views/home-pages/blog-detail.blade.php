@extends('layouts.home2')

@section('title', $blog->title)
@section('meta-title', $blog->title . ' | Bomi POS')
@section('meta-description', Str::limit(strip_tags($blog->content), 100))
@section('meta-keywords', $blog->title . ', ' . $blog->description . ', Bomi POS, Blog')

@section('meta-og-title', $blog->title . ' | Bomi POS')
@section('meta-og-description', Str::limit(strip_tags($blog->content), 100))
@section('meta-og-image', $blog->thumbnail)
@section('meta-og-url', url()->current())
@section('meta-twitter-image', asset('storage/' . $blog->thumbnail))
@section('meta-og-image', asset('storage/' . $blog->thumbnail))

@section('content')
    <div class="container mx-auto px-4 mt-[110px]">

        <!-- Breadcrumb -->
        @include('home-pages.components.breadcrumbs', [
            'before' => 'Blogs',
            'url_before' => url('blogs'),
            'title' => $blog->title,
        ])
        @include('home-pages._search_blog')
        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">

            <!-- Blog Content -->
            <div class="md:col-span-2 bg-white/60 dark:bg-zinc-800/60 rounded-xl overflow-hidden shadow p-0">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-purple-700 mb-2 dark:text-white">{{ $blog->title }}</h1>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <span><i class="bi bi-people"></i> {{ $blog->user->name ?? 'Admin' }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $blog->created_at->format('d M Y') }}</span>
                        <span class="mx-2">•</span>
                        <span class="text-purple-700"><i class="bi bi-eye"></i> {{ $blog->views }}x</span>
                        <span class="mx-2">•</span>
                        <button id="shareBtn" class="text-purple-700">
                            <i class="bi bi-share-fill"></i>
                            <span>Share</span>
                        </button>
                    </div>
                </div>
                @if ($blog->thumbnail)
                    <div class="w-full h-[400px]">
                        <img src="{{ asset('storage/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6">


                    <div class="prose max-w-none dark:prose-invert dark:text-white">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar: Other Blogs -->
            <div class="p-6">
                <h2 class="text-xl font-bold text-purple-700 mb-4 dark:text-white">Artikel Terkait</h2>
                <ul class="space-y-3">
                    @forelse ($otherBlogs as $item)
                        <li>
                            <a href="{{ route('blog-detail', $item->slug) }}"
                                class="flex gap-3 items-start bg-purple-50/90 hover:bg-white rounded-lg p-2 transition dark:hover:bg-zinc-700">
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}"
                                    class="w-16 h-16 object-cover rounded-md shrink-0">
                                <p class="text-black text-sm font-medium leading-snug dark:text-white">
                                    {{ \Illuminate\Support\Str::limit($item->title, 60) }}
                                </p>
                            </a>
                        </li>
                    @empty
                        <li class="text-gray-500 dark:text-gray-400">Belum ada artikel lain yang tersedia.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- 3 Blog Terbaru -->
        <div class="mt-12 mb-10">
            <h2 class="text-2xl font-semibold text-purple-700 mb-6 dark:text-white">Artikel Terbaru</h2>
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
@push('js')
    <script>
        const shareBtn = document.getElementById('shareBtn');

        shareBtn.addEventListener('click', async () => {
            const shareData = {
                title: document.title,
                text: 'Check out this awesome product!',
                url: window.location.href
            }

            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                    console.log('Content shared successfully');
                } catch (err) {
                    console.error('Error sharing:', err);
                }
            } else {
                // fallback: contoh ke WhatsApp Web
                const whatsappUrl =
                    `https://wa.me/?text=${encodeURIComponent(shareData.text + ' ' + shareData.url)}`;
                window.open(whatsappUrl, '_blank');
            }
        });
    </script>
@endpush
