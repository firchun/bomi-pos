<div class="flex h-screen bg-gray-50">
    <!-- Left Section - 40% -->
    <div class="w-2/5 p-6 bg-white shadow-lg rounded-xl flex flex-col">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#9900CC]">Order Summary</h2>
            <p class="text-[#9900CC] text-sm mt-1">Review your items</p>
            <div class="h-[2px] bg-[#9900CC]/20 mt-3"></div>
        </div>

        <!-- Items List -->
        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
            @foreach ($orderItems as $item)
                <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-[#9900CC]/5 transition-colors">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                        class="w-16 h-16 rounded-lg object-cover border border-[#9900CC]/20">

                    <div class="flex-1">
                        <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>

                        <div class="flex items-center mt-3">
                            <div class="flex items-center border border-[#9900CC]/30 rounded-full">
                                <button wire:click="decrementQty({{ $item['id'] }})"
                                    class="w-8 h-8 flex items-center justify-center text-[#9900CC] hover:bg-[#9900CC]/10 rounded-l-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <span class="px-3 font-medium">{{ $item['qty'] }}</span>
                                <button wire:click="incrementQty({{ $item['id'] }})"
                                    class="w-8 h-8 flex items-center justify-center text-[#9900CC] hover:bg-[#9900CC]/10 rounded-r-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <span class="ml-auto font-medium text-[#9900CC]">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Di bagian bawah Order Totals -->
        <div class="mt-6">
            <button wire:click="openProductModal"
                class="w-full py-2 bg-[#9900CC]/10 text-[#9900CC] rounded-lg border border-dashed border-[#9900CC] hover:bg-[#9900CC]/20 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Product
            </button>
        </div>

        <!-- Order Totals -->
        <div class="mt-6 border-t border-[#9900CC]/20 pt-4 space-y-2">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>Rp {{ number_format($sub_total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Discount ({{ $discount }}%)</span>
                <span>Rp {{ number_format($discount_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax PB1 ({{ $tax }}%)</span>
                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Service Charge</span>
                <span>Rp {{ number_format($service_charge, 0, ',', '.') }}</span>
            </div>
            <div class="h-[2px] bg-[#9900CC]/20 my-2"></div>
            <div class="flex justify-between text-lg font-bold text-[#9900CC]">
                <span>Total</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

    </div>

    <!-- Right Section - 60% -->
    <div class="w-3/5 p-6 bg-gradient-to-b from-[#9900CC]/5 to-white">
        <div class="bg-white p-6 rounded-xl shadow-sm h-full flex flex-col">
            <h2 class="text-2xl font-bold text-[#9900CC]">Payment Method</h2>

            <!-- Payment Toggle -->
            <div class="flex gap-4 my-6">
                <button wire:click="setPaymentMode('paynow')"
                    class="px-8 py-3 rounded-full border-2 font-medium transition-all
                    {{ $paymentMode === 'paynow'
                        ? 'bg-[#9900CC] border-[#9900CC] text-white shadow-md'
                        : 'bg-white border-[#9900CC] text-[#9900CC] hover:bg-[#9900CC]/10' }}">
                    Pay Now
                </button>
                <button wire:click="setPaymentMode('paylater')"
                    class="px-8 py-3 rounded-full border-2 font-medium transition-all
                    {{ $paymentMode === 'paylater'
                        ? 'bg-[#9900CC] border-[#9900CC] text-white shadow-md'
                        : 'bg-white border-[#9900CC] text-[#9900CC] hover:bg-[#9900CC]/10' }}">
                    Pay Later
                </button>
            </div>

            <div class="h-[2px] bg-[#9900CC]/20 mb-6"></div>

            <!-- Pay Now Content -->
            @if ($paymentMode === 'paynow')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                        <input wire:model.live="customer_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9900CC] focus:border-[#9900CC] transition"
                            placeholder="Enter customer name">
                    </div>

                    <div class="h-[2px] bg-[#9900CC]/20"></div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Amount</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" wire:model.live="payment_amount"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9900CC] focus:border-[#9900CC] transition"
                                placeholder="Enter payment amount">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="$set('payment_amount', {{ $total }})"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Exact Amount
                        </button>
                        <button wire:click="roundUpAmount"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Round Up
                        </button>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button wire:click="$dispatch('backToPos')"
                            class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                            Back
                        </button>
                        <button wire:click="saveOrder" wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-[#9900CC] text-white rounded-lg font-medium hover:bg-[#9900CC]/90 transition flex items-center justify-center">
                            <span wire:loading.remove wire:target="saveOrder">Pay Now</span>
                            <span wire:loading wire:target="saveOrder" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            @elseif ($paymentMode === 'paylater')
                <!-- Pay Later Content -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Table Number</label>
                        <input wire:model.live="table_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9900CC] focus:border-[#9900CC] transition"
                            placeholder="Enter table number">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                        <input wire:model.live="customer_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9900CC] focus:border-[#9900CC] transition"
                            placeholder="Enter customer name">
                    </div>

                    <div class="h-[2px] bg-[#9900CC]/20"></div>

                    <div class="flex gap-4 mt-8">
                        <button wire:click="$dispatch('backToPos')"
                            class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                            Back
                        </button>
                        <button wire:click="saveOrder" wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-[#9900CC] text-white rounded-lg font-medium hover:bg-[#9900CC]/90 transition flex items-center justify-center">
                            <span wire:loading.remove wire:target="saveOrder">Save Order</span>
                            <span wire:loading wire:target="saveOrder" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Selection Modal -->
    <div x-cloak x-show="$wire.showProductModal" x-transition.opacity
        class="fixed inset-0 bg-black/30 z-[9999] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl h-[85vh] flex flex-col">
            <!-- Modal Header -->
            <div class="p-4 sm:p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg sm:text-xl font-bold text-[#9900CC]">Add Products</h3>
                <button wire:click="closeProductModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="p-3 sm:p-4 border-b border-gray-200">
                <div class="relative">
                    <input wire:model.live.debounce.300ms="productSearch" type="text"
                        placeholder="Search products..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#9900CC] focus:border-[#9900CC] transition">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto p-3 sm:p-4">
                @if (count($products) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach ($products as $product)
                            <div
                                class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow flex flex-col h-full">
                                <div class="relative aspect-square bg-gray-100">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                </div>
                                <div class="p-2 sm:p-3 flex flex-col flex-1">
                                    <h4 class="font-medium text-gray-800 text-sm sm:text-base truncate">
                                        {{ $product->name }}</h4>
                                    <p class="text-[#9900CC] font-semibold text-sm sm:text-base mt-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    <div class="mt-3">
                                        <div class="flex items-center justify-between gap-1">
                                            <div class="flex items-center border border-gray-300 rounded-full">
                                                <button wire:click="decrementProductQty({{ $product->id }})"
                                                    class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-l-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-3 w-3 sm:h-4 sm:w-4" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                                <span
                                                    class="px-1 sm:px-2 text-xs sm:text-sm">{{ $selectedProducts[$product->id] ?? 0 }}</span>
                                                <button wire:click="incrementProductQty({{ $product->id }})"
                                                    class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-r-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-3 w-3 sm:h-4 sm:w-4" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <button wire:click="addSelectedProduct({{ $product->id }})"
                                                class="px-2 py-1 sm:px-3 sm:py-1 bg-[#9900CC] text-white text-xs sm:text-sm rounded-full hover:bg-[#9900CC]/90 transition">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-500 py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-sm sm:text-base">No products found</p>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="p-3 sm:p-4 border-t border-gray-200 flex justify-end gap-2 sm:gap-3">
                <button wire:click="closeProductModal"
                    class="px-3 py-1 sm:px-4 sm:py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition text-sm sm:text-base">
                    Cancel
                </button>
                <button wire:click="saveSelectedProducts"
                    class="px-3 py-1 sm:px-4 sm:py-2 bg-[#9900CC] text-white rounded-lg hover:bg-[#9900CC]/90 transition flex items-center gap-2 text-sm sm:text-base">
                    <span>Add Selected</span>
                    <span
                        class="bg-white/20 px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full text-xs">{{ count(array_filter($selectedProducts)) }}</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div x-cloak x-show="$wire.showSuccessModal" x-transition.opacity
        class="fixed inset-0 bg-black/30 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-6 text-center">
                <!-- Animated Checkmark -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-10 w-10 text-green-600 animate-check" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful</h3>
                <p class="text-gray-500 mb-6">Order # has been successfully processed.</p>

                <!-- Payment Details -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Bill</span>
                        <span class="font-medium">Rp {{ number_format($totalBill, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount Paid</span>
                        <span class="font-medium">Rp {{ number_format($amountPaid, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Change</span>
                        <span class="font-medium">Rp {{ number_format($change, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="printReceipt()"
                        class="py-2 px-4 border border-[#9900CC] text-[#9900CC] rounded-lg hover:bg-[#9900CC]/10 transition">
                        Print Receipt
                    </button>
                    <button wire:click="newOrder"
                        class="py-2 px-4 bg-[#9900CC] text-white rounded-lg hover:bg-[#9900CC]/90 transition">
                        New Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .animate-check {
            animation: checkmark 0.5s ease-in-out;
        }

        @keyframes checkmark {
            0% {
                stroke-dashoffset: 50;
                opacity: 0;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.1);
            }

            100% {
                stroke-dashoffset: 0;
                transform: scale(1);
            }
        }

        /* Custom scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #9900CC;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #7a00a3;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
@endpush
