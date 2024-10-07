<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tree\TreeAddRequset;
use App\Models\Tree;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Support\Facades\Validator;

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

    public function latLngToXY()
    {
        $trees = Tree::where('park_id', 1)->get();  // Получаем все деревья парка

        // Минимальные и максимальные значения для нормализации
        $minLat = $trees->min('latitude');
        $maxLat = $trees->max('latitude');
        $minLng = $trees->min('longitude');
        $maxLng = $trees->max('longitude');

        // Получаем общее количество деревьев
        $totalTrees = $trees -> count();
        $counter = 0;

        foreach ($trees as $tree) {
            [$x, $y] = $this->latLngToXYConv($tree->latitude, $tree->longitude, $minLat, $maxLat, $minLng, $maxLng);

            $tree->x = $x;
            $tree->y = $y;
            $tree->save();

            $counter++;
            // Выводим прогресс
        }

        // echo "Normalization complete.\n";
        return response()->json(['response' => []]);
    }

    public function latLngToXYConv($lat, $lng, $minLat, $maxLat, $minLng, $maxLng)
    {
        // Преобразуем широту (lat) в диапазон от -500 до 500
        $normalizedLat = ($lat - $minLat) / ($maxLat - $minLat) * 100 - 50;

        // Преобразуем долготу (lng) в диапазон от -500 до 500
        $normalizedLng = ($lng - $minLng) / ($maxLng - $minLng) * 100 - 50;

        return [$normalizedLng, $normalizedLat];
    }

    public function XYtrees(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'park_id' => ['required', 'integer'],
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

        $trees = DB::table('trees')->select('x', 'y')->where('park_id', $validated['park_id'])->get();
        
        return response()->json(['response' => $trees]);
    }
}
