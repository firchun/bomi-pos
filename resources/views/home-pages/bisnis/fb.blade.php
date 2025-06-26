@extends('layouts.home2')

@section('content')
    <section class=" mt-[110px] container mx-auto px-4 h-full">
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
@endsection
