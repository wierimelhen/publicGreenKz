<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreeVitality;

class TreeVitalityController extends Controller
{
    public function getTreeVitalities()
    {
        $data = TreeVitality::where('availability', 'enabled')->get();
        return response()->json(['response' => $data]);
    }
}
