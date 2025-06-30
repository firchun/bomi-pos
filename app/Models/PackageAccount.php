<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageAccount extends Model
{
    protected $table = 'package_accounts';
    protected $guarded = [];
    protected $casts = [
        'features' => 'array',
    ];
}
