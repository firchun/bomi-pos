<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ShopProfile extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'shop_type',
        'address',
        'description',
        'open_time',
        'close_time',
        'photo',
        'location_id',
        'user_id',
    ];
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->address,
        ];
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
