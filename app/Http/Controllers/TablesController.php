<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function destroy($id)
    {
        $table = Table::findOrFail($id);
        if ($table->user_id !== Auth::id()) {
            return back()->withErrors('You do not have permission to delete this table.');
        }
        $table->delete();
        return back()->with('success', 'Table deleted successfully.');
    }
    public function print()
    {
        $user_id = Auth::id();
        $tables = Table::where('user_id', $user_id)->get();
        $settings = Setting::where('id_user', $user_id)->first();
        $qrData = [];

        foreach ($tables as $table) {
            $url = route('shop.table', $table->code); // Pastikan ini mengarah ke URL menu

            $qrCode = new QrCode($url);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $qrCodeBase64 = base64_encode($result->getString());

            $qrData[] = [
                'table' => $table->name ?? $table->code, // Bisa nama meja atau kode
                'qrCode' => 'data:image/png;base64,' . $qrCodeBase64,
            ];
        }

        return view('pages.tables.print', [
            'settings' => $settings,
            'qrData' => $qrData,
            'shopName' => Auth::user()->shopProfile->name ?? 'Nama Toko', // Jika ada nama toko
        ]);
    }
}