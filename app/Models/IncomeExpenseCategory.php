<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExpenseCategory extends Model
{
    use HasFactory;
    protected $table = 'income_expense_category';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incomeExpenses()
    {
        return $this->hasMany(IncomeExpense::class);
    }
}
