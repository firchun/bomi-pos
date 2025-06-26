<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Table extends Model
{
    use HasFactory;
    protected $table = 'tables';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateUniqueToken();
            }
        });

        // Saat update atau saving (create & update)
        static::saving(function ($model) {
            if (empty($model->code)) {
                $model->code = self::generateUniqueToken();
            }
        });
    }
    public static function generateUniqueToken()
    {
        do {
            $token = Str::random(64);
        } while (self::where('code', $token)->exists());

        return $token;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tableActives()
    {
        return $this->hasMany(TableActive::class);
    }
}
