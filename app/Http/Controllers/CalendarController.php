<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_order, SUM(total) as total_price')
            ->where('id_kasir', Auth::id())
            ->groupBy('date')
            ->get()
            ->flatMap(function ($order) {
                return [
                    [
                        'title' => $order->total_order . ' Order',
                        'start' => \Carbon\Carbon::parse($order->date)->format('Y-m-d'),
                        'allDay' => true
                    ],
                    [
                        'title' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                        'start' => \Carbon\Carbon::parse($order->date)->format('Y-m-d'),
                        'allDay' => true
                    ]
                ];
            });

        return view('pages.calendar.index', ['events' => $orders]);
    }
}
