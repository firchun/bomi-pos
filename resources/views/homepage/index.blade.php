@extends('layouts.home')

@section('content')
    <section class="banner position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="block text-center text-lg-start pe-0 pe-xl-5">
                        <h2 class="text-capitalize mb-4">Permudah pekerjaan kasir dengan Bomi Pos, semua transaksi beres
                            dalam hitungan detik!</h2>
                        <p class="mb-4">Kami telah mengumpulkan fitur terbaik untuk mendukung operasional kasir
                            <br> Anda. Pilih solusi paling terbaik untuk bisnis Anda dengan cepat dan mudah!.
                        </p>
                        <a type="button" class="btn btn-primary" href="{{ route('register') }}">Daftar Sekarang <span style="font-size: 14px;"
                                class="ms-2 fas fa-arrow-right"></span></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5 text-center">
                        <img loading="lazy" decoding="async" src="{{ asset('home/images/home-header.png') }}"
                            alt="banner image" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-title pt-4">
                    <p class="text-purple text-uppercase fw-bold mb-3">Our Services</p>
                    <h1>Our online and offline services</h1>
                    <p>
                        {{ $profile->our_services ?? 'Not Have Our_services' }}
                    </p>
                </div>
            </div>

            <div class="row">
                @if (!empty($profile) && $profile->our_services_items)
                    @foreach (json_decode($profile->our_services_items) as $index => $item)
                        <div class="col-lg-4 col-md-6 service-item">
                            <div class="block">
                                <span
                                    class="colored-box text-center h3 mb-4">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <h3 class="mb-3 service-title">{{ $item->title }}</h3>
                                <p class="mb-0 service-description">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No services available at the moment.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="about-section section bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="section-title">
                        <p class="text-purple text-uppercase fw-bold mb-3">About Ourselves</p>
                        <h1>{{ $profile->about_ourselves['title'] ?? 'Not have About_ourselves' }}</h1>
                        <p class="lead mb-0 mt-4">
                            {{ $profile->about_ourselves['description'] ?? 'Not have About_ourselves.' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 text-center text-lg-end">
                    <img loading="lazy" decoding="async" src="{{ asset('home/images/aboutUs.png') }}" alt="About Ourselves"
                        class="img-fluid" width="500px">
                </div>
            </div>
        </div>
    </section>

    <section class="section testimonials overflow-hidden bg-tertiary">
        <div class="container">
            <!-- Difference of Us Title and Description -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-purple text-uppercase fw-bold mb-3">Difference Of Us</p>
                        <h1 class="mb-4">Difference Of Us</h1>
                        <p class="lead mb-0">
                            {{ $profile->difference_of_us ?? 'Discover what makes us unique and different from others.' }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Difference of Us Items -->
            <div class="row position-relative">
                @if (!empty($profile->difference_of_us_items))
                    @foreach ($profile->difference_of_us_items as $index => $item)
                        <div class="col-lg-4 col-md-6 pt-1">
                            <div class="shadow rounded bg-white p-4 mt-4">
                                <div class="d-block d-sm-flex align-items-center mb-3">
                                    <div class="mt-3 mt-sm-0 ms-0">
                                        <h4 class="h5 mb-1">{{ $item['title'] ?? 'No Title' }}</h4>
                                    </div>
                                </div>
                                <div class="content">
                                    {{ $item['description'] ?? 'No description available for this item.' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No differences are currently listed. Please check back later.</p>
                @endif
            </div>
        </div>
    </section>

@endsection
