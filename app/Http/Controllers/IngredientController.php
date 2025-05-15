<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\IngredientDish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Ingredient Manajemen',
            'category' => IngredientCategory::where('id_user',Auth::id())->get(),
            'ingredient' => Ingredient::where('id_user',Auth::id())->with(['category'])->paginate(10),
        ];
        return view('pages.ingredient.index',$data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // misal kategori bisa pemasukan atau pengeluaran
            'unit' => 'required', // misal kategori bisa pemasukan atau pengeluaran
            'id_category' => 'required|string|max:255', // misal kategori bisa pemasukan atau pengeluaran
        ]);

        Ingredient::create([
            'id_user' => Auth::id(),
            'id_category' => $request->id_category,
            'name' => $request->name,
            'unit' => $request->unit,
        ]);

        return redirect()->back()->with('success', 'Ingredient successfully added.');
    }
    public function storeDish(Request $request)
    {
        $request->validate([
            'id_product' => 'required|string|max:255', 
            'id_ingredient' => 'required|string|max:255', 
            'qty' => 'required', 
        ]);
        IngredientDish::create([
            'id_ingredient' => $request->id_ingredient,
            'id_product' => $request->id_product,
            'qty' => $request->qty,
           
        ]);

        return redirect()->back()->with('success', 'Ingredient successfully added.');
    }
}
