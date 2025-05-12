<div x-cloak x-show="$wire.showTaxModal" wire:ignore.self x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" x-init="$watch('$wire.showTaxModal', value => {
        if (!value) {
            setTimeout(() => {
                if (!$wire.showTaxModal) {
                    document.body.classList.remove('overflow-hidden');
                }
            }, 300);
        } else {
            document.body.classList.add('overflow-hidden');
        }
    })">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md relative">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-purple-600">Apply Tax</h3>
            <button wire:click="closeTaxModal" class="text-gray-500 hover:text-gray-700">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Percentage</label>
                <div class="relative">
                    <input type="number" wire:model="taxValue"
                        class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500"
                        placeholder="0-100%" min="0" max="100">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">%</span>
                    </div>
                </div>
                @error('taxValue')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Type</label>
                <select wire:model="taxType"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500">
                    <option value="exclusive">Exclusive</option>
                    <option value="inclusive">Inclusive</option>
                </select>
            </div>

            <div class="bg-blue-50 p-3 rounded-md text-sm text-blue-700">
                <i class="bi bi-info-circle mr-1"></i>
                {{ $taxType === 'exclusive'
                    ? 'Tax will be added to the subtotal'
                    : 'Tax is already included in the product prices' }}
            </div>
        </div>

        <div class="p-4 border-t border-gray-200 flex justify-end gap-3">
            <button wire:click="closeTaxModal"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                Cancel
            </button>
            <button wire:click="applyTax" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                Apply Tax
            </button>
        </div>
    </div>
</div>
