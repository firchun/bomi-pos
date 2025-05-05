<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
            'comment' => 'nullable|string',
        ]);

        // Cari toko berdasarkan slug
        $shop = ShopProfile::where('slug', $slug)->firstOrFail();

        // Simpan rating dan komentar
        Rating::create([
            'shop_profile_id' => $shop->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        if ($shop->user_id) {
            Notification::create([
                'id_user' => $shop->user_id,
                'message' => 'You received a new rating of ' . $request->rating . ' stars' .
                    ($request->comment ? ' with comment: "' . $request->comment . '"' : '') . '.',
                'read_at' => null,
            ]);
        }


        if ($request->ajax()) {
            return $this->fetchRatings($request, $slug);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('shop.details', $slug)->with('success', 'Thank you for your feedback!');
    }

    public function fetchComments(Request $request, $shopId)
    {
        $shop = ShopProfile::findOrFail($shopId);
        $keyword = $request->input('keyword'); // Ambil keyword dari input

        $comments = Rating::where('shop_profile_id', $shop->id)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('comment', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    public function index()
    {

        $shop = ShopProfile::where('user_id', Auth::id())->first();



        // Ambil komentar dan rating untuk toko yang dipilih (atau null jika tidak ada toko)
        $ratings = $shop
            ? Rating::where('shop_profile_id', $shop->id)->latest()->paginate(5)
            : null;

        return view('pages.ratings.index', compact('shop', 'ratings'));
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
