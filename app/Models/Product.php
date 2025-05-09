<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image',
        'stock',
        'status',
        'is_favorite',
        'category_id',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'outlet_name' => $this->outlet->name ?? '',
        ];
    }

    public function outlet()
    {
        return $this->belongsTo(ShopProfile::class, 'user_id', 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
    // App\Models\Product.php
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price') // sesuaikan jika ada
            ->withTimestamps();
    }
}
