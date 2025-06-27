<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Pos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Halaman Utama POS
    public $search = '';
    public $selectedCategory = null;
    public $activeTab = 'all';
    public $categories;
    public $cartItems = [];

    // Modal Tambah Produk
    public $modalSearch = '';
    public $modalSelectedCategory = null;
    public $selectedProductQuantities = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
    ];

    public function mount()
    {
        $this->categories = Category::where('user_id', Auth::id())->get();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedModalSearch()
    {
        $this->skipRender();
    }

    public function updatedModalSelectedCategory()
    {
        $this->skipRender();    
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->activeTab = 'all';
        $this->resetPage();
    }

    public function setModalSelectedCategory($categoryId)
    {
        $this->modalSelectedCategory = $categoryId;
    }

    public function selectTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedCategory = null;
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        if (isset($this->cartItems[$productId])) {
            $this->cartItems[$productId]['quantity']++;
        } else {
            $this->cartItems[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'notes' => ''
            ];
        }

        if (!isset($this->selectedProductQuantities[$productId])) {
            $this->selectedProductQuantities[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'notes' => ''
            ];
        } else {
            $this->selectedProductQuantities[$productId]['quantity']++;
        }
    }

    public function increaseTempQuantity($productId)
    {
        if (isset($this->selectedProductQuantities[$productId])) {
            $this->selectedProductQuantities[$productId]['quantity']++;
        }
    }

    public function decreaseTempQuantity($productId)
    {
        if (isset($this->selectedProductQuantities[$productId]) && $this->selectedProductQuantities[$productId]['quantity'] > 0) {
            $this->selectedProductQuantities[$productId]['quantity']--;
        }
    }

    public function removeFromTemp($productId)
    {
        unset($this->selectedProductQuantities[$productId]);
    }

    public function closeAddProductModal()
    {
        $this->modalSearch = '';
        $this->modalSelectedCategory = null;
        $this->selectedProductQuantities = [];
    }

    public function submitToCart()
    {
        foreach ($this->selectedProductQuantities as $id => $item) {
            if ($item['quantity'] > 0) {
                if (isset($this->cartItems[$id])) {
                    $this->cartItems[$id]['quantity'] += $item['quantity'];
                } else {
                    $this->cartItems[$id] = $item;
                }
            }
        }
        $this->selectedProductQuantities = [];

        $this->closeAddProductModal();
    }

    public function removeItem($productId)
    {
        unset($this->cartItems[$productId]);
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($quantity > 0) {
            $this->cartItems[$productId]['quantity'] = $quantity;
        }
    }

    public function updateNote($productId, $note)
    {
        $this->cartItems[$productId]['notes'] = $note;
    }

    public function checkout()
    {
        $this->reset(['cartItems']);
    }

    public function increaseQuantity($productId)
    {
        $this->cartItems[$productId]['quantity']++;
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->cartItems[$productId]) && $this->cartItems[$productId]['quantity'] > 1) {
            $this->cartItems[$productId]['quantity']--;
        }
    }

    public function getSubtotalProperty()
    {
        return collect($this->cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function getModalProductsProperty()
    {
        return Product::where('user_id', Auth::id())
            ->when($this->modalSearch, fn($q) => $q->where('name', 'like', "%{$this->modalSearch}%"))
            ->when($this->modalSelectedCategory, fn($q) => $q->where('category_id', $this->modalSelectedCategory))
            ->get();
    }

    public function render()
    {
        $products = Product::query()
            ->where('user_id', Auth::id())
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->activeTab !== 'all', fn($q) => $q->where('type', $this->activeTab))
            ->paginate(6);

        return view('livewire.pos.home-pos', [
            'products' => $products,
            'categories' => $this->categories,
            'subtotal' => $this->getSubtotalProperty(),
        ])->layout('layouts.pos');
    }
}
