<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class IngredientCategory extends Model
{
    use HasFactory;
    protected $table = 'ingredient_categories';
    protected $guarded = [];
}
