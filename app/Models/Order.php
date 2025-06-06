<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_amount',
        'sub_total',
        'tax',
        'discount',
        'discount_amount',
        'service_charge',
        'total',
        'payment_method',
        'total_item',
        'id_kasir',
        'user_id',
        'nama_kasir',
        'transaction_time',
        'no_invoice',
        'table_number',
        'customer_name',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
