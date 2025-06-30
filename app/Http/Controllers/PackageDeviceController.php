<?php

namespace App\Http\Controllers;

use App\Models\PackageDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageDeviceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Package Management',
            'package_device' => PackageDevice::orderBy('created_at', 'desc')->paginate(10)
        ];
        return view('pages.package_device.index', $data);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'no_hp' => 'required',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id' => 'nullable|exists:package_devices,id'
        ]);

        // Jika ada ID, update
        $packageDevice = $request->id ? packageDevice::findOrFail($request->id) : new packageDevice();

        $packageDevice->name = $validated['name'];
        $packageDevice->tag = $validated['tag'] ?? null;
        $packageDevice->price = $validated['price'];
        $packageDevice->no_hp = $validated['no_hp'];
        $packageDevice->features = $validated['features'] ?? [];
        // create link wa
        $wa_number = preg_replace('/[^0-9]/', '', $validated['no_hp']); // hapus simbol
        $wa_number = ltrim($wa_number, '0'); // hilangkan 0 di awal
        $wa_number = '62' . $wa_number; // ubah jadi format 62

        $message = urlencode("Nama Pemesan:\nNama Paket: {$validated['name']}\nJumlah Pemesanan:\nAlamat Pengiriman:");

        $packageDevice->no_hp = $validated['no_hp'];
        $packageDevice->link_direct = "https://wa.me/{$wa_number}?text={$message}";

        // Jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika update
            if ($packageDevice->image && Storage::disk('public')->exists($packageDevice->image)) {
                Storage::disk('public')->delete($packageDevice->image);
            }

            $path = $request->file('image')->store('packageDevices', 'public');
            $packageDevice->image = $path;
        }

        $packageDevice->save();

        return redirect('packages-device')->with('success', $request->id ? 'Produk diperbarui.' : 'Produk ditambahkan.');
    }
    public function destroy($id)
    {
        $packageDevice = packageDevice::findOrFail($id);

        // Hapus file gambar
        if ($packageDevice->image && Storage::disk('public')->exists($packageDevice->image)) {
            Storage::disk('public')->delete($packageDevice->image);
        }

        $packageDevice->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
    public function create()
    {
        return view('pages.package_device.create');
    }
    public function edit($id)
    {
        $packageDevice = PackageDevice::findOrFail($id);
        return view('pages.package_device.edit', compact('packageDevice'));
    }
}
