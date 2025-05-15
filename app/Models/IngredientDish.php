<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientDish extends Model
{
    use HasFactory;
    protected $table = 'ingredient_dish';
    protected $guarded = [];
    
    public function product() : BelongsTo {
        return $this->BelongsTo(Product::class,'id_product');
    }
    public function ingredient() : BelongsTo {
        return $this->BelongsTo(Ingredient::class,'id_ingredient');
    }
}
