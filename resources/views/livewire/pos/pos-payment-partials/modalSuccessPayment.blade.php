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