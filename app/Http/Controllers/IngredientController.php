<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        return view('pages.ingredient.index');
    }
}
