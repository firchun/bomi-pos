<?php

namespace App\Http\Controllers;

use App\Models\IncomeExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class IncomeExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = IncomeExpenseCategory::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $data = [
            'categories' => $categories,
        ];
        return view('pages.income-expenses-category.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense', // misal kategori bisa pemasukan atau pengeluaran
        ]);

        IncomeExpenseCategory::create([
            'id_user' => Auth::id(),
            'category' => $request->category,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('financial.category')->with('success', 'Category success add.');
    }
    public function destroy($id)
    {
        $category = IncomeExpenseCategory::where('id', $id)
            ->where('id_user', Auth::id()) // agar hanya bisa menghapus kategori milik sendiri
            ->firstOrFail();

        $category->delete();

        return redirect()->route('financial.category')->with('success', 'Kategori berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string',
        ]);

        $category = IncomeExpenseCategory::where('id_user', Auth::id())->findOrFail($id);

        $category->update([
            'category' => $request->category,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('financial.category')->with('success', 'Category successfully updated.');
    }
}
