<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminProduct::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $adminproducts = $query->paginate(10);
        return view('pages.admin-products.index', compact('adminproducts'));
    }

    public function create()
    {
        return view('pages.admin-products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $adminproduct = new AdminProduct($validated);

        // Handle file upload for image
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('admin-products', 'public');
            $adminproduct->photo = $imagePath;
        }

        $adminproduct->save();

        return redirect()->route('admin-products.index')->with('success', 'Product added successfully');
    }

    public function edit(AdminProduct $adminproduct)
    {
        return view('pages.admin-products.edit', compact('adminproduct'));
    }

    public function update(Request $request, AdminProduct $adminproduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $adminproduct->update($validated);

        if ($request->hasFile('photo')) {
            if ($adminproduct->photo) {
                Storage::disk('public')->delete($adminproduct->photo);
            }
            $imagePath = $request->file('photo')->store('admin-products', 'public');
            $adminproduct->photo = $imagePath;
            $adminproduct->save();
        }

        return redirect()->route('admin-products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(AdminProduct $adminproduct)
    {
        $adminproduct->delete();
        return redirect()->route('admin-products.index')->with('success', 'Product deleted successfully');
    }

    public function home(Request $request)
    {
        $profile = AdminProfile::first();
        return view('bomi-products-pages.index', compact('profile'));
    }

    public function fetchProducts(Request $request)
    {
        $products = AdminProduct::paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
            ]);
        }

        return view('bomi-products-pages.index');
    }
}
