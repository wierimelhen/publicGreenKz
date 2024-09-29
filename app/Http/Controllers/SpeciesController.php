<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Species;

class SpeciesController extends Controller
{
    public function getTreeSpecies()
    {
        $data = Species::where('availability', 'enabled')->get();
        return response()->json(['response' => $data]);
    }
}
