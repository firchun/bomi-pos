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

    <section class="homepage_tab position-relative">
        <div class="section container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="section-title text-center">
                        <h1 class="text-purple">Bomi Product</h1>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="rounded shadow bg-white p-5 tab-content" id="pills-tabContent">
                        <!-- Tab All Products -->
                        <div class="tab-pane fade show active" id="pills-all-products" role="tabpanel">
                            <div class="row" id="products-container">
                                {{-- Products will be loaded here by AJAX --}}
                            </div>
                            <div id="product-pagination" class="d-flex justify-content-center mt-4">
                                {{-- Pagination will be rendered here by AJAX --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadProducts(page = 1) {
            $.ajax({
                url: `{{ route('api.adminproducts') }}?page=${page}`,
                method: 'GET',
                success: function(response) {
                    const productsContainer = $('#products-container');
                    productsContainer.empty();

                    const products = response.products.data || [];
                    if (products.length > 0) {
                        products.forEach(product => {
                            productsContainer.append(`
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="${product.photo ? `/storage/${product.photo}` : '/images/default-product.png'}" 
                                        class="card-img-top" 
                                        alt="${product.name}" 
                                        style="height: 300px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">${product.description || 'No description available'}</p>
                                        <p class="text-purple"><strong>Price:</strong> Rp${parseFloat(product.price).toLocaleString()}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        });
                    } else {
                        productsContainer.append(
                            '<div class="col-12 text-center text-muted">No products available.</div>'
                        );
                    }

                    renderPagination(response.products);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Failed to load products.');
                }
            });
        }

        function renderPagination(response) {
            const paginationContainer = $('#product-pagination');
            paginationContainer.empty();

            for (let i = 1; i <= response.last_page; i++) {
                paginationContainer.append(`
                <button class="btn ${response.current_page === i ? 'btn-primary' : 'btn-light'} mx-1"
                    onclick="loadProducts(${i})">
                    ${i}
                </button>
            `);
            }
        }

        $(document).ready(function() {
            loadProducts();
        });
    </script>
@endpush
