<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\IngredientDish;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function dailyReport(Request $request)
    {

        return view('pages.report.index');
    }
    public function productReport(Request $request)
    {

        return view('pages.report.product');
    }
    public function ingredientReport(Request $request)
    {
        $data = [
            'title' => 'Ingredient Report',
            'category' => IngredientCategory::where('id_user', Auth::id())->get(),
            'ingredient' => Ingredient::where('id_user', Auth::id())->with(['category'])->paginate(10),
        ];
        return view('pages.report.ingredient',$data);
    }

    public function ingredientReportDatatable(Request $request)
    {
        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');
        $category = $request->input('category');
    
        // Query produk
        $ingredientQuery = Ingredient::where('id_user', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc');
    
        if ($category) {
            $ingredientQuery->where('id_category', $category);
        }
    
        return DataTables::of($ingredientQuery)
        ->addColumn('qty', function ($ingredient) use ($fromDate, $toDate) {
            $total = 0;
            $fromDateParsed = $fromDate ? \Carbon\Carbon::parse($fromDate)->startOfDay() : null;
            $toDateParsed = $toDate ? \Carbon\Carbon::parse($toDate)->endOfDay() : null;
    
            // Ambil semua relasi produk yang memakai ingredient ini
            $ingredientUsages = IngredientDish::where('id_ingredient', $ingredient->id)->get();
        
            foreach ($ingredientUsages as $usage) {
                // Cari jumlah produk terjual untuk produk terkait
                $orderQty = OrderItem::where('product_id', $usage->id_product)
                ->whereBetween('created_at', [$fromDateParsed, $toDateParsed])
                ->sum('quantity');
        
                // Kalikan dengan kebutuhan ingredient-nya
                $total += $usage->qty * $orderQty;
            }
        
            return number_format($total, 2);
        })
          
            ->rawColumns(['qty'])
            ->make(true);
    }
    public function productReportDatatable(Request $request)
    {
        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');
        $category = $request->input('category');
    
        // Parse tanggal jika tersedia
        $fromDateParsed = $fromDate ? Carbon::parse($fromDate)->startOfDay() : null;
        $toDateParsed = $toDate ? Carbon::parse($toDate)->endOfDay() : null;
    
        // Query produk
        $productQuery = Product::where('user_id', Auth::id())
            ->with('category')
            ->withCount(['order_items as total_order' => function ($query) use ($fromDateParsed, $toDateParsed) {
                if ($fromDateParsed && $toDateParsed) {
                    $query->whereBetween('created_at', [$fromDateParsed, $toDateParsed]);
                }
            }])
            ->withSum(['order_items as total_price' => function ($query) use ($fromDateParsed, $toDateParsed) {
                if ($fromDateParsed && $toDateParsed) {
                    $query->whereBetween('created_at', [$fromDateParsed, $toDateParsed]);
                }
            }], DB::raw('quantity * price'))
            ->orderBy('created_at', 'desc');
    
        if ($category) {
            $productQuery->where('category_id', $category);
        }
    
        return DataTables::of($productQuery)
            ->addColumn('total_order', function ($product) {
                return $product->total_order ?? 0;
            })
            ->addColumn('total_price', function ($product) {
                return number_format($product->total_price ?? 0);
            })
            ->addColumn('profit', function ($product) {
                $totalRevenue = $product->total_price ?? 0;
                $totalHpp = ($product->hpp ?? 0) * ($product->total_order ?? 0);
                $profit = $totalRevenue - $totalHpp;
                return number_format($profit);
            })
            ->rawColumns(['total_order', 'total_price','profit'])
            ->make(true);
    }
    public function dailyReportDatatable(Request $request)
    {

        $fromDate = $request->input('form-date');
        $toDate = $request->input('to-date');
        $fromTime = $request->input('form-time');
        $toTime = $request->input('to-time');
        $paymentMethod = $request->input('payment_method');

        $ordersQuery = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        if ($request->has('from-date') && $request->has('to-date')) {
            $fromDate = $request->input('from-date');
            $toDate = $request->input('to-date');
            if ($fromDate != '' && $toDate != '') {
                $fromDate = Carbon::parse($fromDate)->startOfDay()->toDateTimeString();
                $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

                $ordersQuery->whereBetween('created_at', [$fromDate, $toDate]);
            }
        }
        if ($request->has('from-time') && $request->has('to-time')) {
            $fromTimeRaw = $request->input('from-time'); // e.g. "06:00"
            $toTimeRaw = $request->input('to-time');     // e.g. "18:00"
        
            if (!empty($fromTimeRaw) && !empty($toTimeRaw)) {
                // Parsing sebagai waktu menggunakan Carbon
                $fromTime = Carbon::createFromFormat('H:i', $fromTimeRaw)->format('H:i:s');
                $toTime = Carbon::createFromFormat('H:i', $toTimeRaw)->format('H:i:s');
        
                $ordersQuery->whereTime('created_at', '>=', $fromTime)
                            ->whereTime('created_at', '<=', $toTime);
            }
        }
        if ($paymentMethod) {
            $ordersQuery->where('payment_method', 'like', '%' . $paymentMethod . '%');
        }

        return DataTables::of($ordersQuery)
            ->addColumn('transaction_time', function ($order) {
                return \Carbon\Carbon::parse($order->transaction_time)->format('d F Y') . '<br> <small class="text-muted">' . \Carbon\Carbon::parse($order->transaction_time)->format('H:i') . ' WIT</small>  ';
            })
            ->addColumn('detail_button', function ($order) {
                return '<a href="' . route('report.show', $order->id) . '" class="btn btn-sm btn-primary"><i class="fa fa-file"></i> Invoice</a>';
            })
            ->rawColumns(['detail_button', 'transaction_time']) // agar tombol HTML tidak di-escape
            ->make(true);
    }

    // ReportController.php
    public function show($id)
    {
        $user = Auth::user();
        // Ambil data OrderItem dengan relasi ke Order dan Product
        $orderItems = OrderItem::with(['order', 'product'])
            ->where('order_id', $id)
            ->get();

        // Ambil Order berdasarkan ID
        $order = Order::findOrFail($id);

        // Ambil data toko
        $shop = ShopProfile::first();

        // Hitung total sebelum diskon, tax, service charge
        $totalProduk = $orderItems->sum(fn($item) => $item->quantity * $item->price);

        // Hitung total setelah diskon, tax, dan service charge
        $totalFinal = ($totalProduk - $order->discount_amount) + $order->tax + $order->service_charge;

        return view('pages.report.show', compact('order', 'orderItems', 'shop', 'totalProduk', 'totalFinal'));
    }

    public function printTransaction($id)
    {
        $user = Auth::user();
        // Ambil data OrderItem dengan relasi ke Product
        $orderItems = OrderItem::with('product')
            ->where('order_id', $id)
            ->get();

        // Ambil Order berdasarkan ID
        $order = Order::findOrFail($id);

        // Ambil data toko
        $shop = ShopProfile::first();

        // Hitung total sebelum diskon, tax, service charge
        $totalProduk = $orderItems->sum(fn($item) => $item->quantity * $item->price);

        // Hitung total setelah diskon, tax, dan service charge
        $totalFinal = ($totalProduk - $order->discount_amount) + $order->tax + $order->service_charge;

        return view('pages.report.print-transaction', compact('order', 'orderItems', 'shop', 'totalProduk', 'totalFinal'));
    }
}
