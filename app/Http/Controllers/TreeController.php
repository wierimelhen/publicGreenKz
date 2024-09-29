<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tree\TreeAddRequset;
use App\Models\Tree;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\TelegramWebhookController;

use DB;

class TreeController extends Controller
{
    public function addTree(TreeAddRequset $request)
    {

        // return response()->json([
        //     'response' => [
        //         'message' => 'Технические работы до 18:00',
        //     ]
        // ]);

        $validated_data = $request->validated();

        $user = auth()->user();
        $city_id = $user->city_id;

        if (is_null($user)) {
            return response()->json([
                'response' => [
                    'message' => 'Истек токен аутентификации. Необходимо выйти и снова авторизироваться',
                ]
            ]);
        }

        $tree = new Tree;

        $tree->tree_species = $validated_data['value_tree_species'];
        $tree->height = $validated_data['value_height'];
        $tree->spread = $validated_data['value_spread'];
        $tree->trunk = $validated_data['value_trunk'];
        $tree->age = $validated_data['value_age'];
        $tree->vitality = $validated_data['value_vitality'];
        $tree->owner = $validated_data['value_owner'];

        $tree->isCropped = $validated_data['isCropped'];
        $tree->isFelled = $validated_data['isFelled'];
        $tree->isDangerous = $validated_data['isDangerous'];

        $tree->longitude = $validated_data['value_longitude'];
        $tree->latitude = $validated_data['value_latitude'];

        $tree->city_id = $city_id;

        $saved = $tree->save();

        if (!$saved) {
            $answer_fail = new \stdClass();
            $answer_fail->answer = 'fail';
            return response()->json(['response' => $answer_fail]);
        }

        $user_id = $user->id;
        $tree_id = $tree->id;
        $action = 'add';

        (new LogsController)->LogTreeAdd($user_id, $tree_id, $action);

        $url = 'https://greenkz.bikli.kz/api/addTree';

        $validated_data['city_id'] = $city_id;

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($validated_data),
            ],
        ];

        $context = stream_context_create($options);
        $response = json_decode(file_get_contents($url, false, $context));

        $temp_answ = new \stdClass();
        $temp_answ->answer = $response->response->answer;

        $answer_succes = new \stdClass();
        $answer_succes->answer = 'success';
        $answer_succes->answer_from_second_server = $temp_answ;

        // $answer_succes->answer_from_second_server->answer = $response->response->answer;


        $user_for_msg = User::where('id', $user_id)->first();
        $fio = $user_for_msg->second_name . ' ' . $user_for_msg->name;

        $cityName = DB::table('cities')->where('id', '=', $city_id)->first()->city;
        $cityCountTrees = DB::table('trees')->where('city_id', '=', $city_id)->count();
        ;

        (new TelegramWebhookController)->TreeAddMessage($tree_id, $cityName, $cityCountTrees, $fio);

        return response()->json(['response' => $answer_succes]);


    }

    public function onTreesForUserNoData()
    {

        $user = auth()->user();
        $user_id = $user->id;
        $user_for_msg = User::where('id', $user_id)->first();
        $fio = $user_for_msg->second_name . ' ' . $user_for_msg->name;

        (new TelegramWebhookController)->MapUsedBySomeone($fio);

        $lastID = DB::table('log_tree_add')->orderBy('date_create', 'desc')->where('user_id', '=', $user_id)->pluck('tree_id')->first();
        $lastIDLocations = DB::table('trees')->select('id', 'latitude', 'longitude')->where('id', '=', $lastID)->first();

        $data = DB::table('trees')
            ->select('trees.id', 'trees.latitude', 'trees.tree_species', 'trees.longitude', 'trees.trunk', 'trees.created_at', 'log_tree_add.user_id')
            ->leftjoin('log_tree_add', 'trees.id', '=', 'log_tree_add.tree_id')
            ->whereRaw("
        (6371000 * acos(cos(radians(?)) * cos(radians(trees.latitude)) * cos(radians(trees.longitude) - radians(?)) + sin(radians(?)) * sin(radians(trees.latitude)))) <= ?
    ", [$lastIDLocations->latitude, $lastIDLocations->longitude, $lastIDLocations->latitude, 2000])
            ->get();

        $res_1 = [];

        $date30 = Carbon::today()->subDays(50);
        foreach ($data as $key_3 => $item_3) {
            if (($item_3->trunk !== null) && ($item_3->tree_species !== 1)) {
                if ($item_3->user_id == $user_id) {
                    if ($item_3->id == $lastID) {
                        $norma = 'hsl(2, 67%, 49%)';

                        $data_o = new \stdClass();
                        $data_o->hsl = $norma;
                        $data_o->lat = $item_3->latitude;
                        $data_o->lon = $item_3->longitude;
                    } else {
                        $norma = 'hsl(246, 100%, 50%)';

                        $data_o = new \stdClass();
                        $data_o->hsl = $norma;
                        $data_o->lat = $item_3->latitude;
                        $data_o->lon = $item_3->longitude;
                    }
                } else {
                    if ($item_3->created_at > $date30) {

                        $norma = 'hsl(120, 75%, 48%)';

                        $data_o = new \stdClass();

                        $data_o->hsl = $norma;
                        $data_o->lat = $item_3->latitude;
                        $data_o->lon = $item_3->longitude;

                    } else {
                        $norma = 'hsl(120, 26%, 22%)';

                        $data_o = new \stdClass();
                        $data_o->hsl = $norma;
                        $data_o->lat = $item_3->latitude;
                        $data_o->lon = $item_3->longitude;
                    }
                }
                array_push($res_1, $data_o);
            } else {

                $norma = 'hsl(30, 8%, 48%)';

                $data_o = new \stdClass();
                $data_o->hsl = $norma;
                $data_o->lat = $item_3->latitude;
                $data_o->lon = $item_3->longitude;

                array_push($res_1, $data_o);
            }


        }

        return response()->json(['response' => $res_1]);
    }


}
