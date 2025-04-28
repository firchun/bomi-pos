<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\ShopProfile;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Pos extends Component
{
    use WithPagination;

    public $categories = [];
    public $selectedCategory = null;
    public $search = '';
    public $orderItems = [];
    public $totalAmount = 0;
    public $shopProfile;
    public $step = 'order';

    protected $queryString = ['search', 'selectedCategory'];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->categories = Category::all();
        $this->shopProfile = ShopProfile::where('user_id', Auth::id())->first();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function calculateTotal()
    {
        $this->totalAmount = collect($this->orderItems)
            ->sum(function ($item) {
                return $item['price'] * $item['qty'];
            });
    }

    public function addToOrder($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]['qty'] += 1;
        } else {
            $this->orderItems[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty' => 1,
            ];
        }

        $this->calculateTotal();
    }

    public function incrementQty($productId)
    {
        if (isset($this->orderItems[$productId])) {
            $this->orderItems[$productId]['qty']++;
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
            $this->calculateTotal();
        }
    }

    public function goToPayment()
    {
        // Simpan data order ke session
        session()->put('orderItems', $this->orderItems);
        session()->put('totalAmount', $this->totalAmount);

        // Arahkan ke halaman Payment
        return redirect()->to('/payment');
    }

    public function render()
    {
        $this->calculateTotal();

        // Query produk dengan pencarian
        $products = Product::query()
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'LIKE', $this->search . '%');
            })
            ->paginate(9);

        return view('livewire.pos.home-pos', [
            'products' => $products,
            'shopProfile' => $this->shopProfile,
        ])->layout('layouts.pos');
    }
}
