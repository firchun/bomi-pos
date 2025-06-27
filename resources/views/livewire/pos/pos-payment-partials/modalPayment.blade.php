<!-- Modal Lanjutkan Pembayaran -->
<div id="paymentModalOverlay"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-30 hidden backdrop-blur-sm"
    wire:ignore.self;>
    <div id="paymentModal"
        class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 md:mx-auto flex flex-col md:flex-row max-h-[90vh]">
        <!-- Kolom Kiri Modal: Konfirmasi Pesanan -->
        <div class="w-full md:w-2/5 bg-gray-50 p-6 md:p-8 rounded-l-xl flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-resto-text-primary">
                    Konfirmasi
                </h3>
                <button id="addProductFromModalBtn"
                    class="p-2 bg-resto-purple text-white rounded-lg hover:bg-resto-purple-dark">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>
            <p class="text-sm text-resto-text-secondary mb-1">Orders #1</p>
            <hr class="border-gray-300 mb-4" />
            <div class="flex justify-between text-xs font-semibold text-resto-text-secondary mb-3">
                <span>Item</span>
                <div class="flex space-x-8">
                    <span>Qty</span>
                    <span>Price</span>
                </div>
            </div>
            <div class="space-y-3 overflow-y-auto flex-grow pr-2">
                @forelse($cartItems as $id => $item)
                    <div class="flex items-start space-x-2" wire:key="payment-item-{{ $id }}">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                            class="w-10 h-10 rounded-md object-cover" />
                        <div class="flex-grow">
                            <p class="text-xs font-semibold text-resto-text-primary">
                                {{ \Illuminate\Support\Str::limit($item['name'], 30) }}
                            </p>
                            <p class="text-xxs text-resto-text-secondary">Rp.
                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                            <input type="text" placeholder="Catatan pesanan"
                                class="mt-1 w-full text-xxs p-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-resto-purple-light" />
                        </div>
                        <input type="number" wire:model.live="cartItems.{{ $id }}.quantity"
                            class="w-10 text-center text-xs border border-gray-300 rounded-md p-1 focus:outline-none focus:ring-1 focus:ring-resto-purple-light" />
                        <p class="text-xs font-semibold text-resto-text-primary w-16 text-right">
                            Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </p>
                        <button wire:click="removeItem('{{ $id }}')"
                            class="text-resto-purple-light hover:text-resto-purple p-1 bg-purple-100 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Keranjang kosong</p>
                @endforelse
            </div>
            
            <div class="mt-auto pt-4 border-t border-gray-300 text-xs space-y-1.5">
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Ongkir</span><span>0</span>
                </div>
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Pajak</span><span>10 %</span>
                </div>
                <div class="flex justify-between text-resto-text-secondary">
                    <span>Diskon</span><span>Rp. 0</span>
                </div>
                <div class="flex justify-between font-semibold text-resto-text-primary text-sm">
                    <span>Sub total</span><span>Rp. 120.000</span>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan Modal: Opsi Pembayaran -->
        <div class="w-full md:w-3/5 p-6 md:p-8 flex flex-col">
            <div class="flex justify-between items-center mb-1">
                <h3 class="text-2xl font-bold text-resto-text-primary">
                    Pembayaran
                </h3>
                <button id="closePaymentModalBtn" class="text-gray-500 hover:text-gray-700">
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
                    <button id="payLaterTab" class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-inactive">
                        Pay Later
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
                        QRIS
                    </button>
                </div>
                <label for="customerNamePayNow"
                    class="block text-sm font-semibold text-resto-text-primary mb-1">Customer Name</label>
                <input type="text" id="customerNamePayNow" placeholder="Customer Name"
                    class="w-full p-2.5 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm" />

                <label for="amountPayNow" class="block text-sm font-semibold text-resto-text-primary mb-1">Rp.
                    120.000</label>
                <input type="text" id="amountPayNow" placeholder="Rp. 120.000" value="Rp. 120.000"
                    class="w-full p-2.5 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-1 focus:ring-resto-purple-light text-sm" />

                <div class="flex space-x-3 mb-6">
                    <button class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-inactive">
                        Exact
                    </button>
                    <button class="flex-1 py-2.5 px-4 rounded-lg text-sm order-type-active">
                        Round Up
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
                <button id="cancelPaymentBtn"
                    class="flex-1 py-3 border border-resto-purple-light text-resto-purple-light rounded-lg font-semibold hover:bg-purple-50 transition-colors text-sm">
                    Batalkan
                </button>
                <button id="submitPaymentBtn"
                    class="flex-1 bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors text-sm">
                    Bayar
                </button>
            </div>
        </div>
    </div>
</div>
