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
        // Ambil toko dari user yang sedang login
        $user = Auth::user();
        $date = $request->input('date');
        $search = $request->input('search')['value'] ?? '';
        $orderColumn = $request->input('order')[0]['column'] ?? 2; // Urut berdasarkan tanggal transaksi
        $orderDir = $request->input('order')[0]['dir'] ?? 'desc';
        $columns = ['id', 'no_invoice', 'transaction_time', 'total_item', 'total'];

        $ordersQuery = Order::query()
            ->when($date, function ($query, $date) {
                $query->whereDate('transaction_time', $date);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('no_invoice', 'like', '%' . $search . '%')
                        ->orWhere('transaction_time', 'like', '%' . $search . '%');
                });
            });

        // Sorting berdasarkan tanggal terbaru
        $ordersQuery->orderBy($columns[$orderColumn], $orderDir);

        // Total records
        $recordsTotal = Order::count();
        $recordsFiltered = $ordersQuery->count();

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orders = $ordersQuery->skip($start)->take($length)->get();

        // Total revenue
        $totalRevenue = $ordersQuery->sum('total');

        $reportData = [];
        foreach ($orders as $order) {
            $reportData[] = [
                'id' => $order->id,
                'no_invoice' => $order->no_invoice ?? '-',
                'tanggal_transaksi' => Carbon::parse($order->transaction_time)->format('d/m/Y H:i'),
                'jumlah_beli' => $order->total_item,
                'total_keseluruhan' => $order->total,
                'detail_button' => '<a href="' . route('report.show', $order->id) . '" class="btn btn-sm btn-primary">View</a>'
            ];
        }

        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $reportData,
                'totalRevenue' => $totalRevenue,
            ]);
        }

        return view('pages.report.index', compact('date'));
    }
    public function dailyReportDatatable(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date');

        $ordersQuery = Order::query()
            ->when($date, function ($query, $date) {
                $query->whereDate('transaction_time', $date);
            });

        return DataTables::of($ordersQuery)
            ->filter(function ($query) use ($request) {
                $search = $request->input('search.value');
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('no_invoice', 'like', "%$search%")
                            ->orWhere('transaction_time', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('transaction_time', function ($order) {
                return Carbon::parse($order->transaction_time)->format('d/m/Y H:i');
            })
            ->addColumn('detail_button', function ($order) {
                return '<a href="' . route('report.show', $order->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['detail_button'])
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
