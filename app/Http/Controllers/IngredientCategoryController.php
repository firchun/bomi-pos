<?php

namespace App\Http\Controllers;

use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngredientCategoryController extends Controller
{
    public function index()
    {
        $categories = IngredientCategory::where('id_user', Auth::id())->get();
        return view('pages.ingredient_category.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255', // misal kategori bisa pemasukan atau pengeluaran
        ]);

        IngredientCategory::create([
            'id_user' => Auth::id(),
            'category' => $request->category,
        ]);

        return redirect()->route('ingredient-category')->with('success', 'Category success add.');
    }
    public function destroy($id)
    {
        $category = IngredientCategory::where('id', $id)
            ->where('id_user', Auth::id()) // agar hanya bisa menghapus kategori milik sendiri
            ->firstOrFail();

        $category->delete();

        return redirect()->route('ingredient-category')->with('success', 'Kategori berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        $category = IngredientCategory::where('id_user', Auth::id())->findOrFail($id);

        $category->update([
            'category' => $request->category,

        ]);

        return redirect()->route('ingredient-category')->with('success', 'Category successfully updated.');
    }
}
