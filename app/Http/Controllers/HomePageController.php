<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\AdminProfile;
use App\Models\Ads;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShopProfile;
use App\Models\Visitor;
use Illuminate\Http\Request;
use GeoIP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index()
    {
        $profile = AdminProfile::first();
        if ($profile) {
            if ($profile->about_ourselves) {
                $profile->about_ourselves = json_decode($profile->about_ourselves, true); // Decode ke array
            }
            if ($profile->difference_of_us) {
                $profile->difference_of_us = json_decode($profile->difference_of_us, true); // Decode ke array
            }
            if ($profile->difference_of_us_items) {
                $profile->difference_of_us_items = json_decode($profile->difference_of_us_items, true); // Decode ke array
            }
        }
        return view('home-pages.index', compact('profile'));
    }
    public function outlet()
    {
        $shops = ShopProfile::paginate(1);
        return view('home-pages.outlet', compact('shops'));
    }
    public function outlet_details(Request $request, $slug)
    {

        $shop = ShopProfile::with('location')->where('slug', $slug)->firstOrFail();


        $orderCounts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_ordered'))
            ->groupBy('product_id');

        $bestSellerProducts = Product::leftJoinSub($orderCounts, 'order_counts', function ($join) {
            $join->on('products.id', '=', 'order_counts.product_id');
        })
            ->select('products.*', DB::raw('COALESCE(order_counts.total_ordered, 0) as total_ordered'))
            ->where('products.user_id', $shop->user_id)
            ->orderByDesc('total_ordered')
            ->take(5)
            ->get();
        $location = null;
        Visitor::create([
            'shop_id' => $shop->id,
            'ip_address' => $ip ?? null,
            'iso_code' => $location ? $location->countryCode : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = $shop->user;
        $averageRating = $shop->ratings->isNotEmpty() ? $shop->ratings->avg('rating') : 0;

        $products = Product::where('status', true)
            ->where('user_id', $user->id)
            ->paginate(6);

        $ratings = $shop->ratings()->orderBy('created_at', 'desc')->get();

        $categories = Category::whereHas('products', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', true);
        })->get();

        // ads
        $ads = Ads::where('shop_id', $shop->id)->inRandomOrder()->first();
        if ($ads) {
            $ads->increment('views');
        }
        return view('home-pages.outlet-detail', compact('ads', 'shop', 'averageRating', 'products', 'categories', 'ratings', 'bestSellerProducts'));
    }
    public function bomiProduct(Request $request)
    {
        $query = AdminProduct::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $adminproducts = $query->paginate(10);
        return view('home-pages.bomi-product', compact('adminproducts'));
    }
}
