<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $table = 'ads';
    protected $guarded = [];
    public function shop()
    {
        return $this->belongsTo(ShopProfile::class, 'shop_id');
    }
}
