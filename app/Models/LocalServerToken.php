<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalServerToken extends Model
{
    use HasFactory;
    protected $table = 'local_server_tokens';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}