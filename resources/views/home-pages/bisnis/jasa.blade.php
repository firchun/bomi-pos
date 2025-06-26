@extends('layouts.home2')

@section('content')
    <div class="container mx-auto px-4 py-20 text-center  mt-[110px]">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-6">
                <svg class="mx-auto h-24 w-24 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-purple-700 mb-4">Coming Soon!</h1>
            <p class="text-gray-600 text-lg mb-6">
                Kami sedang menyiapkan fitur terbaru untuk Anda.<br>
                Nantikan update menarik yang akan segera hadir.
            </p>
            <a href="{{ url('/') }}"
                class="inline-block px-6 py-3 bg-purple-600 text-white rounded-full font-semibold shadow-lg hover:bg-purple-700 transition-all duration-300">
                Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection
