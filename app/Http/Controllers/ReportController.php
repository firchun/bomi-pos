<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
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

   public function dailyReportDatatable(Request $request)
{
    
    $fromDate = $request->input('form-date');
    $toDate = $request->input('to-date');
    $paymentMethod = $request->input('payment_method');

    $ordersQuery = Order::query()->orderBy('created_at', 'desc');
    if ($request->has('from-date') && $request->has('to-date')) {
        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');
        if ($fromDate != '' && $toDate != '') {
            $fromDate = Carbon::parse($fromDate)->startOfDay()->toDateTimeString();
            $toDate = Carbon::parse($toDate)->endOfDay()->toDateTimeString();

                $ordersQuery->whereBetween('created_at', [$fromDate, $toDate]);
        
        }
    }
    if($paymentMethod) {
        $ordersQuery->where('payment_method', 'like', '%' . $paymentMethod . '%');
    }

    return DataTables::of($ordersQuery)
        ->addColumn('transaction_time', function ($order) {
            return \Carbon\Carbon::parse($order->transaction_time)->format('d F Y') . '<br> <small class="text-muted">' . \Carbon\Carbon::parse($order->transaction_time)->format('H:i') . ' WIT</small>  ';
        })
        ->addColumn('detail_button', function ($order) {
            return '<a href="' . route('report.show', $order->id) . '" class="btn btn-sm btn-primary">View</a>';
        })
        ->rawColumns(['detail_button','transaction_time']) // agar tombol HTML tidak di-escape
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
