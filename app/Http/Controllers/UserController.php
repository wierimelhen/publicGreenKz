<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
// use App\Models\AccessRight;
// use App\Models\UsersActionLog;

class UserController extends Controller
{
    public function login(Request $request)
    {



        $validated = Validator::make($request->all(), [
            'second_name' => ['required', 'string', 'max:30'],
            'pass_data' => ['required', 'string', 'max:30'],
        ]);



        if ($validated->fails()) {
            return response()->json([
                'response' => [
                    'message' => 'validation error',
                    'errors' => $validated->errors()
                ]
            ]);
        }

        $validated_data = $validated->validated();

        // if (\Auth::attempt(['second_name' => $validated_data['second_name'], 'pass_data' => $validated_data['second_name']])) {
        //     echo 'true';
        // } else {
        //     echo 'false';
        // }

        $user = User::where('second_name', $validated_data['second_name'])
            ->where('pass_data', $validated_data['pass_data'])
            ->get();


        if ($user->isEmpty()) {
            return response()->json([
                'response' => [
                    'message' => 'error',
                    'errors' => ['1' => ['Пользователь не найден']]
                ]
            ]);
        } elseif (count($user) !== 1) {
            return response()->json([
                'response' => [
                    'message' => 'error',
                    'errors' => ['1' => ['Найдено более одного пользователя']]
                ]
            ]);
        }

        $user = User::find($user[0]->id);
        // $authenticated_user = \Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // $rights_data = AccessRight::where('user_id', $user->id)->where('availability', '=', 'enabled')->get();

        // $fields = new \stdClass();
        // foreach ($rights_data as $key_2 => $arr_2) {
        //     $right = $arr_2->right;
        //     $group = $arr_2->group_qt;
        //     $id = $arr_2->id;

        //     $rights_arr = new \stdClass();
        //     $rights_arr->right_id = $id;
        //     $rights_arr->right = $right;
        //     $rights_arr->group = $group;

        //     $fields->$key_2 = $rights_arr;
        // }

        // $user->rights = $fields;



        // UsersActionLog::insert(
        //     [
        //         'user_id' => $user->id,
        //         'object_user' => $user->id,
        //         'field' => 'login',
        //         'action' => 'login',
        //         'value' => 'login',
        //     ]
        // );

        $user -> auth_login_token = $token;
        // $cookie = cookie('auth_login_token', $token, 60 * 24); // 1 day

        return response()->json(['response' => $user]);
    }

    public function onChangeUserRights(Request $request)
    {

        $user_id = $request->input('user_id');
        $action_user_id = $request->input('action_user_id');
        $data = $request->input();

        $answer_succes = new \stdClass();
        $answer_succes->answer = 'success';

        $answer_fail = new \stdClass();
        $answer_fail->answer = 'fail';

        if ($data) {
            $id_updated = DB::table('users_access_rights')->where('user_id', $user_id)->where('availability', 'enabled')->pluck('id');
            DB::table('users_access_rights')->where('user_id', $user_id)->where('availability', 'enabled')->update(array('availability' => 'disabled'));

            foreach ($id_updated as $k => $id) {
                DB::table('users_actions_log')->insert(
                    [
                        'user_id' => $action_user_id,
                        'object_user' => $user_id,
                        'field' => 'users_access_rights',
                        'action' => 'disable',
                        'value' => $id,
                    ]
                );
            }

            foreach (array_keys($data) as $key_1 => $item) {
                // echo $item;
                if ($item !== 'user_id') {
                    if ($item !== 'action_user_id') {
                        $right = json_decode($data[$item]);
                        $record_id = DB::table('users_access_rights')->insertGetId(
                            [
                                'user_id' => $user_id,
                                'group_qt' => $right[1]->group,
                                'right' => $right[1]->right,
                                'availability' => 'enabled',
                            ]
                        );

                        DB::table('users_actions_log')->insert(
                            [
                                'user_id' => $action_user_id,
                                'object_user' => $user_id,
                                'field' => 'users_access_rights',
                                'action' => 'add',
                                'value' => $record_id,
                            ]
                        );

                        // $this->Log_onChangeUserRights($action_user_id, $user_id, 'users_access_rights', 'add', $record_id);
                    }
                }
            }

            return response()->json(['response' => $answer_succes]);
        } else {
            return response()->json(['response' => $answer_fail->code = '3']);
        }
    }

    public function Log_onChangeUserRights($user_id, $object_users_id, $field, $action, $value_id)
    {
        redirect()->route('Log_onChangeUserRights', [$user_id, $object_users_id, $field, $action, $value_id])->send();
    }

    public function getLast10Users(Request $request)
    {

        $data = DB::table('users_main_data')->orderBy("id", "DESC")->take(10)->get();

        foreach ($data as $key_1 => $user) {
            // \DB::statement("SET SQL_MODE=''");
            $rights_data = DB::table('users_access_rights')->where('user_id', $user->id)->where('availability', '=', 'enabled')->get();


            // print_r($rights_data);
            $fields = new \stdClass();
            foreach ($rights_data as $key_2 => $arr_2) {
                $right = $arr_2->right;
                $group = $arr_2->group_qt;
                $id = $arr_2->id;

                $rights_arr = new \stdClass();
                $rights_arr->right_id = $id;
                $rights_arr->right = $right;
                $rights_arr->group = $group;

                $fields->$key_2 = $rights_arr;
            }

            $user->rights = $fields;
        }

        return response()->json(['response' => $data]);
    }

    public function onSimpleUsersSearch(Request $request)
    {

        $data = $request->input('data');
        $field = $request->input('field');
        $action_user_id = $request->input('action_user_id');

        DB::table('users_actions_log')->insert(
            [
                'user_id' => $action_user_id,
                'object_system' => 'onSimpleUsersSearch',
                'field' => $field,
                'action' => 'search',
                'value' => $data,
            ]
        );

        $users_data = DB::table('users_main_data')->where($field, 'LIKE', '%' . $data . '%')->get();

        foreach ($users_data as $key_1 => $user) {
            // \DB::statement("SET SQL_MODE=''");
            $rights_data = DB::table('users_access_rights')->where('user_id', $user->id)->where('availability', '=', 'enabled')->get();

            $fields = new \stdClass();
            foreach ($rights_data as $key_2 => $arr_2) {
                $right = $arr_2->right;
                $group = $arr_2->group_qt;
                $id = $arr_2->id;

                $rights_arr = new \stdClass();
                $rights_arr->right_id = $id;
                $rights_arr->right = $right;
                $rights_arr->group = $group;

                $fields->$key_2 = $rights_arr;
            }

            $user->rights = $fields;
        }

        return response()->json(['response' => $users_data]);
    }

    public function onUserAdd(Request $request)
    {

        $answer_succes = new \stdClass();
        $answer_succes->answer = 'success';

        $answer_fail = new \stdClass();
        $answer_fail->answer = 'fail';

        if ($request->has('ValueFirstName')) {
            if ($request->has('ValueSecondName')) {
                if ($request->has('ValueFatherName')) {
                    if ($request->has('ValueRank')) {
                        if ($request->has('ValuePass')) {
                            if ($request->has('ValueSubdivision')) {
                                if ($request->has('ValuePost')) {
                                    if ($request->has('ValuePhone')) {
                                        $user_id = $request->input('user_id');

                                        $record_id = DB::table('users_main_data')->insertGetId(
                                            [
                                                'second_name' => $request->input('ValueSecondName'),
                                                'name' => $request->input('ValueFirstName'),
                                                'surname' => $request->input('ValueFatherName'),
                                                'subdivision' => $request->input('ValueSubdivision'),
                                                'rank' => $request->input('ValueRank'),
                                                'pass_data' => $request->input('ValuePass'),
                                                'phone' => $request->input('ValuePhone'),
                                                'post' => $request->input('ValuePost')
                                            ]
                                        );

                                        foreach (array_keys($request->input()) as $key_1 => $item) {
                                            if ($item !== 'user_id') {
                                                DB::table('users_actions_log')->insert(
                                                    [
                                                        'user_id' => $user_id,
                                                        'object_user' => $record_id,
                                                        'field' => $item,
                                                        'action' => 'add',
                                                        'value' => $request->input($item),
                                                    ]
                                                );
                                            }
                                        }



                                        return response()->json(['response' => $answer_succes]);
                                    } else {
                                        return response()->json(['response' => $answer_fail]);
                                    }
                                } else {
                                    return response()->json(['response' => $answer_fail]);
                                }
                            } else {
                                return response()->json(['response' => $answer_fail]);
                            }
                        } else {
                            return response()->json(['response' => $answer_fail]);
                        }
                    } else {
                        return response()->json(['response' => $answer_fail]);
                    }
                } else {
                    return response()->json(['response' => $answer_fail]);
                }
            } else {
                return response()->json(['response' => $answer_fail]);
            }
        } else {
            return response()->json(['response' => $answer_fail]);
        }
    }
}
