@section('title', $shop->name . ' | Bomi POS')
@section('meta-title', $shop->name . ' | Bomi POS')
@section('meta-description', $shop->description)
@section('meta-keywords', $shop->name)

@section('meta-og-title', $shop->name . ' | Bomi POS')
@section('meta-og-description', $shop->description)
@section('meta-og-image', $shop->photo)
@section('meta-og-url', url()->current())
@section('meta-twitter-image', asset('storage/' . $shop->photo))
@section('meta-og-image', asset('storage/' . $shop->photo))
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" />
    <title>@yield('title', 'Bomi POS - Aplikasi Kasir Terbaik')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('home2') }}/assets/svg/logo.svg" type="image/png" />

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', 'Bomi Pos adalah aplikasi dan web kasir untuk usaha retail dan restoran. Kelola penjualan, stok, laporan, dan pembayaran dengan mudah dan cepat.')">
    <meta name="keywords" content="@yield('meta-keywords', 'aplikasi kasir, web kasir, kasir restoran, kasir retail, aplikasi POS, sistem kasir online, software kasir, Bomi Pos')">
    <meta name="author" content="Bomi Pos">
    <meta name="robots" content="index, follow" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="@yield('meta-og-title', 'Bomi Pos - Aplikasi dan Web Kasir untuk Retail & Restoran')" />
    <meta property="og:description" content="@yield('meta-og-description', 'Gunakan Bomi Pos untuk mengelola penjualan, stok, keuangan, dan laporan usaha Anda secara efisien. Cocok untuk UMKM hingga bisnis skala besar.')" />
    <meta property="og:image" content="@yield('meta-og-image', asset('home2/assets/img/logo-bomipos.png'))" />
    <meta property="og:url" content="@yield('meta-og-url', url()->current())" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('meta-twitter-title', 'Bomi Pos - Solusi Kasir Modern untuk Bisnis Anda')" />
    <meta name="twitter:description" content="@yield('meta-twitter-description', 'Bomi Pos menyediakan sistem kasir online berbasis aplikasi dan web untuk mendukung operasional toko dan restoran Anda.')" />
    <meta name="twitter:image" content="@yield('meta-twitter-image', asset('home2/assets/img/logo-bomipos.png'))" />
    <!-- Tailwind & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @media (max-width: 499px) {
            .xs\:block {
                display: block !important;
            }

            .xs\:inline-block {
                display: inline-block !important;
            }

            .xs\:flex {
                display: flex !important;
            }

            .xs\:hidden {
                display: none !important;
            }
        }

        @media (min-width: 500px) {

            .xs\:block,
            .xs\:inline-block,
            .xs\:flex {
                display: none !important;
            }
        }
    </style>


</head>

<body
    class="min-h-screen bg-[url('{{ asset('home2') }}/assets/svg/background.svg')] bg-cover bg-center scroll-smooth transition-colors duration-600">
    <!-- Loading Screen -->
    <div id="loading"
        class="flex items-center justify-center h-screen w-screen bg-white/50 backdrop-blur-lg z-50 fixed top-0 left-0 transition-colors duration-300">
        <div class="flex flex-col items-center">
            <!-- Logo -->
            <img src="{{ asset('home2') }}/assets/svg/logo.svg" alt="Logo" class="w-16 h-16 mb-4" />
            <p class="text-purple-700 font-medium text-sm">Loading...</p>
        </div>
    </div>
    <!-- Main Content -->
    <div class=" ">
        <div class="max-w-md mx-auto">
            <header class="sticky top-0 z-50 bg-purple-700/90 backdrop-blur-lg p-4 ">
                <div class="flex justify-center items-center">
                    <h3 class="text-2xl font-bold text-white">
                        Order {{ $table->name }}
                        <br>
                        <small class="text-sm">{{ $shop->name }}</small>
                    </h3>
                </div>
            </header>

            <div class="mt-4 pb-4 px-4">

                <!-- Product List -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Menu</h2>

                <div class="overflow-x-auto mb-4">
                    <div class="flex space-x-4">
                        <button class="px-4 py-2 bg-purple-500 text-white rounded-lg whitespace-nowrap">Makanan</button>
                        <button
                            class="px-4 py-2 bg-purple-500  text-white rounded-xl whitespace-nowrap">Minuman</button>
                        <button class="px-4 py-2 bg-purple-500 text-white rounded-xl whitespace-nowrap">Snack</button>
                        <button class="px-4 py-2 bg-purple-500 text-white rounded-xl whitespace-nowrap">Dessert</button>
                        <button class="px-4 py-2 bg-purple-500 text-white rounded-xl whitespace-nowrap">Paket
                            Hemat</button>

                    </div>
                </div>
                <div class="flex flex-col gap-4 mb-[200px]" id="product-list">
                    @foreach ($products as $product)
                        <div class="bg-white shadow rounded-2xl overflow-hidden flex items-center">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="w-24 h-24 object-cover ml-2 rounded-lg">
                            <div class="flex-1 p-3">
                                <h3 class="font-semibold text-base text-gray-800 mb-1">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}

                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center justify-start gap-2">
                                        <button
                                            class="bg-red-600 text-white px-3 py-1 rounded-full text-2xl minus-to-cart"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                            -
                                        </button>
                                        <button
                                            class="bg-purple-600 text-white px-3 py-1 rounded-full text-2xl add-to-cart"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                            +
                                        </button>
                                    </div>
                                    <div
                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-600 text-white font-bold text-lg">
                                        <span class="quantity" data-id="{{ $product->id }}">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Floating Cart -->
        <div id="floating-cart"
            class="fixed bottom-4 left-1/2 -translate-x-1/2 bg-purple-600 text-white px-6 py-3 rounded-2xl hidden flex items-center gap-3 border border-white border-3">

            <div class="flex items-center justify-center bg-white text-purple-700 font-bold rounded-full w-10 h-10">
                <span id="total-item">0</span>
            </div>
            <button class="font-semibold text-lg">Order</button>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let cart = {};
                const productsPaginated = @json($products);
                const productData = productsPaginated.data; // <= aman
                const updateFloatingCart = () => {
                    const total = Object.values(cart).reduce((sum, qty) => sum + qty, 0);
                    document.getElementById('total-item').innerText = total;
                    const floatingCart = document.getElementById('floating-cart');
                    if (total > 0) {
                        floatingCart.classList.remove('hidden');
                    } else {
                        floatingCart.classList.add('hidden');
                    }
                };

                document.querySelectorAll('.add-to-cart').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        if (!cart[id]) {
                            cart[id] = 1;
                        } else {
                            cart[id]++;
                        }
                        document.querySelector(`.quantity[data-id="${id}"]`).innerText = cart[id];
                        updateFloatingCart();
                    });
                });

                document.querySelectorAll('.minus-to-cart').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        if (cart[id] && cart[id] > 0) {
                            cart[id]--;
                        }
                        if (cart[id] <= 0) {
                            delete cart[id];
                        }
                        document.querySelector(`.quantity[data-id="${id}"]`).innerText = cart[id] ?? 0;
                        updateFloatingCart();
                    });
                });

                document.getElementById('floating-cart').addEventListener('click', () => {
                    let totalPrice = 0;
                    let orderHtml = "";

                    for (const [id, qty] of Object.entries(cart)) {
                        const product = productData.find(p => p.id == id);
                        console.log(productData);
                        if (!product) {
                            console.warn(`Produk dengan id ${id} tidak ditemukan!`);
                            continue;
                        }

                        const subtotal = product.price * qty;
                        totalPrice += subtotal;
                        orderHtml += `
                        <tr>
                            <td>${product.name}</td>
                            <td class="text-center">${qty}</td>
                            <td class="text-right">${subtotal.toLocaleString('id-ID')}</td>
                        </tr>
                    `;
                    }

                    const modalHtml = `
                    <div id="order-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                            <h2 class="text-xl font-bold mb-4">Konfirmasi Pesanan</h2>
                            <table class="w-full text-sm mb-4">
                                <thead>
                                    <tr><th>Nama</th><th>Qty</th><th>Subtotal</th></tr>
                                </thead>
                                <tbody>${orderHtml}</tbody>
                            </table>
                            <div class="flex justify-between font-bold mb-4">
                                <span>Total:</span><span class="text-red-700">Rp ${totalPrice.toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-center gap-2">
                                <button id="close-modal" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                                <button class="px-4 py-2 bg-purple-600 text-white rounded-lg" id="confirm-order">Konfirmasi</button>
                            </div>
                        </div>
                    </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);

                    // pasang event setelah elemen muncul
                    document.querySelector('#close-modal').addEventListener('click', () => {
                        document.querySelector('#order-modal').remove();
                    });
                    document.querySelector('#confirm-order').addEventListener('click', () => {
                        document.querySelector('#order-modal').remove();

                        const successModal = `
                        <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                          <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center">
                            
                            <!-- Icon centang biru -->
                            <div class="flex justify-center mb-4">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                              </svg>
                            </div>

                            <h2 class="text-xl font-bold mb-2 text-green-600">Pesanan Berhasil!</h2>
                            <p class="mb-2 text-gray-600">Pesanan Anda telah diterima dan sedang diproses.</p>
                            
                            <!-- Total Pembayaran -->
                            <p class="mb-2 text-lg font-semibold text-gray-800 p-2 bg-gray-300 rounded-2xl"><span >{{ $table->name }}</span></p>
                            <p class="mb-4 text-lg font-semibold text-gray-800 p-2 bg-gray-300 rounded-2xl">Total Pembayaran: <span >Rp ${totalPrice.toLocaleString('id-ID')}</span></p>

                            <button id="close-success-modal" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Tutup</button>
                          </div>
                        </div>
                      `;
                        document.body.insertAdjacentHTML('beforeend', successModal);

                        document.querySelector('#close-success-modal').addEventListener('click', () => {
                            document.querySelector('#success-modal').remove();
                            cart = {};
                            document.querySelectorAll('.quantity').forEach(span => span
                                .innerText = 0);
                            updateFloatingCart();
                        });
                    });
                });
            });
        </script>
        <script>
            // Loading Screen
            window.addEventListener("DOMContentLoaded", () => {
                setTimeout(() => {
                    document.getElementById("loading").style.display = "none";
                    document.getElementById("content").classList.remove("hidden");
                }, 500); // 2 detik
            });
        </script>
    </div>
</body>
