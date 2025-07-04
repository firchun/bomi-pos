<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStok extends Model
{
    use HasFactory;
    protected $table = 'product_stoks';
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
