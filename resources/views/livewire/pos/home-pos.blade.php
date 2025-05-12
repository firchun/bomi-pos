<div class="flex h-screen bg-gray-100">
    <!-- Left Column (70%) - Product List -->
    <div class="w-3/4 p-6 overflow-y-auto">
        <!-- Search Box -->
        <div class="relative mb-6">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="bi bi-search text-gray-400"></i>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                class="block w-full pl-10 pr-3 py-4 border border-gray-300 rounded-full bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                placeholder="Search product...">
        </div>

        <!-- Categories -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button wire:click="$set('selectedCategory', null)"
                class="px-4 py-2 rounded-full {{ is_null($selectedCategory) ? 'bg-purple-600 text-white' : 'bg-white text-purple-600 border border-purple-600' }}">
                All
            </button>
            @foreach ($categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})"
                    class="px-4 py-2 rounded-full {{ $selectedCategory == $category->id ? 'bg-purple-600 text-white' : 'bg-white text-purple-600 border border-purple-600' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($products as $product)
                <div wire:key="product-{{ $product->id }}" wire:click="addToOrder({{ $product->id }})"
                    class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer transform hover:scale-105 transition duration-300">
                    <div class="relative">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-purple-600 text-white p-2 rounded-full">
                            <i class="bi bi-cart"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $product->name }}</h3>
                        <div class="mt-2 bg-red-100 text-red-800 inline-block px-2 py-1 rounded-md">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-gray-500">
                    No products found
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Right Column (30%) - Order Summary -->
    <div class="w-1/4 bg-white border-l border-gray-200 p-6 flex flex-col">
        <h2 class="text-xl font-bold text-purple-600 mb-4">Order Summary</h2>

        <!-- Order Items -->
        <div class="flex-1 overflow-y-auto space-y-4">
            @forelse($orderItems as $item)
                <div class="flex items-start space-x-3">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                        class="w-12 h-12 rounded-full object-cover border border-purple-200">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
                        <p class="text-sm text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <div class="flex items-center mt-1">
                            <button wire:click="decrementQty({{ $item['id'] }})"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-l-full text-purple-600 hover:bg-purple-100">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="px-3 font-medium">{{ $item['qty'] }}</span>
                            <button wire:click="incrementQty({{ $item['id'] }})"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-r-full text-purple-600 hover:bg-purple-100">
                                <i class="bi bi-plus"></i>
                            </button>
                            <span class="ml-auto font-medium text-purple-600">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-10">No items in order</div>
            @endforelse
        </div>

        <!-- Charge Buttons -->
        <div class="grid grid-cols-3 gap-2 mt-4">
            <!-- Discount -->
            <button type="button" wire:click="openDiscountModal"
                class="flex flex-col items-center p-2 rounded-lg border border-purple-200 hover:bg-purple-50">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
                    <i class="bi bi-percent"></i>
                </div>
                <span class="text-xs mt-1 text-purple-600">Discount</span>
                @if ($discount > 0)
                    <span class="text-xs text-gray-500">{{ $discount }}%</span>
                @endif
            </button>

            <!-- Tax -->
            <button type="button" wire:click="openTaxModal"
                class="flex flex-col items-center p-2 rounded-lg border border-purple-200 hover:bg-purple-50">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <span class="text-xs mt-1 text-purple-600">Tax</span>
                @if ($tax > 0)
                    <span class="text-xs text-gray-500">{{ $tax }}%</span>
                @endif
            </button>

            <!-- Service Charge -->
            <button type="button" wire:click="openServiceModal"
                class="flex flex-col items-center p-2 rounded-lg border border-purple-200 hover:bg-purple-50">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <span class="text-xs mt-1 text-purple-600">Service</span>
                @if ($service_charge > 0)
                    <span class="text-xs text-gray-500">{{ $service_charge }}%</span>
                @endif
            </button>
        </div>

        <!-- Order Totals -->
        <div class="mt-6 space-y-2">
            <div class="flex justify-between text-sm text-gray-600">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($sub_total, 0, ',', '.') }}</span>
            </div>
            @if ($discount > 0)
                <div class="flex justify-between text-sm text-red-600">
                    <span>Discount ({{ $discount }}%):</span>
                    <span>- Rp {{ number_format($discount_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            @if ($tax > 0)
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Tax ({{ $tax }}%):</span>
                    <span>+ Rp {{ number_format($tax_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            @if ($service_charge > 0)
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Service ({{ $service_charge }}%):</span>
                    <span>+ Rp {{ number_format($service_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="border-t border-gray-200 my-2"></div>
            <div class="flex justify-between font-bold text-purple-600">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Button -->
        <button wire:click="goToPayment"
            class="mt-6 w-full py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
            Continue to Payment
        </button>
    </div>

    <!-- Modals -->
    @include('livewire.pos.pos-partials.modal-discount')
    @include('livewire.pos.pos-partials.modal-tax')
    @include('livewire.pos.pos-partials.modal-service')
</div>
