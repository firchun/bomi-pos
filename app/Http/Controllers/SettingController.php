<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $setting = Setting::where('id_user', Auth::id())->latest()->first();
            if (!$setting) {
                $setting = new Setting();
                $setting->id_user = Auth::id();
            }

            // Isi semua field boolean
            $setting->tables = $request->has('tables');
            $setting->ingredient = $request->has('ingredient');
            $setting->calendar = $request->has('calendar');
            $setting->ads = $request->has('ads');
            $setting->order_on_table = $request->has('order_on_table');
            $setting->color_number_table = $request->input('color_number_table');
            $setting->local_server = $request->has('local_server');

            $setting->save();

            return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
        }
        $setting = Setting::where('id_user', Auth::id())->latest()->first();
        if (!$setting) {
            $setting = new Setting();
            $setting->id_user = Auth::id();
            $setting->save();
        }
        $data = [
            'title' => 'Pengaturan Aplikasi',
            'setting_table' => $setting
        ];

        return view('pages.setting.application', $data);
    }
}