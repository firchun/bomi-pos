<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\ShopProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopProfileController extends Controller
{
    /**
     * Display the shop profile view.
     */
    public function index(Request $request)
    {
        
        $shopProfile = ShopProfile::where('user_id', $request->user()->id)->first();

        // Jika profil toko tidak ada, tampilkan form untuk membuat
        if (!$shopProfile) {
            return view('pages.shop_profiles.index');
        }

        // Jika profil toko ada, tampilkan yang sudah ada
        return view('pages.shop_profiles.index', compact('shopProfile'));
    }

    /**
     * Store a newly created shop profile in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'shop_type' => 'required|string|max:255',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'photo' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('shop_photos', 'public');
        }

        $location = Location::create([
            'name' => $validatedData['name'] . ' Location',
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        $dataToSave = [
            'name' => $validatedData['name'],
            'shop_type' => $validatedData['shop_type'],
            'open_time' => $validatedData['open_time'],
            'close_time' => $validatedData['close_time'],
            'photo' => $validatedData['photo'] ?? null,
            'slug' => Str::slug($validatedData['name']) . '-' . Str::random(6),
            'location_id' => $location->id,
            'user_id' => $request->user()->id,
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],  
        ];

        ShopProfile::create($dataToSave);

        return redirect()->route('shop-profiles.index')->with('success', 'Shop profile created successfully.');
    }


    /**
     * Update the specified shop profile in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $shopProfile = ShopProfile::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'shop_type' => 'sometimes|string|max:255',
            'open_time' => 'sometimes|date_format:H:i',
            'close_time' => 'sometimes|date_format:H:i',
            'photo' => 'nullable|image|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'address' => 'sometimes|string|max:255',
            'description' => 'required|string|max:100',
        ]);

        // Update lokasi jika latitude atau longitude diberikan
        if (isset($validatedData['latitude']) && isset($validatedData['longitude'])) {
            if ($shopProfile->location) {
                $shopProfile->location->update([
                    'latitude' => $validatedData['latitude'],
                    'longitude' => $validatedData['longitude'],
                ]);
            } else {
                $location = Location::create([
                    'name' => $shopProfile->name . ' Location',
                    'latitude' => $validatedData['latitude'],
                    'longitude' => $validatedData['longitude'],
                ]);
                $shopProfile->update(['location_id' => $location->id]);
            }
        }

        // Update profil toko jika ada perubahan foto
        if ($request->hasFile('photo')) {
            if ($shopProfile->photo) {
                Storage::disk('public')->delete($shopProfile->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('shop_photos', 'public');
        }

        // Jika nama toko diubah, regenerasi slug
        if (isset($validatedData['name'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']) . '-' . Str::random(6);
        }

        // Update address jika diberikan
        if (isset($validatedData['address'])) {
            $shopProfile->address = $validatedData['address'];
        }

        // Update address jika diberikan
        if (isset($validatedData['description'])) {
            $shopProfile->description = $validatedData['description'];
        }

        // Simpan perubahan
        $shopProfile->update($validatedData);

        return redirect()->route('pages.shop-profiles.index')->with('success', 'Shop profile updated successfully.');
    }
}
