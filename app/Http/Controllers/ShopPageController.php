<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ShopProfile;
use Illuminate\Http\Request;

class ShopPageController extends Controller
{
    public function shop_page()
    {
        $shops = ShopProfile::all();
        return view('shop-pages.shop_page', compact('shops'));
    }

    public function shop_details(Request $request, $slug)
    {
        // Ambil data shop berdasarkan slug
        $shop = ShopProfile::where('slug', $slug)->firstOrFail();

        // Ambil user yang memiliki shop ini
        $user = $shop->user;

        // Menghitung rata-rata rating jika ada ratings terkait
        $averageRating = $shop->ratings->isNotEmpty() ? $shop->ratings->avg('rating') : 0;

        // Ambil produk berdasarkan status dan user_id yang sesuai, dan lakukan pagination
        $products = Product::where('status', true)
            ->where('user_id', $user->id)
            ->paginate(6);

        // Ambil data komentar dengan pagination, urutkan berdasarkan waktu input terbaru
        $ratings = $shop->ratings()->orderBy('created_at', 'desc')->paginate(5);

        // Ambil kategori produk berdasarkan user_id
        $categories = Category::whereHas('products', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', true); // Pastikan hanya produk aktif
        })->get();

        // Kembalikan view dengan data shop, rata-rata rating, produk, kategori, dan komentar
        return view('shop-pages.shop_details', compact('shop', 'averageRating', 'products', 'categories', 'ratings'));
    }

    public function fetchProducts(Request $request, $shopId)
    {
        $shop = ShopProfile::findOrFail($shopId);

        // Ambil user yang memiliki shop ini
        $user = $shop->user;

        $products = Product::where('user_id', $shop->user_id)
            ->paginate(6); // Batasi jumlah produk per halaman

        // Ambil kategori produk berdasarkan user_id
        $categories = Category::whereHas('products', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', true); // Pastikan hanya produk aktif
        })->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
