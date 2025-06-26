<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\IngredientDish;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        $products = Product::with(['category'])
            ->when($request->name, fn($query, $name) => $query->where('name', 'like', "%$name%"))
            ->orderBy('created_at', 'desc')
            ->where('user_id', Auth::id())
            ->paginate(10);

        if ($request->ajax()) {
            return view('pages.products._table', compact('products'))->render();
        }

        return view('pages.products.index', compact('products'));
    }

    // create
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }

    // store
    public function store(Request $request)
    {
        // validate the request...
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'stock' => 'nullable|numeric',
        ]);

        // store the request...
        $product = new Product;
        $product->name = $request->name;
        $product->user_id = Auth::id();
        $product->description = $request->description;
        $product->hpp = $request->hpp;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock ?? 0; // Jika kosong, gunakan default 0
        $product->status = $request->status ?? 1;
        $product->is_favorite = $request->is_favorite ?? 1;

        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }


    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', compact('product', 'categories'));
    }
    // ingredient
    public function ingredient($id)
    {
        $product = Product::findOrFail($id);
        $ingredient = Ingredient::where('id_user', Auth::id())
            ->with(['category'])
            ->get();
        $dish = IngredientDish::with(['ingredient', 'product'])
            ->where('id_product', $id)
            ->paginate(20);
        // dd($dish);
        return view('pages.products.ingredient', compact('product', 'ingredient', 'dish'));
    }


    // update
    public function update(Request $request, $id)
    {
        // validate the request...
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'stock' => 'nullable|numeric', // stock diizinkan kosong
        ]);

        // update the request...
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->hpp = $request->hpp;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock ?? $product->stock; // Jika kosong, tetap gunakan nilai lama
        $product->status = $request->status ?? 1;
        $product->is_favorite = $request->is_favorite ?? 1;
        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // destroy
    public function destroy($id)
    {

        $product = Product::find($id);
        if ($product && $product->image) {
            $filePath = str_replace('storage/', 'public/', $product->image);

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
    public function updateDiscount(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount' => 'required|integer|min:0|max:100', // diskon bertipe int
        ]);
    
        $product = Product::find($request->product_id);
    
        $product->discount = intval($request->discount);
    
        $price = floatval($product->price);
        $discount = $product->discount;
    
        $product->price_final = round($price * (1 - $discount / 100), 2);
    
        $product->save();
    
        return back()->with('success', 'Discount updated successfully');
    }
}
