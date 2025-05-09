<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Payment extends Component
{
    public $orderItems = [];
    public $cartItems = [];
    public $totalAmount = 0;
    public $paymentMode = 'paynow';
    public $payment_amount, $sub_total, $tax, $discount, $discount_amount, $service_charge, $total;
    public $payment_method, $total_item, $nama_kasir;
    public $transaction_time;
    public $customer_name, $table_number = null;

    // New Variables for Payment Success Popup
    public $change, $amountPaid, $totalBill;

    public function mount()
    {
        $this->calculateTotals();
        // Get items and total amount from session
        $this->orderItems = session()->get('orderItems', []);
        $this->totalAmount = session()->get('totalAmount', 0);
    }

    public function calculateTotals()
    {
        // Calculate total amount from order items
        $this->totalAmount = collect($this->orderItems)
            ->sum(function ($item) {
                return $item['price'] * $item['qty'];
            });

        $this->discount = 0;
        $this->discount_amount = 0;
        $this->tax = 0;
        $this->service_charge = 0;

        $this->total = $this->sub_total
            - $this->discount_amount
            + $this->tax
            + $this->service_charge;
    }

    public function incrementQty($productId)
    {
        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]['qty']++;
            $this->cartItems = $this->orderItems;
            $this->calculateTotal();
        }
    }

    public function decrementQty($productId)
    {
        if (isset($this->orderItems[$productId])) {
            if ($this->orderItems[$productId]['qty'] > 1) {
                $this->orderItems[$productId]['qty']--;
            } else {
                unset($this->orderItems[$productId]);
            }
            $this->calculateTotals();
        }
    }

    public function setPaymentMode($mode)
    {
        $this->paymentMode = $mode;
    }

    public function saveOrder()
    {
        $this->transaction_time = now(); // Pastikan ini selalu di-set

        $this->sub_total = $this->totalAmount;
        $this->discount = 0;
        $this->discount_amount = 0;
        $this->tax = 0;
        $this->service_charge = 0;

        $this->total = $this->sub_total - $this->discount_amount + $this->tax + $this->service_charge;

        $this->payment_method = 'cash'; // Atau bisa pakai input user jika ada
        $this->total_item = collect($this->orderItems)->sum('qty');
        $this->nama_kasir = Auth::user()->name ?? 'Kasir';
        $this->table_number = null;

        $this->validate([
            'payment_amount' => 'required|numeric|min:' . $this->total,
            'customer_name' => 'required|string|max:255',
        ]);

        $no_invoice = 'BR-' . Carbon::now()->format('YmdHis');

        $order = Order::create([
            'payment_amount' => $this->payment_amount,
            'user_id' => Auth::id(),
            'sub_total' => $this->sub_total,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'discount_amount' => $this->discount_amount,
            'service_charge' => $this->service_charge,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'total_item' => $this->total_item,
            'id_kasir' => Auth::id(),
            'nama_kasir' => $this->nama_kasir,
            'transaction_time' => $this->transaction_time,
            'no_invoice' => $no_invoice,
            'table_number' => $this->table_number,
            'customer_name' => $this->customer_name,
            'status' => 'paid',
        ]);

        foreach ($this->orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ]);
        }
        // Set data untuk modal
        $this->totalBill = $this->totalAmount;
        $this->amountPaid = $this->payment_amount;
        $this->change = $this->payment_amount - $this->totalAmount;

        // Tampilkan popup
        $this->js(<<<'JS'
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        JS);

        $this->reset(['payment_amount', 'customer_name']);
    }

    public function roundUpAmount()
    {
        $this->payment_amount = ceil($this->totalAmount / 100) * 100;
    }

    public function render()
    {
        $this->calculateTotals();

        // Otomatis update sub_total dan total
        $this->sub_total = $this->totalAmount;
        $this->discount = 0;
        $this->discount_amount = 0;
        $this->tax = 0;
        $this->service_charge = 0;
        $this->total = $this->sub_total - $this->discount_amount + $this->tax + $this->service_charge;

        return view('livewire.pos.payment')->layout('layouts.pos-payment');
    }
}
