<?php

namespace App\Http\Controllers;

use App\Models\PackageAccount;
use Illuminate\Http\Request;

class PackageAccountController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Package Account Management',
            'package_account' => PackageAccount::orderBy('created_at', 'desc')->paginate(10)
        ];
        return view('pages.package_account.index', $data);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'id' => 'nullable|exists:package_accounts,id'
        ]);

        // Jika ada ID, update
        $PackageAccount = $request->id ? PackageAccount::findOrFail($request->id) : new PackageAccount();

        $PackageAccount->name = $validated['name'];
        $PackageAccount->type = $validated['type'];
        $PackageAccount->price = $validated['price'];
        $PackageAccount->features = $validated['features'] ?? [];

        $PackageAccount->save();

        return redirect('packages-account')->with('success', $request->id ? 'Produk diperbarui.' : 'Produk ditambahkan.');
    }
    public function destroy($id)
    {
        $PackageAccount = PackageAccount::findOrFail($id);

        $PackageAccount->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
    public function create()
    {
        return view('pages.package_account.create');
    }
    public function edit($id)
    {
        $PackageAccount = PackageAccount::findOrFail($id);
        return view('pages.package_account.edit', compact('PackageAccount'));
    }
}
