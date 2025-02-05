<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect('login');
        }
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

    public function getTransactionData(Request $request)
    {
        $filter = $request->input('filter', 'week');
        $now = Carbon::now();
    
        // Data untuk chart
        if ($filter == 'week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
            $interval = 'day';
            $periods = 7;
        } elseif ($filter == 'month') {
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
            $interval = 'day';
            $periods = $startDate->daysInMonth;
        } elseif ($filter == 'year') {
            $startDate = $now->copy()->startOfYear();
            $endDate = $now->copy()->endOfYear();
            $interval = 'month';
            $periods = 12;
        }
    
        $labels = [];
        $data = [];
    
        for ($i = 0; $i < $periods; $i++) {
            if ($interval == 'day') {
                $currentDate = $startDate->copy()->addDays($i);
                $dateString = $currentDate->format('Y-m-d');
                $total = Order::whereDate('transaction_time', $dateString)->sum('total');
                $labels[] = $dateString;
            } else {
                $currentMonth = $startDate->copy()->addMonths($i);
                $monthStart = $currentMonth->startOfMonth()->toDateTimeString();
                $monthEnd = $currentMonth->endOfMonth()->toDateTimeString();
                $total = Order::whereBetween('transaction_time', [$monthStart, $monthEnd])->sum('total');
                $labels[] = $currentMonth->format('F');
            }
            $data[] = $total;
        }
    
        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getSalesStatistics()
    {
        $now = Carbon::now();
    
        return response()->json([
            'today' => Order::whereDate('transaction_time', $now->toDateString())->sum('total'),
            'week' => Order::whereBetween('transaction_time', [$now->startOfWeek()->toDateTimeString(), $now->endOfWeek()->toDateTimeString()])->sum('total'),
            'month' => Order::whereBetween('transaction_time', [$now->startOfMonth()->toDateTimeString(), $now->endOfMonth()->toDateTimeString()])->sum('total'),
            'year' => Order::whereBetween('transaction_time', [$now->startOfYear()->toDateTimeString(), $now->endOfYear()->toDateTimeString()])->sum('total')
        ]);
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
    public function login(){
        return view('pages.auth.login');
    }
    public function register(){
        return view('pages.auth.register');
    }
}