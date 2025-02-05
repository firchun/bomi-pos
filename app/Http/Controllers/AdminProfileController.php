<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;
use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    /**
     * Display the profile creation or update form.
     */
    public function index()
    {
        $profile = AdminProfile::first(); // Ambil profil pertama (jika ada)
        return view('pages.admin_profiles.index', compact('profile'));
    }

    /**
     * Store a new profile.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'our_services' => 'required|string',
            'our_services_items' => 'required|array',
            'our_services_items.*.title' => 'required|string',
            'our_services_items.*.description' => 'required|string',
            'about_ourselves.title' => 'required|string',
            'about_ourselves.description' => 'required|string',
            'difference_of_us' => 'required|string',
            'difference_of_us_items' => 'required|array',
            'difference_of_us_items.*.title' => 'required|string',
            'difference_of_us_items.*.description' => 'required|string',
        ]);

        // Simpan profil baru
        AdminProfile::create([
            'our_services' => $request->our_services,
            'our_services_items' => json_encode($request->our_services_items),
            'about_ourselves' => json_encode($request->about_ourselves),
            'difference_of_us' => $request->difference_of_us,
            'difference_of_us_items' => json_encode($request->difference_of_us_items),
        ]);

        return redirect()
            ->route('admin_profiles.index')
            ->with('success', 'Profile created successfully!');
    }

    /**
     * Update an existing profile.
     */
    public function update(Request $request, AdminProfile $adminProfile)
    {
        // Validasi input
        $request->validate([
            'our_services' => 'required|string',
            'our_services_items' => 'required|array',
            'our_services_items.*.title' => 'required|string',
            'our_services_items.*.description' => 'required|string',
            'about_ourselves.title' => 'required|string',
            'about_ourselves.description' => 'required|string',
            'difference_of_us' => 'required|string',
            'difference_of_us_items' => 'required|array',
            'difference_of_us_items.*.title' => 'required|string',
            'difference_of_us_items.*.description' => 'required|string',
        ]);

        // Perbarui profil yang ada
        $adminProfile->update([
            'our_services' => $request->our_services,
            'our_services_items' => json_encode($request->our_services_items),
            'about_ourselves' => json_encode($request->about_ourselves),
            'difference_of_us' => $request->difference_of_us,
            'difference_of_us_items' => json_encode($request->difference_of_us_items),
        ]);

        return redirect()
            ->route('admin_profiles.index')
            ->with('success', 'Profile updated successfully!');
    }
}
