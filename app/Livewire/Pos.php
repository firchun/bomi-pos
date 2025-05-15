<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ShopProfile;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Pos extends Component
{
    use WithPagination;

    // Properties
    public $search = '';
    public $selectedCategory = null;
    public $orderItems = [];
    public $sub_total = 0;
    public $discount = 0;
    public $discount_amount = 0;
    public $tax = 0;
    public $tax_amount = 0;
    public $service_charge = 0;
    public $service_amount = 0;
    public $total = 0;
    public $categories = [];
    public $shopProfile;
    public $availableVouchers = [];

    // Modal related
    public $showServiceModal = false;
    public $showDiscountModal = false;
    public $showTaxModal = false;
    public $discountType = 'percentage';
    public $discountValue = 0;
    public $selectedVoucher = null;
    public $taxValue = 0;
    public $taxType = 'exclusive';
    public $serviceValue = 0;
    public $serviceDescription = '';

    protected $queryString = ['search', 'selectedCategory'];
    protected $listeners = ['calculateTotals', 'closeAllModals'];

    public function mount()
    {
        $this->categories = Category::all();
        $this->shopProfile = ShopProfile::where('user_id', Auth::id())->first();
        $this->availableVouchers = Discount::where('status', 'active')
            ->where('expired_date', '>=', now())
            ->get();

        $this->closeAllModals();
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->paginate(9);

        return view('livewire.pos.home-pos', [
            'products' => $products,
            'categories' => $this->categories,
            'shopProfile' => $this->shopProfile,
        ])->layout('layouts.pos');
    }

    public function addToOrder($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]['qty']++;
        } else {
            $this->orderItems[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1,
            ];
        }

        if ($this->showServiceModal || $this->showDiscountModal || $this->showTaxModal) {
            $this->closeAllModals();
        }

        $this->calculateTotals();
    }

    public function incrementQty($productId)
    {
        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]['qty']++;
            $this->calculateTotals();
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

    public function calculateTotals()
    {
        $this->sub_total = collect($this->orderItems)->sum(fn($item) => $item['price'] * $item['qty']);

        // Calculate discount
        $this->discount_amount = $this->discountType === 'percentage'
            ? $this->sub_total * ($this->discount / 100)
            : min($this->discount, $this->sub_total);

        $taxable_amount = $this->sub_total - $this->discount_amount;

        // Calculate tax and service
        $this->tax_amount = $taxable_amount * ($this->tax / 100);
        $this->service_amount = $taxable_amount * ($this->service_charge / 100);

        $this->total = $taxable_amount + $this->tax_amount + $this->service_amount;
    }

    // Modal Methods
    public function openServiceModal()
    {
        $this->closeAllModals();
        $this->showServiceModal = true;
    }

    public function openDiscountModal()
    {
        $this->closeAllModals();
        $this->showDiscountModal = true;
    }

    public function openTaxModal()
    {
        $this->closeAllModals();
        $this->showTaxModal = true;
    }

    public function closeServiceModal()
    {
        $this->showServiceModal = false;
    }

    public function closeDiscountModal()
    {
        $this->showDiscountModal = false;
    }

    public function closeTaxModal()
    {
        $this->showTaxModal = false;
    }

    public function closeAllModals()
    {
        $this->showServiceModal = false;
        $this->showDiscountModal = false;
        $this->showTaxModal = false;
    }

    // Charge Methods
    public function applyDiscount()
    {
        $this->validate([
            'discountValue' => 'required|numeric|min:0' . ($this->discountType === 'percentage' ? '|max:100' : ''),
        ]);

        $this->discount = $this->discountValue;
        $this->calculateTotals();
        $this->closeDiscountModal();
    }

    public function applyTax()
    {
        $this->validate([
            'taxValue' => 'required|numeric|min:0|max:100',
        ]);

        $this->tax = $this->taxValue;
        $this->calculateTotals();
        $this->closeTaxModal();
    }

    public function applyService()
    {
        $this->validate([
            'serviceValue' => 'required|numeric|min:0|max:100',
        ]);

        $this->service_charge = $this->serviceValue;
        $this->calculateTotals();
        $this->closeServiceModal();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();

        $this->closeAllModals();
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->closeAllModals();
    }

    public function goToPayment()
    {
        if (empty($this->orderItems)) {
            $this->dispatch('notify', 'Please add items to order first');
            return;
        }

        session()->put('pos.order', [
            'items' => $this->orderItems,
            'totals' => [
                'sub_total' => $this->sub_total,
                'discount' => $this->discount,
                'discount_amount' => $this->discount_amount,
                'tax' => $this->tax,
                'tax_amount' => $this->tax_amount,
                'service_charge' => $this->service_charge,
                'service_amount' => $this->service_amount,
                'total' => $this->total,
            ]
        ]);

        return redirect()->route('pos.payment');
    }
}
