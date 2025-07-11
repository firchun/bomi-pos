    <div id="posViewContainer" class="flex flex-1">
        <main id="posMainContent" class="flex-1 ml-20 mr-[380px] p-6 overflow-auto min-w-0">
            <header class="mb-6">
                @php
                    $shop = \App\Models\ShopProfile::first();
                @endphp
                <h1 class="text-3xl font-bold text-resto-text-primary">
                    {{ strtoupper($shop->name) }}
                </h1>
                <p class="text-resto-text-secondary">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="mt-4 relative">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Search for food, coffe, etc.."
                        class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-resto-purple-light focus:border-transparent" />
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </header>

            <nav class="mb-6 flex flex-wrap space-x-4 border-b border-gray-300">
                <button wire:click="selectCategory(null)"
                    class="py-3 px-3 {{ !$selectedCategory ? 'active-tab' : 'inactive-tab hover:text-resto-purple-light' }}">
                    Semua
                </button>
                @foreach ($categories as $category)
                    <button wire:click="selectCategory({{ $category->id }})"
                        class="py-3 px-3 whitespace-nowrap {{ $selectedCategory == $category->id ? 'active-tab' : 'inactive-tab hover:text-resto-purple-light' }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </nav>

            <section>
                <div>
                    <div class="mb-5 flex border-b border-gray-200">
                        <button wire:click="setViewMode('card')"
                            class="py-2 px-4 -mb-px border-b-2 font-medium text-sm focus:outline-none 
                   {{ $viewMode === 'card' ? 'text-resto-purple border-resto-purple' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                            <i class="fa fa-th-large mr-2"></i> Card View
                        </button>
                        <button wire:click="setViewMode('list')"
                            class="py-2 px-4 -mb-px border-b-2 font-medium text-sm focus:outline-none
                   {{ $viewMode === 'list' ? 'text-resto-purple border-resto-purple' : 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300' }}">
                            <i class="fa fa-list mr-2"></i>
                            List View
                        </button>
                    </div>

                    @if ($viewMode === 'card')
                        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($products as $product)
                                <div wire:click="addToCart({{ $product->id }})"
                                    class="bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 w-full cursor-pointer group">
                                    <div class="relative">
                                        <img class="w-full h-48 object-cover" src="{{ asset($product->image) }}"
                                            alt="{{ $product->name }}">
                                        <div
                                            class="absolute top-3 right-3 bg-resto-purple-light text-white p-2 rounded-lg group-hover:bg-resto-purple transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-resto-text-primary mb-1">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-resto-text-secondary mb-2">
                                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                                        </p>
                                        <p class="text-lg font-bold text-resto-purple-light">
                                            Rp. {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12 text-gray-500">
                                    <p>Tidak ada produk ditemukan.</p>
                                </div>
                            @endforelse
                        </section>
                    @elseif ($viewMode === 'list')
                        <section class="bg-white rounded-xl shadow-md">
                            <table class="w-full text-sm text-left table-fixed">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="p-4 font-medium text-gray-600 w-[40%]">Produk</th>
                                        <th class="p-4 font-medium text-gray-600 w-[20%]">Kategori</th>
                                        <th class="p-4 font-medium text-gray-600 w-[15%]">Harga</th>
                                        <th class="p-4 font-medium text-gray-600 w-[10%]">Discount</th>
                                        <th class="p-4 font-medium text-gray-600 text-center w-[15%]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="p-3">
                                                <div class="flex items-center space-x-3">
                                                    <img class="w-14 h-14 object-cover rounded-md"
                                                        src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                                    <span
                                                        class="font-semibold text-resto-text-primary">{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="p-3 text-resto-text-secondary">
                                                {{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                                            <td class="p-3 text-resto-text-secondary">
                                                @if ($product->discount > 0)
                                                    <span class="line-through text-gray-400">
                                                        Rp. {{ number_format($product->price, 0, ',', '.') }}
                                                    </span><br />
                                                @endif
                                                Rp.
                                                {{ number_format($product->price - $product->discount, 0, ',', '.') }}
                                            </td>
                                            <td class="p-3 text-red-500">
                                                Rp. {{ number_format($product->discount ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="p-3 text-center">
                                                <button wire:click="addToCart({{ $product->id }})"
                                                    class="bg-purple-100 text-resto-purple font-semibold px-4 py-2 rounded-lg hover:bg-purple-200 transition-colors">
                                                    Tambah
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-12 text-gray-500">
                                                Tidak ada produk ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </section>
                    @endif
                </div>
            </section>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>

        <!-- Sidebar Kanan (Pesanan) -->
        <aside id="posOrderSidebar"
            class="w-[380px] bg-white p-6 border-l border-gray-200 fixed top-0 right-0 h-full overflow-y-auto flex flex-col">
            <h2 class="text-2xl font-bold text-resto-text-primary mb-1">
                Orders
            </h2>
            <div class="flex space-x-2 mb-6">
                <button wire:click="setOrderType('Dine In')"
                    class="flex-1 py-2 px-4 rounded-lg text-sm transition-colors
                   {{ $orderType === 'Dine In' ? 'order-type-active' : 'order-type-inactive' }}">
                    Dine In
                </button>
                <button wire:click="setOrderType('To Go')"
                    class="flex-1 py-2 px-4 rounded-lg text-sm transition-colors
                   {{ $orderType === 'To Go' ? 'order-type-active' : 'order-type-inactive' }}">
                    To Go
                </button>
                <button wire:click="setOrderType('Delivery')"
                    class="flex-1 py-2 px-4 rounded-lg text-sm transition-colors
                   {{ $orderType === 'Delivery' ? 'order-type-active' : 'order-type-inactive' }}">
                    Delivery
                </button>
            </div>

            <div class="flex justify-between text-sm pr-4 font-semibold text-resto-text-secondary mb-3">
                <span>Item</span>
                <div class="flex space-x-14">
                    <span>Qty</span>
                    <span>Price</span>
                </div>
            </div>

            <div class="space-y-4 flex-grow">
                @forelse($cartItems as $id => $item)
                    <div class="border border-gray-100 p-3 rounded-lg hover:shadow-md">
                        <!-- Bagian Atas: Gambar, Nama, Quantity, dan Harga -->
                        <div class="flex items-start space-x-3 mb-2">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                class="w-12 h-12 rounded-lg object-cover">

                            <div class="flex-grow">
                                <p class="text-sm font-semibold w-20 text-resto-text-primary">
                                    {{ \Illuminate\Support\Str::limit($item['name'], 30) }}
                                </p>
                                <p class="text-xs text-resto-text-secondary">Rp.
                                    {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-center gap-2">
                                <button wire:click="decreaseQuantity('{{ $id }}')"
                                    class="px-2 py-1 bg-gray-100 rounded-md">-</button>
                                <input type="number" wire:model.live="cartItems.{{ $id }}.quantity"
                                    class="w-10 text-center border border-gray-300 rounded-md p-1.5 focus:outline-none focus:ring-1 focus:ring-resto-purple-light">
                                <button wire:click="increaseQuantity('{{ $id }}')"
                                    class="px-2 py-1 bg-gray-100 rounded-md">+</button>
                            </div>

                            <p class="text-sm font-semibold text-resto-text-primary w-20 text-right">
                                Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Bagian Bawah: Catatan dan Tombol Hapus -->
                        <div class="flex items-center mt-2 space-x-2">
                            <div class="flex-grow">
                                <input type="text" wire:model.debounce.300ms="cartItems.{{ $id }}.notes"
                                    placeholder="Tulis catatan pesanan"
                                    class="w-full text-xs p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-resto-purple-light">
                            </div>

                            <button wire:click="removeItem('{{ $id }}')"
                                class="text-resto-purple-light hover:text-resto-purple p-1.5 bg-purple-100 rounded-md flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h18M3 3v18M3 3l18 18M21 3v18M21 3L3 21"></path>
                        </svg>
                        <p class="mt-2">Keranjang kosong</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-auto pt-6 border-t border-gray-200">
                <div class="flex justify-around mb-4">
                    <button wire:click="openSettingsModal('discount')"
                        class="flex flex-col items-center text-resto-text-secondary hover:text-resto-purple-light">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm0 0l6.75 6.75M17 17h-.01M17 21h-5a2 2 0 01-2-2v-5a2 2 0 012-2h5a2 2 0 012 2v5a2 2 0 01-2 2zm0 0l-6.75-6.75">
                            </path>
                        </svg>
                        <span class="text-xs">Diskon</span>
                    </button>
                    <button wire:click="openSettingsModal('tax')"
                        class="flex flex-col items-center text-resto-text-secondary hover:text-resto-purple-light">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-xs">Pajak</span>
                    </button>
                    <button wire:click="openSettingsModal('service')"
                        class="flex flex-col items-center text-resto-text-secondary hover:text-resto-purple-light">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="text-xs">Layanan</span>
                    </button>
                </div>
                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between text-resto-text-secondary">
                        <span>Subtotal</span>
                        <span>Rp. {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-resto-text-secondary">
                        {{-- Menampilkan persentase pajak yang diterapkan --}}
                        <span>Pajak ({{ $taxRate }}%)</span>
                        <span>Rp. {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-resto-text-secondary">
                        {{-- Menampilkan persentase layanan yang diterapkan --}}
                        <span>Layanan ({{ $serviceCharge }}%)</span>
                        <span>Rp. {{ number_format(($this->subtotal * $serviceCharge) / 100, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-resto-text-secondary">
                        <span>Diskon</span>
                        {{-- Menampilkan jumlah diskon dalam Rupiah --}}
                        <span>Rp. {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>

                    <hr class="border-dashed my-2">

                    <div class="flex justify-between font-bold text-resto-text-primary text-lg">
                        <span>TOTAL</span>
                        {{-- Menampilkan total akhir setelah semua perhitungan --}}
                        <span>Rp. {{ number_format($this->totalBill, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button wire:click="openPaymentModal"
                    class="w-full bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors">
                    Lanjutkan Pembayaran
                </button>
            </div>
        </aside>


        @include('livewire.pos.pos-payment-partials.modalPayment')
        @include('livewire.pos.pos-payment-partials.modalProductPos')
        @include('livewire.pos.pos-payment-partials.modalSuccessPayment')

        @include('livewire.pos.pos-settings-partials.modal-settings')
        @include('livewire.pos.pos-settings-partials.modal-add-new-setting')

        {{-- <!-- Modal Pembayaran Berhasil -->
        <div id="paymentSuccessModalOverlay"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
            <div id="paymentSuccessModal"
                class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 md:mx-auto p-6 md:p-8 text-center flex flex-col items-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-resto-purple" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-resto-text-primary mb-2">
                    Pembayaran telah sukses dilakukan
                </h3>
                <hr class="w-full border-gray-200 my-4" />
                <div class="w-full text-left space-y-2 text-sm mb-6">
                    <div class="flex justify-between">
                        <span class="text-resto-text-secondary">METODE BAYAR</span><span
                            class="font-medium text-resto-text-primary">Tunai</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-resto-text-secondary">TOTAL TAGIHAN</span><span
                            class="font-medium text-resto-text-primary">Rp. 120.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-resto-text-secondary">NOMINAL BAYAR</span><span
                            class="font-medium text-resto-text-primary">Rp. 120.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-resto-text-secondary">WAKTU PEMBAYARAN</span><span
                            class="font-medium text-resto-text-primary">22 Januari, 11:17</span>
                    </div>
                </div>
                <div class="w-full flex space-x-3">
                    <button id="backToPosFromSuccessBtn"
                        class="flex-1 py-3 border border-resto-purple-light text-resto-purple-light rounded-lg font-semibold hover:bg-purple-50 transition-colors text-sm">
                        Kembali
                    </button>
                    <button
                        class="flex-1 bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors text-sm">
                        Print
                    </button>
                </div>
            </div>
        </div> --}}
    </div>
