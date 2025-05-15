<div x-cloak x-show="$wire.showDiscountModal" wire:ignore.self x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-init="$watch('$wire.showDiscountModal', value => {
        if (!value) {
            setTimeout(() => {
                if (!$wire.showDiscountModal) {
                    document.body.classList.remove('overflow-hidden');
                }
            }, 300);
        } else {
            document.body.classList.add('overflow-hidden');
        }
    })">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md relative">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-purple-600">Apply Discount</h3>
            <button wire:click="closeDiscountModal" class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                <select wire:model="discountType"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                    <option value="percentage">Percentage (%)</option>
                    <option value="fixed">Fixed Amount</option>
                    <option value="voucher">Voucher</option>
                </select>
            </div>

            @if ($discountType === 'voucher')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Voucher</label>
                    <select wire:model="selectedVoucher"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select Voucher</option>
                        @foreach ($availableVouchers as $voucher)
                            <option value="{{ $voucher->id }}">{{ $voucher->name }} ({{ $voucher->value }}%)</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $discountType === 'percentage' ? 'Discount Percentage' : 'Fixed Amount' }}
                    </label>
                    <input type="number" wire:model="discountValue"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                        placeholder="{{ $discountType === 'percentage' ? '0-100%' : 'Enter amount' }}" min="0"
                        {{ $discountType === 'percentage' ? 'max="100"' : '' }}>
                    @error('discountValue')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endif
        </div>

        <div class="p-4 border-t border-gray-200 flex justify-end gap-3">
            <button wire:click="closeDiscountModal"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                Cancel
            </button>
            <button wire:click="applyDiscount"
                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                Apply Discount
            </button>
        </div>
    </div>
</div>
