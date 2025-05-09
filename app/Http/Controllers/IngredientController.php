<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Ingredient Manajemen',
            'category' => IngredientCategory::where('id_user',Auth::id())->get(),
            'ingredient' => Ingredient::where('id_user',Auth::id())->with(['category'])->get(),
        ];
        return view('pages.ingredient.index',$data);
    }
}
