<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Visitor extends Model
{
    use HasFactory;
    protected $table = 'visitors';
    protected $guarded = [];

    public function shop()
    {
        return $this->belongsTo(ShopProfile::class, 'shop_id');
    }
}
