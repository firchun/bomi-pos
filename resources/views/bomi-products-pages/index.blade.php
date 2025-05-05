@extends('layouts.home2')



@section('content')
    {{-- <section class="about-section section position-relative overflow-hidden">
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
    </div> --}}
    <div class="container mx-auto px-4">
        <!-- broadcom -->
        <section
            class="mt-[110px] rounded-2xl bg-white/50 text-purple-700 dark:text-white dark:bg-zinc-800/70 transitions-colors duration-300 p-5 w-full">
            Home / Bomi Product
        </section>

        <!-- hero -->
        <section id="hero"
            class="mb-[100px] mt-[50px] relative w-full h-auto overflow-hidden rounded-[20px] 
         bg-gradient-to-br from-fuchsia-100 to-purple-200 
         dark:from-zinc-900/50 dark:to-zinc-600/50  dark:backdrop-blur-sm
         px-6 py-12 md:py-20 lg:py-28 transition-colors duration-300">
            <div class="container mx-auto relative z-10">
                <!-- Heading -->
                <h1
                    class="text-zinc-700 text-3xl sm:text-4xl lg:text-5xl font-extrabold font-['Lexend'] max-w-xl mb-6 dark:text-white transition-colors duration-300">
                    Make Cashier Tasks Easier with Bomi POS — Every Transaction Done in Seconds!
                </h1>

                <!-- Subheading -->
                <p
                    class="text-zinc-600 text-base sm:text-lg lg:text-xl font-semibold font-['Lexend'] max-w-2xl mb-8 dark:text-zinc-400">
                    We’ve gathered the best features to support your cashier operations. Choose the perfect solution for
                    your
                    business—quickly and easily!
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#"
                        class="w-full sm:w-56 h-14 bg-purple-700 rounded-[20px] flex items-center justify-center text-white text-lg sm:text-xl font-semibold font-['Lexend'] transition-all duration-300 hover:scale-105">
                        Get Started Free
                    </a>
                    <a href="#"
                        class="w-full sm:w-64 h-14 bg-neutral-900 rounded-[20px] flex items-center justify-center 
         text-white text-lg sm:text-xl font-semibold font-['Lexend'] 
         transition-all duration-300 transform hover:scale-105 
         dark:bg-white dark:text-neutral-900">
                        Download Now
                        <i class="bi bi-google-play ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <img src="{{ asset('home2') }}/assets/img/hero-image.png" alt="Bomi POS illustration"
                class="absolute right-0 bottom-0 h-full hidden lg:block  object-contain opacity-80 pointer-events-none" />

            <!-- Spotlight gelap -->
            <div id="spotlight"
                class="pointer-events-none absolute w-96 h-96 rounded-full bg-black/25 blur-3xl opacity-0 z-10 transition-opacity duration-300 ease-out mix-blend-multiply">
            </div>
        </section>
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
