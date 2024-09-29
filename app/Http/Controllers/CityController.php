<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function getAListOfCities(Request $request)
    {

        $validated = Validator::make($request->all(), []);


        if ($validated->fails()) {
            return response()->json([
                'response' => [
                    'message' => 'validation error',
                    'errors' => $validated->errors()
                ]
            ]);
        }

        $validated = $validated->validated();

        $data = City::where('availability', 'enabled')->get();

        if (!$data) {
            return response()->json([
                'response' => [
                    'message' => 'Нет данных'
                ]
            ]);
        }

        return response()->json(['response' => $data]);
    }
}
