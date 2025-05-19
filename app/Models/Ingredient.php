<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'ingredients';
    protected $guarded = [];

    public function category() : BelongsTo
    {
        return $this->BelongsTo(IngredientCategory::class,'id_catexgory','id');
    }
}
