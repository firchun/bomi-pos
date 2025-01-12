<section class="homepage_tab position-relative">
    <div class="section container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-4">
                <div class="section-title text-center">
                    <p class="text-purple text-uppercase fw-bold mb-3">Explore Our Shop</p>
                    <h1>Browse Products and Share Your Feedback</h1>
                </div>
            </div>
            <div class="col-lg-10">
                <!-- Tabs untuk Produk -->
                <ul class="payment_info_tab nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item m-2" role="presentation">
                        <a class="nav-link btn btn-outline-primary effect-none text-dark active"
                            id="pills-all-products-tab" data-bs-toggle="pill" href="#pills-all-products" role="tab"
                            aria-controls="pills-all-products" aria-selected="true">All Products</a>
                    </li>
                    <!-- Tab Kategori Produk -->
                    @foreach ($categories as $category)
                        <li class="nav-item m-2" role="presentation">
                            <a class="nav-link btn btn-outline-primary"
                                id="pills-{{ $category->id }}-tab" data-bs-toggle="pill"
                                href="#pills-{{ $category->id }}" role="tab"
                                aria-controls="pills-{{ $category->id }}"
                                aria-selected="false">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab Content untuk Produk -->
                <div class="rounded shadow bg-white p-5 tab-content" id="pills-tabContent">
                    <!-- Tab All Products -->
                    <div class="tab-pane fade show active" id="pills-all-products" role="tabpanel"
                        aria-labelledby="pills-all-products-tab">
                        <div class="d-flex row" id="products-container">
                            {{-- Javascript Content --}}
                        </div>
                        <div id="product-pagination" class="d-flex justify-content-center mt-4"></div>

                    </div>

                    <!-- Tab Per Kategori Produk -->
                    @foreach ($categories as $category)
                        <div class="tab-pane fade" id="pills-{{ $category->id }}" role="tabpanel"
                            aria-labelledby="pills-{{ $category->id }}-tab">
                            <div class="row d-flex flex-wrap" id="category-{{ $category->id }}-products">
                                {{-- Javascript Content --}}
                            </div>
                            <div id="product-pagination" class="d-flex justify-content-center mt-4"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>