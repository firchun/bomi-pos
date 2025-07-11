<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Ganti dengan model Order Anda

class Pos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // === Global Properties ===
    public string $search = '';
    public ?int $selectedCategory = null;
    public array $cartItems = [];
    public string $viewMode = 'card';
    public string $orderType = 'Dine In';

    // === Payment Modal Properties ===
    public bool $showPaymentModal = false;
    public string $customerName = '';
    public $amountPaid = null;
    public string $paymentMethod = 'cash';
    public int $taxRate = 0;
    public float $discount = 0;
    public float $serviceCharge = 0;
    public string $newInvoiceNumber = '';
    public bool $showDiscountModal = false;
    public bool $showTaxModal = false;
    public bool $showServiceModal = false;

    // === Add Product Modal Properties ===
    public bool $showProductModal = false;
    public string $modalSearch = '';
    public ?int $modalSelectedCategory = null;
    public array $selectedProductQuantities = [];

    // === Success Modal Properties ===
    public bool $showSuccessModal = false;
    public ?array $lastTransactionDetails = null;

    //== Properti untuk Modal Pengaturan ==
    public bool $showSettingsModal = false;
    public string $activeSettingsTab = 'tax'; // 'tax', 'service', 'discount'

    public bool $showAddNewSettingModal = false;
    public $newSettingName, $newSettingValue;
    public $newSettingType = 'percentage';

    //== Properti untuk menampung daftar pilihan dari Session ==
    public array $taxPresets = [];
    public array $servicePresets = [];
    public array $discountPresets = [];

    /*
    |--------------------------------------------------------------------------
    | Computed Properties (Kalkulasi & Query Otomatis)
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function categories()
    {
        return Category::where('user_id', Auth::id())->get();
    }

    #[Computed]
    public function products()
    {
        return Product::query()
            ->where('user_id', Auth::id())
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->paginate(12);
    }

    #[Computed]
    public function modalProducts()
    {
        return Product::where('user_id', Auth::id())
            ->when($this->modalSearch, fn($q) => $q->where('name', 'like', "%{$this->modalSearch}%"))
            ->when($this->modalSelectedCategory, fn($q) => $q->where('category_id', $this->modalSelectedCategory))
            ->get();
    }

    #[Computed]
    public function subtotal()
    {
        return collect($this->cartItems)->sum(fn($item) => ($item['price'] - $item['discount']) * $item['quantity']);
    }

    #[Computed]
    public function taxAmount()
    {
        return ($this->subtotal * $this->taxRate) / 100;
    }

    #[Computed]
    public function totalBill()
    {
        $totalService = ($this->subtotal * $this->serviceCharge) / 100;
        return ($this->subtotal + $this->taxAmount + $totalService) - $this->discount;
    }

    public function applyTax($rate)
    {
        $this->taxRate = $rate;
        $this->showTaxModal = false;
    }

    public function applyDiscount($amount)
    {
        // Validasi sederhana untuk memastikan nilai adalah angka & tidak negatif
        if (!is_numeric($amount) || $amount < 0) {
            $amount = 0;
        }

        $this->discount = (float) $amount;
        $this->showDiscountModal = false; // Tutup modal diskon
    }

    public function applyServiceCharge($rate)
    {
        // Validasi sederhana untuk memastikan nilai adalah angka & tidak negatif
        if (!is_numeric($rate) || $rate < 0) {
            $rate = 0;
        }

        $this->serviceCharge = (float) $rate;
        $this->showServiceModal = false; // Tutup modal layanan
    }

    /*
    |--------------------------------------------------------------------------
    | Main Cart Management
    |--------------------------------------------------------------------------
    */

    public function setViewMode($mode)
    {
        // Validasi untuk memastikan hanya mode 'card' atau 'list' yang diterima
        if (in_array($mode, ['card', 'list'])) {
            $this->viewMode = $mode;
        }
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        $productIdStr = (string) $productId;

        if (isset($this->cartItems[$productIdStr])) {
            $this->cartItems[$productIdStr]['quantity']++;
        } else {
            $this->cartItems[$productIdStr] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discount' => $product->discount ?? 0,
                'image' => $product->image,
                'quantity' => 1,
                'notes' => ''
            ];
        }
        $this->dispatch('success', 'Produk ditambahkan.');
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->cartItems[$productId])) {
            $this->cartItems[$productId]['quantity']++;
        }
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->cartItems[$productId]) && $this->cartItems[$productId]['quantity'] > 1) {
            $this->cartItems[$productId]['quantity']--;
        }
    }

    public function removeItem($productId)
    {
        unset($this->cartItems[$productId]);
        $this->dispatch('success', 'Produk dihapus.');
    }

    //== Ubah/Tambahkan metode mount() untuk memuat data dari Session ==
    public function mount()
    {
        $this->taxPresets = session('pos_tax_presets', []);
        $this->servicePresets = session('pos_service_presets', []);
        $this->discountPresets = session('pos_discount_presets', []);
    }

    //== Metode untuk mengelola modal ==
    public function openSettingsModal($tab)
    {
        $this->activeSettingsTab = $tab;
        $this->showSettingsModal = true;
    }

    public function openAddNewSettingModal()
    {
        $this->showAddNewSettingModal = true;
    }
    public function closeAddNewSettingModal()
    {
        $this->showAddNewSettingModal = false;
    }

    public function setOrderType(string $type)
    {
        $this->orderType = $type;
    }

    /*
    |--------------------------------------------------------------------------
    | Metode untuk MENYIMPAN dan MENGHAPUS pilihan baru KE SESSION 
    |--------------------------------------------------------------------------
    */

    public function saveNewSetting()
    {
        $this->validate([
            'newSettingName' => 'required|string|max:50',
            'newSettingValue' => 'required|numeric|min:0',
        ]);

        $newPreset = [
            'name' => $this->newSettingName,
            'type' => $this->newSettingType,
            'value' => $this->newSettingValue,
        ];

        $sessionKey = '';
        $propertyToUpdate = '';

        switch ($this->activeSettingsTab) {
            case 'tax':
                $sessionKey = 'pos_tax_presets';
                $propertyToUpdate = 'taxPresets';
                break;
            case 'service':
                $sessionKey = 'pos_service_presets';
                $propertyToUpdate = 'servicePresets';
                break;
            case 'discount':
                $sessionKey = 'pos_discount_presets';
                $propertyToUpdate = 'discountPresets';
                break;
        }

        if ($sessionKey) {
            $presets = session($sessionKey, []);
            $presets[] = $newPreset;
            session([$sessionKey => $presets]);
            $this->$propertyToUpdate = $presets;
        }

        $this->reset('newSettingName', 'newSettingValue', 'newSettingType');
        $this->closeAddNewSettingModal();
    }

    //== Metode untuk MENERAPKAN pilihan dari Session ke transaksi ==
    public function applySetting($index)
    {
        $preset = null;
        switch ($this->activeSettingsTab) {
            case 'tax':
                $preset = $this->taxPresets[$index] ?? null;
                if ($preset && $preset['type'] === 'percentage') {
                    $this->taxRate = $preset['value'];
                }
                break;
            case 'service':
                $preset = $this->servicePresets[$index] ?? null;
                if ($preset && $preset['type'] === 'percentage') {
                    $this->serviceCharge = $preset['value'];
                }
                break;
            case 'discount':
                $preset = $this->discountPresets[$index] ?? null;
                if ($preset) {
                    if ($preset['type'] === 'fixed') {
                        $this->discount = $preset['value'];
                    } else { // percentage
                        $this->discount = ($this->subtotal * $preset['value']) / 100;
                    }
                }
                break;
        }
        $this->showSettingsModal = false;
    }

    public function deleteSetting($index)
    {
        $sessionKey = '';
        $propertyToUpdate = '';

        // Tentukan session key dan properti mana yang akan diupdate
        switch ($this->activeSettingsTab) {
            case 'tax':
                $sessionKey = 'pos_tax_presets';
                $propertyToUpdate = 'taxPresets';
                break;
            case 'service':
                $sessionKey = 'pos_service_presets';
                $propertyToUpdate = 'servicePresets';
                break;
            case 'discount':
                $sessionKey = 'pos_discount_presets';
                $propertyToUpdate = 'discountPresets';
                break;
        }

        if ($sessionKey) {
            // Ambil data dari session
            $presets = session($sessionKey, []);

            // Hapus item berdasarkan index-nya
            if (isset($presets[$index])) {
                unset($presets[$index]);
            }

            // Simpan kembali array yang sudah diupdate ke session
            session([$sessionKey => array_values($presets)]); // array_values untuk re-index

            // Update properti di komponen agar tampilan langsung berubah
            $this->$propertyToUpdate = session($sessionKey);
        }
    }

    public function updatedActiveSettingsTab()
    {
        $this->reset('newSettingType');
    }

    /*
    |--------------------------------------------------------------------------
    | Add Product Modal (Batch Add)
    |--------------------------------------------------------------------------
    */
    public function openProductModal()
    {
        $this->showProductModal = true;
    }

    public function closeProductModal()
    {
        $this->showProductModal = false;
        $this->reset('modalSearch', 'modalSelectedCategory', 'selectedProductQuantities');
    }

    public function selectForBatchAdd($productId)
    {
        $product = Product::findOrFail($productId);
        $this->selectedProductQuantities[$productId] = [
            'id' => $product->id,
            'quantity' => 1,
        ];
    }

    public function increaseTempQuantity($productId)
    {
        if (isset($this->selectedProductQuantities[$productId])) {
            $this->selectedProductQuantities[$productId]['quantity']++;
        }
    }

    public function decreaseTempQuantity($productId)
    {
        if (isset($this->selectedProductQuantities[$productId])) {
            $this->selectedProductQuantities[$productId]['quantity']--;
            if ($this->selectedProductQuantities[$productId]['quantity'] < 1) {
                unset($this->selectedProductQuantities[$productId]);
            }
        }
    }

    public function removeFromTemp($productId)
    {
        unset($this->selectedProductQuantities[$productId]);
    }

    public function submitToCart()
    {
        foreach ($this->selectedProductQuantities as $id => $item) {
            if ($item['quantity'] > 0) {
                $this->addToCart($id);
                // Adjust quantity if it was more than 1
                $this->cartItems[(string)$id]['quantity'] = $this->cartItems[(string)$id]['quantity'] - 1 + $item['quantity'];
            }
        }
        $this->closeProductModal();
        $this->dispatch('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Workflow
    |--------------------------------------------------------------------------
    */

    public function openDiscountModal()
    {
        $this->showDiscountModal = true;
    }
    public function openTaxModal()
    {
        $this->showTaxModal = true;
    }
    public function openServiceModal()
    {
        $this->showServiceModal = true;
    }

    public function openPaymentModal()
    {
        if (empty($this->cartItems)) {
            $this->dispatch('error', 'Keranjang kosong!');
            return;
        }

        $this->newInvoiceNumber = 'BR-' . Carbon::now()->format('YmdHis');

        // $this->amountPaid = $this->totalBill;
        $this->showPaymentModal = true;
    }

    public function processPayment()
    {
        // 1. Validasi input
        $this->validate([
            'customerName' => 'required|string|max:100',
            'amountPaid' => 'required|numeric|min:' . $this->totalBill,
        ], [
            'amountPaid.min' => 'Jumlah bayar tidak boleh kurang dari total tagihan.',
            'customerName.required' => 'Nama pelanggan harus diisi.'
        ]);

        try {
            DB::transaction(function () {
                // 2. Buat record baru di tabel 'orders' sesuai kolom di model Anda
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'id_kasir' => Auth::id(),
                    'nama_kasir' => Auth::user()->name,
                    'no_invoice' => $this->newInvoiceNumber,
                    'customer_name' => $this->customerName,
                    'sub_total' => $this->subtotal,
                    'tax' => $this->taxAmount,
                    'discount' => $this->discount,
                    'total' => $this->totalBill,
                    'payment_amount' => $this->amountPaid,
                    'payment_method' => $this->paymentMethod,
                    'total_item' => count($this->cartItems),
                    'transaction_time' => now(),
                    'status' => $this->orderType,

                    'discount_amount' => 0,
                    'service_charge' => ($this->subtotal * $this->serviceCharge) / 100,
                    'table_number' => 0,
                ]);

                // 3. Loop melalui keranjang untuk menyimpan setiap item ke tabel 'order_items'
                foreach ($this->cartItems as $item) {
                    // Disesuaikan dengan kolom di model OrderItem Anda
                    $order->items()->create([
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    // (Opsional) Kurangi stok produk
                    // Product::find($item['id'])->decrement('stock', $item['quantity']);
                }

                // 5. Simpan detail transaksi terakhir untuk modal sukses
                $this->lastTransactionDetails = [
                    'no_invoice' => $order->no_invoice,
                    'total_bill' => $order->total,
                    'amount_paid' => $order->payment_amount,
                    'change' => $order->payment_amount - $order->total,
                    'sub_total' => $order->sub_total,
                    'tax' => $order->tax,
                    'discount' => $order->discount,
                    'transaction_time' => $order->created_at,
                    'items' => $this->cartItems,
                    'service_charge' => $order->service_charge,
                    'status' => $order->status,
                    // Hitung kembalian di sini
                    'change' => $order->payment_amount - $order->total,
                ];

                // 6. Ganti tampilan modal
                $this->showSuccessModal = true;
            });
        } catch (\Exception $e) {
            $this->dispatch('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function setExactAmount()
    {
        $this->amountPaid = $this->totalBill;
    }

    public function setRoundUpAmount()
    {
        $total = $this->totalBill;
        $this->amountPaid = ceil($total / 1000) * 1000;
    }

    public function newOrder()
    {
        $this->reset([
            'cartItems',
            'customerName',
            'amountPaid',
            'taxRate',
            'discount',
            'serviceCharge',
            'newInvoiceNumber',
            'lastTransactionDetails',
            'showPaymentModal',
            'showProductModal',
            'showSettingsModal',
            'showSuccessModal',
        ]);

        $this->cartItems = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Render Method
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.pos.home-pos', [
            'products'   => $this->products,
            'categories' => $this->categories,
            'subtotal'   => $this->subtotal,
        ])->layout('layouts.pos');
    }
}
