<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TablesController extends Controller
{
    public function index()
    {
        $tables = Table::where('user_id', Auth::id())->get();
        $data = [
            'title' => 'Tables Managemen',
            'tables' => $tables
        ];
        return view('pages.tables.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $lastTable = Table::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $start = $lastTable ? intval(Str::after($lastTable->name, 'Table ')) + 1 : 1;

        for ($i = 0; $i < $request->jumlah; $i++) {
            $name = 'Table ' . ($start + $i);
            Table::create([
                'user_id' => Auth::id(),
                'name' => $name,
            ]);
        }

        $tables = Table::where('user_id', Auth::id())->get();

        return response()->json([
            'tables' => $tables
        ]);
    }
}
