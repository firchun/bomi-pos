<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'our_services',
        'our_services_items',
        'about_ourselves',
        'difference_of_us',
        'difference_of_us_items',
    ];

    protected $casts = [
        'our_services_items' => 'array',
        'about_ourselves' => 'array',
        'difference_of_us_items' => 'array',
    ];
}
