<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $product = Product::query();
        if (Auth::user()->role == 'user') {
            $product->where('user_id', Auth::id());
        }
        $categories = Category::query();
        if (Auth::user()->role == 'user') {
            $categories->where('user_id', Auth::id());
        }
        $data = [
            'admin' => User::where('role', 'admin')->count(),
            'user' => User::where('role', 'user')->count(),
            'categories' => $categories->count(),
            'product' => $product->count(),
        ];
        return view('pages.dashboard', $data);
    }
    public function profile()
    {
        $product = Product::query();
        if (Auth::user()->role == 'user') {
            $product->where('user_id', Auth::id());
        }
        $categories = Category::query();
        if (Auth::user()->role == 'user') {
            $categories->where('user_id', Auth::id());
        }
        $orders = Order::query();
        if (Auth::user()->role == 'user') {
            $orders->where('user_id', Auth::id());
        }
        $data = [
            'orders' => $orders->count(),
            'categories' => $categories->count(),
            'product' => $product->count(),
        ];
        return view('pages.profile', $data);
    }
}