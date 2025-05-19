<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableActive extends Model
{
    use HasFactory;
    protected $table = 'table_actives';
    protected $guarded = [];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
