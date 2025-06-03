<?php

namespace App\Http\Controllers;

use App\Models\LocalServerToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LocalServerTokenController extends Controller
{
    public function index()
    {
        $server = LocalServerToken::where('user_id', Auth::id())->first();
        return view('pages.setting.token-server', compact('server'));
    }
    public function generate(Request $request)
    {
        $request->validate([
            'name_server' => 'required|string|max:255',
            'address_server' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $userId = Auth::id();

        // Cek apakah token sudah ada untuk user ini
        $existing = LocalServerToken::where('user_id', $userId)->first();

        $token = Str::uuid()->toString();

        if ($existing) {
            // Update token yang sudah ada
            $existing->update([
                'token' => $token,
                'name_server' => $request->name_server,
                'address_server' => $request->address_server,
                'phone' => $request->phone,
                'active' => true,
            ]);

            $server = $existing;
        } else {
            // Buat token baru
            $server = LocalServerToken::create([
                'token' => $token,
                'name_server' => $request->name_server,
                'address_server' => $request->address_server,
                'phone' => $request->phone,
                'active' => true,
                'user_id' => $userId,
            ]);
        }

        return response()->json([
            'message' => 'Token generated successfully',
            'data' => $server
        ]);
    }
}
