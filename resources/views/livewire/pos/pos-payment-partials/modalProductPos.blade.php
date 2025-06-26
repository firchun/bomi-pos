<!-- Modal Tambah Produk -->
<div id="addProductModalOverlay"
    class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-40 backdrop-blur hidden"
    wire:ignore.self>
    <div id="addProductModal"
        class="bg-white rounded-xl shadow-xl w-full max-w-3xl mx-4 md:mx-auto p-6 md:p-8 max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-resto-text-primary">
                Tambahkan Produk
            </h3>
        </div>

        <!-- Search Input -->
        <div class="relative mb-4">
            <input type="text" wire:model.live.debounce.300ms="modalSearch" placeholder="Search for food, coffe, etc.."
                class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-resto-purple-light focus:border-transparent" />
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <!-- Filter Tabs -->
        <nav class="mb-4 flex space-x-4 border-b border-gray-300 text-sm">
            <button wire:click="$set('modalSelectedCategory', null)"
                class="py-3 px-3 {{ !$modalSelectedCategory ? 'active-tab' : 'inactive-tab hover:text-resto-purple-light' }}">
                Semua
            </button>
            @foreach ($categories as $category)
                <button wire:click="$set('modalSelectedCategory', {{ $category->id }})"
                    class="py-3 px-3 whitespace-nowrap {{ $modalSelectedCategory == $category->id ? 'active-tab' : 'inactive-tab hover:text-resto-purple-light' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </nav>

        <!-- Daftar Produk -->
        <div class="overflow-y-auto flex-grow pr-2 mb-6">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-resto-purple text-white">
                    <tr>
                        <th class="p-2 text-left font-semibold rounded-tl-lg w-10">No</th>
                        <th class="p-2 text-left font-semibold">Nama Produk</th>
                        <th class="p-2 text-left font-semibold">Gambar</th>
                        <th class="p-2 text-left font-semibold">Discount</th>
                        <th class="p-2 text-left font-semibold">Harga</th>
                        <th class="p-2 text-center font-semibold">Qty</th>
                        <th class="p-2 text-center font-semibold rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->modalProducts as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="p-2">#{{ $loop->iteration }}</td>
                            <td class="p-2">{{ $product->name }}</td>
                            <td class="p-2">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-10 h-10 rounded-md object-cover">
                            </td>
                            <td class="p-2 text-red-500">
                                Rp. {{ number_format($product->discount ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="p-2">
                                @if ($product->discount > 0)
                                    <span class="line-through text-gray-400">
                                        Rp. {{ number_format($product->price, 0, ',', '.') }}
                                    </span><br />
                                @endif
                                Rp. {{ number_format($product->price - $product->discount, 0, ',', '.') }}
                            </td>
                            <td class="p-2 text-center">
                                @if (isset($selectedProductQuantities[$product->id]))
                                    <div class="flex items-center justify-center space-x-2">
                                        <button wire:click="decreaseTempQuantity({{ $product->id }})"
                                            class="px-2 py-1 bg-gray-100 rounded-md">-</button>
                                        <input type="number"
                                            wire:model.lazy="selectedProductQuantities.{{ $product->id }}.quantity"
                                            class="w-12 text-center border border-gray-300 rounded-md p-1 focus:outline-none"
                                            min="0" />
                                        <button wire:click="increaseTempQuantity({{ $product->id }})"
                                            class="px-2 py-1 bg-gray-100 rounded-md">+</button>
                                    </div>
                                @else
                                    <button wire:click="addToCart({{ $product->id }})"
                                        class="px-3 py-1 bg-green-100 text-green-600 rounded-md hover:bg-green-200">
                                        Tambah
                                    </button>
                                @endif
                            </td>
                            <td class="p-2 text-center space-x-1">
                                @if (isset($selectedProductQuantities[$product->id]))
                                    <button wire:click="removeFromTemp({{ $product->id }})"
                                        class="p-1.5 bg-red-100 text-red-600 rounded-md hover:bg-red-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">Tidak ada produk ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-auto pt-6 border-t border-gray-200 flex space-x-3">
            <button wire:click="closeAddProductModal"
                class="flex-1 py-3 border border-resto-purple-light text-resto-purple-light rounded-lg font-semibold hover:bg-purple-50 transition-colors text-sm">
                Kembali
            </button>
            <button wire:click="submitToCart"
                class="flex-1 bg-resto-purple text-white py-3 rounded-lg font-semibold hover:bg-resto-purple-dark transition-colors text-sm">
                Tambah Produk
            </button>
        </div>
    </div>
</div>
