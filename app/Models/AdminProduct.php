<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProduct extends Model
{
    use HasFactory;

    protected $table = 'admin_products';

    protected $fillable = [
        'name',
        'description',
        'photo',
        'phone_number',
        'price',
    ];
}
