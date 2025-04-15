<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
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
        // Subquery untuk total pesanan per produk
        $orderCounts = OrderItem::select('product_id', DB::raw('COALESCE(SUM(quantity), 0) as total_ordered'))
            ->groupBy('product_id');

        // Ambil kategori dengan 3 produk terpopuler
        $popularCategories = Category::with(['products' => function ($query) use ($orderCounts) {
            $query->leftJoinSub($orderCounts, 'order_counts', function ($join) {
                $join->on('products.id', '=', 'order_counts.product_id');
            })
                ->select('products.*', DB::raw('COALESCE(order_counts.total_ordered, 0) as total_ordered'))
                ->where('products.user_id', Auth::id())
                ->orderByDesc('total_ordered')
                ->take(3);
        }])->get();
        $shop = ShopProfile::where('user_id', Auth::id())->first();
        $data = [
            'admin' => User::where('role', 'admin')->count(),
            'user' => User::where('role', 'user')->count(),
            'average_rating' => round(Rating::where('shop_profile_id', $shop->id)->avg('rating'), 2),
            'product' => $product->count(),
            'popularCategories' => $popularCategories,
        ];
        return view('pages.dashboard', $data);
    }

    public function getTransactionData(Request $request)
    {
        $filter = $request->input('filter', 'week');
        $now = Carbon::now();

        // Data untuk chart
        if ($filter == 'week') {
            $startDate = $now->copy()->subDays(6); // 7 hari terakhir termasuk hari ini
            $endDate = $now;
            $interval = 'day';
            $periods = 7;
        } elseif ($filter == 'month') {
            $startDate = $now->copy()->subDays(30); // 31 hari terakhir termasuk hari ini
            $endDate = $now;
            $interval = 'day';
            $periods = 31;
        } elseif ($filter == 'year') {
            $startDate = $now->copy()->subMonths(11)->startOfMonth(); // 12 bulan terakhir termasuk bulan ini
            $endDate = $now;
            $interval = 'month';
            $periods = 12;
        }


        $labels = [];
        $data = [];

        for ($i = 0; $i < $periods; $i++) {
            if ($interval == 'day') {
                $currentDate = $startDate->copy()->addDays($i);
                $dateString = $currentDate->format('Y-m-d');
                $total = Order::whereDate('transaction_time', $dateString)->where('id_kasir', Auth::id())
                    ->sum('total');
                $labels[] = $dateString;
            } else {
                $currentMonth = $startDate->copy()->addMonths($i);
                $monthStart = $currentMonth->startOfMonth()->toDateTimeString();
                $monthEnd = $currentMonth->endOfMonth()->toDateTimeString();
                $total = Order::whereBetween('transaction_time', [$monthStart, $monthEnd])->where('id_kasir', Auth::id())->sum('total');
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
            'week' => Order::whereBetween('transaction_time', [$now->copy()->subDays(6)->toDateTimeString(), $now->toDateTimeString()])->sum('total'),
            'month' => Order::whereBetween('transaction_time', [$now->copy()->subDays(30)->toDateTimeString(), $now->toDateTimeString()])->sum('total'),
            'year' => Order::whereBetween('transaction_time', [$now->copy()->subMonths(11)->startOfMonth()->toDateTimeString(), $now->toDateTimeString()])->sum('total')
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
    public function login()
    {
        return view('pages.auth.login');
    }
    public function register()
    {
        return view('pages.auth.register');
    }
    public function getDashboardData(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $table = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('id_kasir', Auth::id())
            ->whereNotNull('table_number')
            ->count();

        $discount = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('id_kasir', Auth::id())
            ->where('discount', '>', 0)
            ->count();

        $service_charge = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('id_kasir', Auth::id())
            ->count() - $table - $discount;

        $balance = number_format(Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('id_kasir', Auth::id())
            ->sum('total'), 2);

        $sales = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('id_kasir', Auth::id())
            ->sum('total_item');
        $ratings = Rating::where('shop_profile_id', Auth::id())->count();

        $topProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->where('user_id', Auth::id())
            ->take(5)
            ->get(['name', 'price', 'budget'])
            ->map(function ($product) {
                $product->total_price = $product->price * $product->orders_count;
                return $product;
            });

        return response()->json([
            'order' => [
                'table' => $table,
                'discount' => $discount,
                'service_charge' => $service_charge,
                'total' => $table + $discount + $service_charge,
            ],
            'balance' => $balance,
            'sales' => $sales,
            'ratings' => $ratings,
            'top_products' => $topProducts
        ]);
    }
    public function getReviews(Request $request)
    {
        $shop = ShopProfile::where('user_id', Auth::id())->first();

        $reviews = Rating::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($review) {
                return [
                    'message' => $review->comment ?? 'No message',
                    'time_ago' => $review->created_at->diffForHumans(),
                ];
            });
        $total = Rating::where('shop_profile_id', $shop->id)->count();

        return response()->json([
            'total' => $total,
            'reviews' => $reviews
        ]);
    }
}
