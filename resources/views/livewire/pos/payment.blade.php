<div style="display: flex; height: 100vh;">
    <!-- Bagian kiri: 40% -->
    <div
        style="width: 40%; padding: 24px; background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; font-size: 1.1rem;">
        <h4 style="font-weight: bold; color: #9900CC;">Confirmation</h4>
        <p style="color: #9900CC; font-size: 1rem;">Orders</p>
        <hr style="border-color: #9900CC;">

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="d-flex justify-content-between mb-2">
                <strong>Item</strong>
                <strong>Price</strong>
            </div>
            <hr style="border-color: #9900CC;">

            @foreach ($orderItems as $item)
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="rounded-circle"
                        style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="ms-3 flex-grow-1">
                        <div class="fw-semibold" style="font-size: 1.1rem;">{{ $item['name'] }}</div>
                        <div class="text-muted" style="font-size: 0.95rem;">Rp
                            {{ number_format($item['price'], 0, ',', '.') }}</div>

                        <div class="d-flex align-items-center mt-2">
                            <button wire:click="decrementQty({{ $item['id'] }})"
                                class="btn btn-sm btn-outline-secondary me-3 fs-5">
                                <i class="bi bi-dash"></i>
                            </button>

                            <span class="fw-bold fs-5">{{ $item['qty'] }}</span>

                            <button wire:click="incrementQty({{ $item['id'] }})"
                                class="btn btn-sm btn-outline-secondary ms-3 fs-5">
                                <i class="bi bi-plus"></i>
                            </button>

                            <span class="ms-auto fw-semibold" style="color: #9900CC; font-size: 1.1rem;">
                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

            <hr style="border-color: #9900CC;">

            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span>Rp {{ number_format($sub_total, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Discount ({{ $discount }}%)</span>
                <span>Rp {{ number_format($discount_amount, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax PB1 ({{ $tax }}%)</span>
                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Service Charge</span>
                <span>Rp {{ number_format($service_charge, 0, ',', '.') }}</span>
            </div>
            <hr style="border-color: #9900CC;">
            <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
                <strong>Total</strong>
                <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    <!-- Bagian kanan: 60% -->
    <div style="width: 60%; padding: 24px; background-color: #f8f9fa; font-size: 1.1rem;">
        <h4 style="color: #9900CC; font-weight: bold;">Payment</h4>

        <!-- Tombol pilihan metode pembayaran -->
        <div class="d-flex gap-4 my-4">
            <button wire:click="setPaymentMode('paynow')" class="btn"
                style="padding: 12px 40px; border: 2px solid #9900CC; border-radius: 25px; font-size: 1.1rem;
        {{ $paymentMode === 'paynow' ? 'background-color: #9900CC; color: white;' : 'background-color: transparent; color: #9900CC;' }}">
                Pay Now
            </button>

            <button wire:click="setPaymentMode('paylater')" class="btn"
                style="padding: 12px 40px; border: 2px solid #9900CC; border-radius: 25px; font-size: 1.1rem;
        {{ $paymentMode === 'paylater' ? 'background-color: #9900CC; color: white;' : 'background-color: transparent; color: #9900CC;' }}">
                Pay Later
            </button>
        </div>

        <hr style="border-color: #9900CC;">

        <!-- TAMPILAN PAY NOW -->
        @if ($paymentMode === 'paynow')
            <div class="mb-4">
                <label style="font-weight: bold;">Customer</label>
                <textarea wire:model.live="customer_name" class="form-control mt-2" placeholder="Name Customer" rows="1"></textarea>
            </div>

            <hr style="border-color: #9900CC;">

            <div class="mb-4">
                <label style="font-weight: bold;">Payment Amount</label>
                <input type="number" wire:model.live="payment_amount" class="form-control mt-2"
                    placeholder="Enter amount paid by customer" />
            </div>

            <div class="d-flex gap-3 mb-4">
                <button class="btn btn-outline-secondary" wire:click="$set('payment_amount', {{ $total }})">
                    Exact
                </button>
                <button class="btn btn-outline-secondary" wire:click="roundUpAmount">
                    Pembulatan
                </button>
            </div>

            <div class="d-flex w-100">
                <button class="btn btn-secondary px-4 py-2 ms-2 w-50 ..."
                    wire:click="$dispatch('backToPos')">Back</button>
                <button wire:click="saveOrder" wire:loading.attr="disabled" wire:target="saveOrder"
                    class="btn px-4 py-2 ms-2 w-50"
                    style="border-radius: 10px; background-color: #9900CC; border: none; color: white; font-size: 1.05rem;">
                    <span wire:loading.remove wire:target="saveOrder">Pay Now</span>
                    <span wire:loading wire:target="saveOrder">Processing...</span>
                </button>
            </div>
        @elseif ($paymentMode === 'paylater')
            <!-- TAMPILAN PAY LATER -->
            <div class="mb-4">
                <label style="font-weight: bold;">Number Table</label>
                <textarea wire:model.live="table_number" class="form-control mt-2" placeholder="Enter Table Number" rows="1"
                    style="resize: none; border-radius: 10px; font-size: 1.05rem;"></textarea>
            </div>

            <div class="mb-4">
                <label style="font-weight: bold;">Name Customer</label>
                <textarea wire:model.live="customer_name" class="form-control mt-2" placeholder="Enter Customer Name" rows="1"
                    style="resize: none; border-radius: 10px; font-size: 1.05rem;"></textarea>
            </div>

            <hr style="border-color: #9900CC;">

            <div class="d-flex w-100">
                <button class="btn btn-secondary px-4 py-2 me-2 w-50" wire:click="$dispatch('backToPos')"
                    style="border-radius: 10px; font-size: 1.05rem;">Back</button>
                <button wire:click="saveOrder" wire:loading.attr="disabled" wire:target="saveOrder"
                    class="btn px-4 py-2 ms-2 w-50"
                    style="border-radius: 10px; background-color: #9900CC; border: none; color: white; font-size: 1.05rem;">
                    <span wire:loading.remove wire:target="saveOrder">Save Order</span>
                    <span wire:loading wire:target="saveOrder">Processing...</span>
                </button>
            </div>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Total Bill:</strong> Rp {{ number_format($totalBill, 0, ',', '.') }}</p>
                    <p><strong>Amount Paid:</strong> Rp {{ number_format($amountPaid, 0, ',', '.') }}</p>
                    <p><strong>Change:</strong> Rp {{ number_format($change, 0, ',', '.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Back to POS
                    </button>
                    <button type="button" class="btn btn-success" onclick="printReceipt()">
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
@endpush
