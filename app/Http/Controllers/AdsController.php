<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    public function index()
    {
        $shop = ShopProfile::where('user_id',Auth::id())->first();
        $data = [
            'ads'=> Ads::where('shop_id',$shop->id)->paginate(5),
            'shop'=> $shop,
        ];
        return view('pages.ads.index',$data);
    }
    public function create()
    {
        return view('pages.ads.create');
    }
    public function store(Request $request)
    {

        // dd($request->all());
        // validate the request...
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // store the request...
        $ads = new Ads();
        $ads->title = $request->title;
        $ads->shop_id = ShopProfile::where('user_id', Auth::id())->first()->id;
        $ads->description = $request->description;
        $ads->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        
            // Simpan file ke folder storage/app/public/ads
            $fileName = $ads->id . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/ads', $fileName);
        
            // Simpan path yang bisa diakses browser (setelah storage:link)
            $ads->image = 'storage/ads/' . $fileName;
            $ads->save();
        }

        return redirect()->route('advertisement.index')->with('success', 'advertisement created successfully');
    }
    // update
    public function update(Request $request, $id)
    {
        // validate the request...
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // update the request...
        $product = Ads::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->save();

        //save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/ads', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/ads/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('advertisement.index')->with('success', 'advertisement updated successfully');
    }
    // edit
    public function edit($id)
    {
        $ads = Ads::findOrFail($id);
        return view('pages.ads.edit', compact('ads'));
    }
     // destroy
     public function destroy($id)
     {
         // delete the request...
         $ads = Ads::find($id);
         if ($ads && $ads->image) {
            // Hilangkan 'storage/' karena Storage::delete menggunakan path relatif dari storage/app
            $filePath = str_replace('storage/', 'public/', $ads->image);
    
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
         $ads->delete();
 
         return redirect()->route('advertisement.index')->with('success', 'advertisement deleted successfully');
     }
}
