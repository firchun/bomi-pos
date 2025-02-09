<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = OrderItem::query();

        $query->select('order_items.*', DB::raw('(SELECT name FROM products WHERE products.id = order_items.product_id) AS product_name'));

        if ($start_date && $end_date) {
            $query->whereBetween('order_items.created_at', [$start_date, $end_date])
                ->whereExists(function ($subQuery) {
                    $subQuery->select(DB::raw(1))
                        ->from('orders')
                        ->whereColumn('orders.id', 'order_items.order_id')
                        ->where('orders.id_kasir', Auth::id());
                });
        }

        $orderItems = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $orderItems
        ], 200);
    }
    public function orderSales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = OrderItem::select('order_items.product_id', DB::raw('(SELECT name FROM products WHERE products.id = order_items.product_id) AS product_name'), DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('order_items.product_id');
        if ($startDate && $endDate) {
            $query->whereBetween(DB::raw('DATE(order_items.created_at)'), [$startDate, $endDate])->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('orders')
                    ->whereColumn('orders.id', 'order_items.order_id')
                    ->where('orders.id_kasir', Auth::id());
            });
        }
        $totalProductSold = $query->orderBy('total_quantity', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $totalProductSold
        ], 200);
    }
}
