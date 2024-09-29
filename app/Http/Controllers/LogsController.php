<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function addAppLog(Request $request)
    {
        \DB::table('log_app')->insert(
            [
                'data' => json_encode($request->all()),
            ]
        );
        return response()->json(['response' => 'success']);
    }

    public function LogTreeAdd($user_id, $tree_id, $action)
    {
        DB::table('log_tree_add')->insert(
            [
                'user_id' => $user_id,
                'tree_id' => $tree_id,
                'action' => $action,
            ]
        );
    }

    public function Login($user_id, $action)
    {
        DB::table('log_user')->insert(
            [
                'user_id' => $user_id,
                'action' => $action,
            ]
        );
    }
}
