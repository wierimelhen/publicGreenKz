<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qr_codes;
use App\Models\Parks;
use Illuminate\Support\Facades\Validator;

class QrController extends Controller
{
    public function getParkByQrCode(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'token' => ['required', 'string', 'max:20'],
        ]);


        if ($validated->fails()) {
            return response()->json([
                'response' => [
                    'message' => 'Ошибка валидации',
                    'errors' => $validated->errors()
                ]
            ]);
        }

        $validated = $validated->validated();
        $token = $validated['token'];

        $qrCode = Qr_codes::where('code', $token)->first();

        if (!$qrCode) {
            return response()->json(['error' => 'QR code not found']);
        }

        // Найти парк по ID парка, который связан с QR-кодом
        $park = Parks::select('name')
        ->with(['city'])
        ->withCount('contractors', 'trees')
        ->where('id', $qrCode->park_id)
        ->first();

        if (!$park) {
            return response()->json(['error' => 'Park not found']);
        }

        // Вернуть информацию о парке
        return response()->json([
            'park' => $park->name,
            'city' => $park->'city',
            'contractors' => $park->contractors_count,
            'trees' => $park->trees_count
        ]);
    }
}
