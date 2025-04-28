<div class="row m-4">
    <!-- Kiri (70%) -->
    <div class="col-md-8 position-relative">
        <!-- Search Box -->
        <div class="input-group mb-2 rounded" style="height: 55px;">
            <span class="input-group-text bg-white border-end-0"
                style="border-radius: 50px 0 0 50px; height: 100%; display: flex; align-items: center; border-color: #ccc;">
                <i class="bi bi-search text-muted"></i>
            </span>
            <!-- Menggunakan wire:model.live.debounce.300ms -->
            <input wire:model.live.debounce.300ms="search" type="text" class="form-control border-start-0 shadow-none"
                placeholder="Search name product"
                style="border-radius: 0 50px 50px 0; height: 100%; border-color: #ccc; box-shadow: none !important;">
        </div>

        <!-- Loading Spinner Elegan -->
        <div wire:loading wire:target="search"
            style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
            <div class="spinner"></div>
        </div>

        <!-- Kategori Produk -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <span wire:click="$set('selectedCategory', null)" class="p-2"
                style="cursor: pointer; color: #9900CC; {{ is_null($selectedCategory) ? 'border-bottom: 2px solid #9900CC;' : '' }}">
                All Category
            </span>

            @foreach ($categories as $category)
                <span wire:click="$set('selectedCategory', {{ $category->id }})" class="p-2"
                    style="cursor: pointer; color: #9900CC; {{ $selectedCategory === $category->id ? 'border-bottom: 2px solid #9900CC;' : '' }}">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>

        <!-- Card Produk -->
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4 mb-4" wire:key="product-{{ $product->id }}">
                    <!-- Buat seluruh card bisa diklik -->
                    <div class="card position-relative shadow-sm" style="cursor: pointer;"
                        wire:click="addToOrder({{ $product->id }})">

                        <!-- Icon Keranjang (tidak perlu diklik lagi, biarkan jadi hiasan) -->
                        <div class="position-absolute top-0 end-0 m-2">
                            <div class="rounded p-2" style="background-color: #9900CC;">
                                <i class="bi bi-cart text-white"></i>
                            </div>
                        </div>

                        <!-- Gambar Produk -->
                        <img src="{{ asset($product->image) }}" class="card-img-top mx-auto d-block mt-3 rounded-circle"
                            alt="{{ $product->name }}" style="width: 100px; height: 100px; object-fit: cover;">

                        <!-- Body Card -->
                        <div class="card-body text-center">
                            <h6 class="card-title mb-2">{{ $product->name }}</h6>
                            <div class="border border-danger bg-danger text-white rounded p-1 d-inline-block">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">Tidak ada produk</div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Bagian Kanan (30%) -->
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            {{-- Judul --}}
            <h5 class="mb-3 fw-bold" style="color: #9900CC;">List Order</h5>

            {{-- Header Kecil --}}
            <div class="d-flex justify-content-between mb-2">
                <span class="text-small" style="color: #9900CC;">Item</span>
                <span class="text-small" style="color: #9900CC;"></span>
                <span class="text-small" style="color: #9900CC;">Price</span>
            </div>

            <hr style="border-top: 2px solid #9900CC;">

            @forelse ($orderItems as $item)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="rounded-circle"
                        style="width: 50px; height: 50px; object-fit: cover;">

                    <div class="ms-3 flex-grow-1">
                        <div class="fw-semibold">{{ $item['name'] }}</div>
                        <div class="text-muted small">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>

                        <div class="d-flex align-items-center mt-1">
                            <button wire:click="decrementQty({{ $item['id'] }})"
                                class="btn btn-sm btn-outline-secondary me-2">
                                <i class="bi bi-dash"></i>
                            </button>

                            <span class="fw-bold">{{ $item['qty'] }}</span>

                            <button wire:click="incrementQty({{ $item['id'] }})"
                                class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="bi bi-plus"></i>
                            </button>

                            <span class="ms-auto fw-semibold" style="color: #9900CC;">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-muted text-center">Belum ada item</div>
            @endforelse

            {{-- Border 3 Icon --}}
            <div class="d-flex justify-content-between text-center mt-4 mb-1">
                <div class="flex-fill mx-1">
                    {{-- Icon dengan border ungu kecil --}}
                    <div class="border rounded py-2" style="border-color: #9900CC;">
                        <i class="bi bi-percent text-primary fs-4"></i>
                    </div>
                    {{-- Label di bawah border --}}
                    <div class="small mt-1" style="color: #9900CC;">Discount</div>
                </div>
                <div class="flex-fill mx-1">
                    <div class="border rounded py-2" style="border-color: #9900CC;">
                        <i class="bi bi-cash-coin text-success fs-4"></i>
                    </div>
                    <div class="small mt-1" style="color: #9900CC;">Tax</div>
                </div>
                <div class="flex-fill mx-1">
                    <div class="border rounded py-2" style="border-color: #9900CC;">
                        <i class="bi bi-gear-wide-connected text-warning fs-4"></i>
                    </div>
                    <div class="small mt-1" style="color: #9900CC;">Service</div>
                </div>
            </div>

            <hr style="border-top: 2px solid #9900CC;">

            {{-- Tax Pbi --}}
            <div class="d-flex justify-content-between align-items-center" style="color: rgba(153, 0, 204, 0.6);">
                <div class="fw-semibold fs-6">tax pbi</div>
                <div class="fw-semibold fs-6">0%</div>
            </div>

            {{-- Service --}}
            <div class="d-flex justify-content-between align-items-center" style="color: rgba(153, 0, 204, 0.6);">
                <div class="fw-semibold fs-6">service</div>
                <div class="fw-semibold fs-6">0%</div>
            </div>

            {{-- Discount --}}
            <div class="d-flex justify-content-between align-items-center" style="color: rgba(153, 0, 204, 0.6);">
                <div class="fw-semibold fs-6">discount</div>
                <div class="fw-semibold fs-6">0%</div>
            </div>

            {{-- Total --}}
            <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold fs-6" style="color: #9900CC;">Subtotal:</div>
                <div class="fw-bold fs-5" style="color: #9900CC;">
                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                </div>
            </div>

            {{-- Tombol --}}
            <button wire:click="goToPayment" class="btn w-100 mt-3 fw-semibold text-white"
                style="background-color: #9900CC; border-color: #9900CC;">
                Continue Payment
            </button>
        </div>
    </div>
</div>
