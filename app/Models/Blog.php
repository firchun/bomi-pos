<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'blogs';
    protected $guarded = [];
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at->format('d F Y'),
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}