<section
    class=" container mx-auto   relative w-[90%] md:w-full h-auto overflow-hidden rounded-[20px] 
    bg-gradient-to-br from-fuchsia-300 to-purple-300 
    dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
    px-6 py-5 md:py-10 lg:py-15 transition-colors duration-300 {{ $class ?? '' }}">

    <h1 class="text-2xl md:text-4xl text-zinc-700 dark:text-white font-bold text-center">
        Perangkat kasir lengkap, transaksi cepat, bisnis makin mantap
    </h1>
    <p class="text-sm md:text-md text-gray-700 dark:text-gray-400 font-bold text-center my-2">
        Dari scan barcode hingga cetak struk, semua bisa otomatis.<br> Cocok untuk resto, kafe, atau toko yang ingin
        kasir modern,
        efisien, dan minim ribet.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-[50px]">
        <a href="href="{{ route('register') }}""
            class="w-full sm:w-56 h-14 bg-purple-700 rounded-[20px] flex items-center justify-center text-white text-lg sm:text-xl font-semibold font-['Lexend'] transition-all duration-300 hover:scale-105">
            @if (app()->getLocale() == 'en')
                Get Started Free
            @else
                Mulai Gratis
            @endif
        </a>
        <a href="#"
            class="w-full sm:w-auto px-4 h-14 bg-neutral-900 rounded-[20px] flex items-center justify-center 
        text-white text-lg sm:text-xl font-semibold font-['Lexend'] 
        transition-all duration-300 transform hover:scale-105 
        dark:bg-white dark:text-neutral-900">
            @if (app()->getLocale() == 'en')
                Buy Devices Now
            @else
                Beli Perangkat Sekarang
            @endif
            {{-- <i class="bi bi-google-play ml-2"></i> --}}
        </a>
    </div>
</section>
