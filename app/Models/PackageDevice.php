<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDevice extends Model
{
    use HasFactory;
    protected $table = 'package_devices';
    protected $guarded = [];
    protected $casts = [
        'features' => 'array',
    ];
}
