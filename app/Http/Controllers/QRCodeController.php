<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class QRCodeController extends Controller
{
    // QRCodeController.php
    public function generatePDF(Request $request)
    {
        try {
            $user = Auth::user();
            abort_unless($user && $user->shopProfile, 403, 'Profil toko tidak ditemukan');
            $shopProfile = $user->shopProfile;
    
            // Validasi array dengan minimal 1 elemen
            $validated = $request->validate([
                'tables' => 'required|array|min:1',
                'tables.*' => 'required|string|max:255'
            ]);
    
            // Filter nomor meja yang kosong setelah di-trim
            $tablesArray = array_filter(array_map('trim', $validated['tables']), function($table) {
                return !empty($table);
            });
    
            if (empty($tablesArray)) {
                throw ValidationException::withMessages(['tables' => 'Harus ada setidaknya satu nomor meja yang valid.']);
            }
    
            // Generate QR Code (gunakan PNG)
            $qrData = [];
            foreach ($tablesArray as $table) {
                $url = route('shop.details', $shopProfile->slug);
    
                $renderer = new ImageRenderer(
                    new RendererStyle(300),
                    new SvgImageBackEnd()
                );
                
                $qrCode = (new Writer($renderer))->writeString($url);
                $qrData[] = [
                    'table' => $table,
                    'qrCode' => base64_encode($qrCode)
                ];
            }
    
            $pdf = PDF::loadView('pages.shop_profiles.partials.qrcode', [
                'shopName' => $shopProfile->name,
                'qrData' => $qrData
            ]);
    
            return $pdf->stream('qrcode.pdf');
    
        } catch (ValidationException $e) {
            return response()->json(['error' => implode(', ', $e->errors()['tables'])], 422);
        } catch (\Exception $e) {
            Log::error('Error: '.$e->getMessage());
            return response()->json(['error' => 'Gagal generate PDF: '.$e->getMessage()], 500);
        }
    }
}
