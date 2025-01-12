<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function storeRating(Request $request, $slug)
    {
        // Validasi input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Cari toko berdasarkan slug
        $shop = ShopProfile::where('slug', $slug)->firstOrFail();

        // Simpan rating dan komentar
        Rating::create([
            'shop_profile_id' => $shop->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        if ($request->ajax()) {
            return $this->fetchRatings($request, $slug);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('shop-pages.shop_details', $slug)->with('success', 'Thank you for your feedback!');
    }

    public function fetchComments(Request $request, $shopId)
    {
        $shop = ShopProfile::findOrFail($shopId);
        $comments = Rating::where('shop_profile_id', $shop->id)
            ->paginate(5); // Batasi jumlah komentar per halaman

        return response()->json($comments);
    }

    public function index()
    {
        // Ambil toko yang dimiliki oleh pengguna yang login
        $shops = ShopProfile::where('user_id', Auth::id())->get();

        // Ambil toko pertama milik pengguna sebagai default
        $selectedShop = $shops->first();

        // Ambil komentar dan rating untuk toko yang dipilih (atau null jika tidak ada toko)
        $ratings = $selectedShop
            ? Rating::where('shop_profile_id', $selectedShop->id)->latest()->paginate(5)
            : null;

        return view('pages.ratings.index', compact('shops', 'selectedShop', 'ratings'));
    }

    public function fetchCommentsAdmin($shopId, Request $request)
    {
        $comments = Rating::where('shop_profile_id', $shopId)
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Batasi 5 komentar per halaman
    
        return response()->json($comments);
    }    

    public function deleteComment($id)
    {
        // Pastikan komentar milik toko yang dimiliki pengguna yang login
        $rating = Rating::whereHas('shop', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $rating->delete();

        return response()->json(['success' => 'Comment deleted successfully.']);
    }
}
