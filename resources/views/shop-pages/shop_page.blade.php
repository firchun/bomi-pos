@extends('layouts.home')

@section('title', 'Restaurant')

@section('content')
    <section class="section" style="padding-top:50px !important;">
        <div class="container">
            <div class="row justify-content-center align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-purple text-uppercase fw-bold mb-3">Our Store</p>
                        <h1>Restaurant</h1>
                        <p>Your One-Stop Shop for Quality and Style. Discover Unique Finds That Inspire and Unleash Your
                            Style with Our Exclusive Collections.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($shops as $shop)
                    <div class="icon-box-item col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('shop.details', $shop->slug) }}" class="text-decoration-none">
                            <div class="block">
                                <div class="d-flex justify-content-center align-items-center" style="height: 140px;">
                                    <div class="mb-5"
                                        style="width: 100%; max-width: 200px; height: 200px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $shop->photo) }}" alt="{{ $shop->name }}"
                                            class="img-fluid rounded" style="max-height: 100%; width: 100%; object-fit: cover; aspect-ratio: 1 / 1;">
                                    </div>
                                </div>

                                <div class="content">
                                    <h3 class="mb-3">{{ $shop->name }}</h3>
                                    <p class="mb-2">Alamat: {{ $shop->address }}</p>
                                    <p class="mb-2">
                                        {{ implode(' ', array_slice(explode(' ', $shop->description), 0, 15)) }}
                                        @if (str_word_count($shop->description) > 15)
                                            ...
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0"><strong>Open:</strong>
                                        {{ (new DateTime($shop->open_time))->format('h:i A') }} -
                                        {{ (new DateTime($shop->close_time))->format('h:i A') }}
                                    </p>
                                    <a href="{{ route('shop.details', $shop->slug) }}" class="btn btn-primary">View Shop</a>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
