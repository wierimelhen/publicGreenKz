<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qr_codes;
use App\Models\Parks;

class QrController extends Controller
{
    public function getParkByQrCode($code)
    {
        // Найти запись QR-кода
        $qrCode = Qr_code::where('code', $code)->first();

        if (!$qrCode) {
            return response()->json(['error' => 'QR code not found'], 404);
        }

        // Найти парк по ID парка, который связан с QR-кодом
        $park = Park::with(['city', 'contractors', 'trees'])->where('id', $qrCode->park_id)->first();

        if (!$park) {
            return response()->json(['error' => 'Park not found'], 404);
        }

        // Вернуть информацию о парке
        return response()->json([
            'park' => $park,
            'city' => $park->city,
            'contractors' => $park->contractors,
            'trees' => $park->trees
        ]);
    }
}
