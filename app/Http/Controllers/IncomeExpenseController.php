<?php

namespace App\Http\Controllers;

use App\Models\IncomeExpense;
use App\Models\IncomeExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeExpenseController extends Controller
{
    public function income()
    {
        $data = [
            'categories' => IncomeExpenseCategory::where('type', 'income')->where('id_user', Auth::id())->get(),
        ];
        return view('pages.income.index', $data);
    }
    public function expenses()
    {
        $data = [
            'categories' => IncomeExpenseCategory::where('type', 'expense')->where('id_user', Auth::id())->get(),
        ];
        return view('pages.expenses.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_category' => 'required|exists:income_expense_category,id',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        IncomeExpense::create([
            'id_user' => Auth::id(),
            'id_category' => $request->id_category,
            'date' => $request->date,
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Record has been added successfully.');
    }
}
