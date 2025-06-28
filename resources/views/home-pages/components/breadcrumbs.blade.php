<section
    class="rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transition-colors duration-300 p-5 w-full mb-5">
    <a href="{{ url('/') }}">{{ App::getLocale() == 'en' ? 'Home' : 'Beranda' }}</a>

    @if (!empty($before))
        / <a href="{{ $url_before }}" class="hover:underline">{{ $before }}</a>
    @endif

    / <span class="font-semibold">{{ $title }}</span>
</section>
