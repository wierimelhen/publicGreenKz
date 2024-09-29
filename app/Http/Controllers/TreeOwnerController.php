<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreeOwner;

class TreeOwnerController extends Controller
{
    public function getTreeOwners()
    {
        $data = TreeOwner::where('availability', 'enabled')->get();
        return response()->json(['response' => $data]);
    }
}
