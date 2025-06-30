<section id="hero"
    class=" container mx-auto  mt-[110px] relative w-full h-auto overflow-hidden rounded-[20px] 
bg-gradient-to-br from-fuchsia-100 to-purple-200 
dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
px-6 py-12 md:py-20 lg:py-28 transition-colors duration-300 {{ $class ?? '' }}">
    <div class="container mx-auto relative z-10">
        <!-- Heading -->
        <h1
            class="text-zinc-700 text-3xl sm:text-3xl lg:text-5xl font-extrabold font-['Lexend'] max-w-xl mb-6 dark:text-white transition-colors duration-300">
            @if (app()->getLocale() == 'en')
                Simplify Cashier & Manager Tasks with Bomi POS — Transactions & Reports Done in Seconds!
            @else
                Permudah Tugas Kasir & Manajer dengan Bomi POS — Transaksi & Laporan Selesai dalam Hitungan Detik!
            @endif
        </h1>

        <!-- Subheading -->
        <p
            class="text-zinc-600 text-base sm:text-lg lg:text-xl font-semibold font-['Lexend'] max-w-2xl mb-8 dark:text-zinc-400">
            @if (app()->getLocale() == 'en')
                We've gathered the best features to support your cashier operations, with full control for managers and
                business owners. Choose the perfect solution for your business—quickly and easily!
            @else
                kemikiran fitur terbaik untuk mendukung operasional kasir Anda, dengan kontrol penuh bagi manajer dan
                pemilik bisnis. Pilih solusi yang tepat untuk bisnis Anda—cepat dan mudah!
            @endif
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="href="{{ route('register') }}""
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
    <img src="{{ asset('home2') }}/assets/img/hero-image2.png" alt="Bomi POS illustration"
        class="absolute right-10 bottom-10 h-3/4 hidden lg:block rounded-lg  object-contain opacity-80 pointer-events-none" />

    <!-- Spotlight gelap -->
    <div id="spotlight"
        class="pointer-events-none absolute w-96 h-96 rounded-full bg-black/25 blur-3xl opacity-0 z-10 transition-opacity duration-300 ease-out mix-blend-multiply">
    </div>
</section>
