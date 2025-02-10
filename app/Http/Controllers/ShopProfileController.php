<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ShopProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopProfileController extends Controller
{
    public function index()
    {
        $shopProfile = Auth::user()->shopProfile;
        return view('pages.shop_profiles.index', compact('shopProfile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'shop_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'photo' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan foto jika ada
        $photo = $request->file('photo')
            ? $request->file('photo')->store('shop_photos', 'public')
            : null;

        // Create location
        $location = Location::create([
            'name' => $validated['name'] . ' Location',
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Simpan data ke database
        ShopProfile::create([
            'name' => $validated['name'],
            'shop_type' => $validated['shop_type'],
            'open_time' => $validated['open_time'],
            'close_time' => $validated['close_time'],
            'photo' => $photo, // Menyimpan foto jika ada
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'location_id' => $location->id,
            'user_id' => $request->user()->id,
            'address' => $validated['address'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('shop-profiles.index')->with('success', 'Shop profile created successfully!');
    }

    // Temporary fix untuk test
    public function update(Request $request, $id)
    {
        $shopProfile = ShopProfile::with('location')->findOrFail($id);
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($shopProfile->photo) {
                Storage::disk('public')->delete($shopProfile->photo);
            }
            
            // Simpan foto baru ke direktori 'shop_photos' dalam storage public
            $photoPath = $request->file('photo')->store('shop_photos', 'public');
            
            // Update foto path
            $shopProfile->photo = $photoPath;
        }
    
        // Force update tanpa validasi
        $shopProfile->update($request->except('photo'));
    
        // Update location
        $shopProfile->location()->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
    
        return back()->with('success', 'Shop profile Updated successfully!');
    }    
}
