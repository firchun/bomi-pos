@extends('layouts.home')

@section('title', 'Bomi Products')

@section('content')
    <section class="about-section section position-relative overflow-hidden">
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

    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-primary text-uppercase fw-bold mb-3 text-purple">Explore Our Product</p>
                        <h1>Bomi Product</h1>
                        <p>Temukan berbagai produk terbaik dari Bomi dengan kualitas terbaik dan harga yang terjangkau.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($products as $product)
                    <div class="icon-box-item col-lg-4 col-md-6">
                        <div class="block">
                            <img src="{{ $product->photo ? asset('storage/' . $product->photo) : asset('/images/default-product.png') }}" 
                            class="card-img-top" 
                            alt="{{ $product->name }}" 
                            style="height: 300px; object-fit: cover;">
                            <h3 class="mb-3 mt-3">{{ $product->name }}</h3>
                            <p class="mb-0">{{ Str::limit($product->description, 100, '...') }}</p>
                            <p class="text-purple mt-3"><strong>Price:</strong>
                                Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <button class="btn btn-primary view-product" data-bs-toggle="modal"
                                data-bs-target="#productModal" data-name="{{ $product->name }}"
                                data-description="{{ $product->description }}" data-price="{{ $product->price }}"
                                data-photo="{{ $product->photo }}" data-phone="{{ $product->phone_number }}">
                                Baca Selengkapnya
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Produk -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalProductImage" class="img-fluid mb-3 d-block mx-auto" style="height: 300px; object-fit: cover;">
                    <h4 id="modalProductName"></h4>
                    <p id="modalProductDescription"></p>
                    <p class="text-purple"><strong>Harga:</strong> Rp<span id="modalProductPrice"></span></p>
                    <a id="modalProductWhatsapp" class="btn btn-success" target="_blank">
                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>                
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event listener untuk tombol "Baca Selengkapnya"
            document.querySelectorAll('.view-product').forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description') ||
                        'No description available';
                    const price = parseFloat(this.getAttribute('data-price')).toLocaleString();
                    const photo = this.getAttribute('data-photo') ?
                        `/storage/${this.getAttribute('data-photo')}` :
                        '/images/default-product.png';
                    const phone = this.getAttribute('data-phone');

                    document.getElementById('modalProductName').textContent = name;
                    document.getElementById('modalProductDescription').textContent = description;
                    document.getElementById('modalProductPrice').textContent = price;
                    document.getElementById('modalProductImage').setAttribute('src', photo);

                    if (phone) {
                        const waLink =
                            `https://wa.me/${phone}?text=Halo,%20saya%20tertarik%20dengan%20produk%20${name}`;
                        document.getElementById('modalProductWhatsapp').setAttribute('href',
                        waLink);
                        document.getElementById('modalProductWhatsapp').style.display = 'block';
                    } else {
                        document.getElementById('modalProductWhatsapp').style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
