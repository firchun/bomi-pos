<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shop()
    {
        return $this->belongsTo(ShopProfile::class, 'shop_profile_id');
    }
}
