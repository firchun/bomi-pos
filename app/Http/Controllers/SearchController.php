<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ShopProfile;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'q' => 'required|string|max:255',
        ]);

        // Ambil input pencarian
        $query = $request->input('q');

        // Cari produk berdasarkan nama yang dimulai dengan huruf yang diketik
        $products = Product::where('status', true)
            ->where(function ($q) use ($query) {
                // Cari produk yang nama depannya sesuai dengan input
                $q->where('name', 'LIKE', "{$query}%");
            })
            ->paginate(12);

        // Ambil semua toko terkait berdasarkan user_id produk
        $shops = ShopProfile::whereIn('user_id', $products->pluck('user_id'))->get();

        // Return ke view hasil pencarian
        return view('homepage.search-results', compact('products', 'query', 'shops'));
    }


    public function ajaxSearch(Request $request)
    {
        $query = $request->input('query');

        // Pastikan query lebih dari 0 karakter
        if (strlen($query) > 0) {
            // Cari produk yang dimulai dengan huruf pertama input query
            $products = Product::where('name', 'like', "{$query}%")
                ->limit(10)  // Batasi hasil pencarian
                ->get();
        } else {
            $products = [];
        }

        return response()->json(['products' => $products]);
    }

    public function getProductDetails(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        return response()->json(['product' => $product]);
    }
}
