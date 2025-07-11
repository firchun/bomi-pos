<!-- Modal Lanjutkan Pembayaran -->
<div x-cloak x-show="$wire.showPaymentModal" @keydown.escape.window="$wire.showPaymentModal = false" x-transition.opacity
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 flex items-center justify-center">
    <div id="paymentModal"
        class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 md:mx-auto flex flex-col md:flex-row max-h-[90vh]">
        <!-- Kolom Kiri Modal: Konfirmasi Pesanan -->
        <div class="w-full md:w-2/5 bg-gray-50 p-6 md:p-8 rounded-l-xl flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-resto-text-primary">
                    Konfirmasi
                </h3>
                <button wire:click="openProductModal"
                    class="p-2 bg-resto-purple text-white rounded-lg hover:bg-resto-purple-dark">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-resto-text-secondary mb-1">Orders #1</p>
            <hr class="border-gray-300 mb-4" />
            <div class="flex justify-between text-xs font-semibold text-resto-text-secondary mb-3">
                <span>Item</span>
                <div class="flex pr-8 space-x-14">
                    <span>Qty</span>
                    <span>Price</span>
                </div>
            </div>
            <div class="space-y-2 overflow-y-auto flex-grow pr-2">
                @forelse($cartItems as $id => $item)
                    {{-- Wrapper untuk setiap item --}}
                    <div class="py-2 border-b border-gray-100" wire:key="payment-item-{{ $id }}">

                        <div class="flex items-start space-x-2">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                class="w-10 h-10 rounded-md object-cover flex-shrink-0" />
                            <div class="flex-grow">
                                <p class="text-xs font-semibold text-resto-text-primary leading-tight">
                                    {{ \Illuminate\Support\Str::limit($item['name'], 30) }}
                                </p>
                                <p class="text-xs text-resto-text-secondary">
                                    Rp. {{ number_format($item['price'], 0, ',', '.') }}
                                </p>
                            </div>
                            <input type="number" wire:model.live="cartItems.{{ $id }}.quantity"
                                class="w-12 text-center text-xs border border-gray-300 rounded-md p-1 focus:outline-none focus:ring-1 focus:ring-resto-purple-light" />
                            <p class="text-xs font-semibold text-resto-text-primary w-20 text-right">
                                Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mt-2 pl-[48px]">
                            <input type="text" wire:model.debounce.300ms="cartItems.{{ $id }}.notes"
                                placeholder="Tulis catatan pesanan..."
                                class="w-full text-xs p-1.5 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-resto-purple-light" />
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-8">Keranjang kosong</p>
                @endforelse
            </div>

            <div class="space-y-2 mb-4 text-sm">
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Subtotal</span>
                    <span>Rp. {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Pajak ({{ $taxRate }}%)</span>
                    <span>+ Rp. {{ number_format($this->taxAmount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Layanan ({{ $serviceCharge }}%)</span>
                    <span>+ Rp. {{ number_format(($this->subtotal * $serviceCharge) / 100, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Diskon</span>
                    <span class="text-red-600">- Rp. {{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                <hr class="border-dashed my-2">
                <div class="flex justify-between font-bold text-resto-text-primary text-lg">
                    <span>TOTAL</span>
                    <span>Rp. {{ number_format($this->totalBill, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan Modal: Opsi Pembayaran -->
        <div class="w-full md:w-3/5 p-6 md:p-8 flex flex-col">
            <div class="flex justify-between items-center mb-1">
                <h3 class="text-2xl font-bold text-resto-text-primary">
                    Pembayaran
                </h3>
                <button @click="$wire.showPaymentModal = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <hr class="border-gray-300 mb-6" />

            <div>
                <p class="text-sm font-semibold text-resto-text-primary mb-2">
                    Waktu Transaksi
                </p>
                <div class="flex space-x-3 mb-6">
                    <button id="payNowTab" class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-active">
                        Pay Now
                    </button>
                    <button id="payLaterTabSoon" class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-inactive">
                        Pay Later <span class="text-red-500 text-xs ml-1">(soon)</span>
                    </button>
                </div>
            </div>

            <!-- Konten Pay Now -->
            <div id="payNowContent">
                <p class="text-sm font-semibold text-resto-text-primary mb-2">
                    Metode Bayar
                </p>
                <div class="flex space-x-3 mb-4">
                    <button
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-active flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        <span>Cash</span>
                    </button>
                    <button class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-inactive">
                        QRIS <span class="text-red-500 text-xs ml-1">(soon)</span>
                    </button>
                </div>
                <div class="mb-4">
                    <label for="customerNamePayNow"
                        class="block text-sm font-semibold text-resto-text-primary mb-1">Customer Name</label>
                    <input type="text" id="customerNamePayNow" wire:model="customerName"
                        placeholder="Masukkan Nama Pelanggan"
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm" />

                    @error('customerName')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="amountPayNow" class="block text-sm font-semibold text-resto-text-primary mb-2">
                        Masukkan Jumlah Bayar
                    </label>
                    <input type="number" id="amountPayNow" wire:model.live="amountPaid"
                        placeholder="Masukkan jumlah bayar"
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm" />
                    @error('amountPaid')
                        <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex space-x-3 mb-6">
                    <button wire:click="setExactAmount"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm {{ abs((float) $amountPaid - $this->totalBill) < 1 ? 'order-type-active' : 'order-type-inactive' }}">
                        Uang Pas
                    </button>
                    <button wire:click="setRoundUpAmount"
                        class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-inactive ">
                        Pembulatan
                    </button>
                </div>
            </div>

            <!-- Konten Pay Later -->
            <div id="payLaterContent" class="hidden">
                <label for="customerNamePayLater"
                    class="block text-sm font-semibold text-resto-text-primary mb-1">Customer Name</label>
                <input type="text" id="customerNamePayLater" placeholder="Customer Name"
                    class="w-full p-2.5 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm" />

                <p class="text-sm font-semibold text-resto-text-primary mb-2">
                    No Table
                </p>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2 mb-6 max-h-32 overflow-y-auto pr-2">
                    <!-- Tombol Meja Dinamis -->
                    <button class="py-2 px-3 rounded-lg text-xs table-button-active">
                        Table 1
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 2
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 3
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 4
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 5
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 6
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 7
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 8
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 9
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 10
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 11
                    </button>
                    <button class="py-2 px-3 rounded-lg text-xs table-button-inactive">
                        Table 12
                    </button>
                </div>
            </div>

            <div class="mt-auto pt-6 border-t border-gray-200 flex space-x-3">
                <button @click="$wire.showPaymentModal = false"
                    class="flex-1 py-3 border border-resto-purple-light text-resto-purple-light rounded-lg font-semibold hover:bg-purple-50 transition-colors text-sm">
                    Batalkan
                </button>
                <button wire:click="processPayment"
                    class="flex-1 bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors text-sm"
                    wire:loading.attr="disabled" ...>
                    <span wire:loading.remove wire:target="processPayment">Bayar</span>
                    <span wire:loading wire:target="processPayment">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
</div>
