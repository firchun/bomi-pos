<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dailyReport(Request $request)
    {
        $date = $request->input('date');
        $search = $request->input('search')['value'] ?? '';
    
        // Query untuk mengambil data OrderItem dengan relasi Order dan Product
        $orderItemsQuery = OrderItem::with(['order', 'product'])
            ->when($date, function ($query, $date) {
                $query->whereHas('order', function ($q) use ($date) {
                    $q->whereDate('transaction_time', $date);
                });
            })
            ->when($search, function ($query, $search) {
                // Pencarian berdasarkan nama produk atau atribut lain
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            });
    
        // Hitung total revenue (tanpa pagination)
        $totalRevenue = $orderItemsQuery->get()->reduce(function ($carry, $item) {
            $totalPrice = $item->quantity * $item->price;
            $discountAmount = $item->order->discount > 0 ? ($totalPrice * ($item->order->discount / 100)) : 0;
            $totalPriceAfterDiscount = $totalPrice - $discountAmount;
            return $carry + $totalPriceAfterDiscount;
        }, 0);
    
        $recordsTotal = $orderItemsQuery->count();
    
        // Pagination DataTables
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
    
        $orderItems = $orderItemsQuery->skip($start)->take($length)->get();
    
        $reportData = [];
        $nomor = $start + 1;
    
        foreach ($orderItems as $item) {
            $order = $item->order;
            $totalPrice = $item->quantity * $item->price;
            $discountAmount = $order->discount > 0 ? ($totalPrice * ($order->discount / 100)) : 0;
            $totalPriceAfterDiscount = $totalPrice - $discountAmount;

            $transactionDate = $order ? Carbon::parse($order->transaction_time)->format('Y-m-d') : 'Tanggal Tidak Ditemukan';
    
            $reportData[] = [
                'nomor' => $nomor++,
                'nama_product' => $item->product ? $item->product->name : 'Produk Tidak Ditemukan',
                'jumlah_beli' => $item->quantity,
                'harga_satuan' => $item->price,
                'total_harga' => $totalPrice,
                'diskon' => $discountAmount,
                'total_setelah_diskon' => $totalPriceAfterDiscount,
                'tanggal_transaksi' => $transactionDate,
            ];
        }
    
        if ($request->ajax()) {
            return response()->json([
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsTotal,
                'data' => $reportData,
                'draw' => intval($request->input('draw')),
                'totalRevenue' => $totalRevenue, // Kirim total revenue ke frontend
            ]);
        }
    
        return view('pages.report.index', [
            'date' => $date,
        ]);
    }
}