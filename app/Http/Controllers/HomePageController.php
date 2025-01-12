<?php

namespace App\Http\Controllers;

use App\Models\AdminProfile;

class HomePageController extends Controller
{
    public function index()
    {
        $profile = AdminProfile::first();
        if ($profile) {
            if ($profile->about_ourselves) {
                $profile->about_ourselves = json_decode($profile->about_ourselves, true); // Decode ke array
            }
            if ($profile->difference_of_us) {
                $profile->difference_of_us = json_decode($profile->difference_of_us, true); // Decode ke array
            }
            if ($profile->difference_of_us_items) {
                $profile->difference_of_us_items = json_decode($profile->difference_of_us_items, true); // Decode ke array
            }
        }
        return view('homepage.index', compact('profile'));
    }
}

