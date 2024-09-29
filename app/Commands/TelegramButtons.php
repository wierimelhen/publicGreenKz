<?php

namespace App\Commands;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\TelegramUsers;
use \Carbon\Carbon;
use DB;
class TelegramButtons
{


    public function getButtons($userData, $text, $tgUserID, $chat_id)
    {

        $telegramUser = TelegramUsers::where('user_id_tg', '=', "$tgUserID")->first();
        //Проверяем, если нашли пользователя отправляем сообщение как старому
        //Иначе добавляем его в бд и отправялем сообщение как новому
        if ($telegramUser) {
            if ($telegramUser->status == 'active') {
                $this->switcher($text, $tgUserID, $chat_id);
            } else {
                (new StartCommand)->handle($userData, $chat_id, $tgUserID, true);
            }
        } else {
            (new StartCommand)->handle($userData, $chat_id, $tgUserID, true);

        }



    }


    public function switcher($text, $tgUserID, $chat_id)
    {
        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ',
            'parse_mode' => 'HTML',
        ]);


        switch ($text) {
            case 'За все время':
            case 'all_time':
                $this->getCountAll($tgUserID, $chat_id);
                break;

            case 'Вчера':
            case 'yesterday':
                $date_1 = Carbon::yesterday()->startOfDay()->toDateTimeString();
                $date_2 = Carbon::yesterday()->endOfDay()->toDateTimeString();

                $this->getCountByDate($date_1, $date_2, $tgUserID, $chat_id);
                break;

            case 'Сегодня':
            case 'today':
                $date_1 = Carbon::today()->startOfDay()->toDateTimeString();
                $date_2 = Carbon::today()->endOfDay()->toDateTimeString();

                $this->getCountByDate($date_1, $date_2, $tgUserID, $chat_id);
                break;

            default:

                return '+_=';

        }

        $buttonData = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'За все время',
                        'callback_data' => 'all_time',

                    ]
                ],
                [
                    [
                        'text' => 'Вчера',
                        'callback_data' => 'yesterday',

                    ],
                    [
                        'text' => 'Сегодня',
                        'callback_data' => 'today',

                    ]
                ]
            ],

        ];

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Можете выбрать период для просмотра количества добавленных деревьев',
            'parse_mode' => 'HTML',
            'one_time_keyboard' => true,
            'reply_markup' => json_encode($buttonData),
        ]);
    }

    public function getCountByDate($date_1, $date_2, $tgUserID, $chat_id)
    {

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => '<pre><code> ----> Сводка между ' . $date_1 . ' и ' . $date_2 . ':</code></pre>',
            'parse_mode' => 'HTML',
        ]);

        $user_id = TelegramUsers::where('user_id_tg', $tgUserID)->first()->user_id;

        if ($user_id == 50) {

            $cities = DB::table('cities')->get();

            foreach ($cities as $key => $city) {
                if ( $city->id !== 1) {
                    $counted = DB::table('log_tree_add') -> select( 'users.second_name', 'cities.city', DB::raw('COUNT(log_tree_add.user_id) AS cnt'))
                    ->leftjoin('users', 'log_tree_add.user_id', '=', 'users.id')
                    ->leftjoin('cities', 'users.city_id', '=', 'cities.id')
                    ->where('date_create', '>', $date_1)
                    ->where('date_create', '<', $date_2)
                    ->where('users.city_id', '=', $city->id)
                    ->groupBy(['users.second_name', 'log_tree_add.user_id',  'cities.city'])
                    ->orderBy('cnt')
                    ->orderBy('cities.city')
                    ->get();

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => '<pre><code>Сводка за ' . $city->city . ':</code></pre>',
                        'parse_mode' => 'HTML',
                    ]);

                    foreach ($counted as $key => $value) {
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => $value->second_name . ' - ' . $value->city . ' - ' . $value->cnt
                        ]);
                    }
                }

            }

        } else {
            $count = DB::table('log_tree_add')->where('user_id', '=', $user_id)->where('date_create', '>', $date_1)->where('date_create', '<', $date_2)->count();

            Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Деревьев было добавлено: ' . $count
                    ]);
        }



        return;
    }

    public function getCountAll($tgUserID, $chat_id)
    {
        $user_id = TelegramUsers::where('user_id_tg', $tgUserID)->first()->user_id;

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => '<pre><code> ----> Сводка за весь период:</code></pre>',
            'parse_mode' => 'HTML',
        ]);

        if ($user_id == 50) {

            $cities = DB::table('cities')->get();

            foreach ($cities as $key => $city) {
                if ( $city->id !== 1) {
                    $counted = DB::table('log_tree_add') -> select( 'users.second_name', 'cities.city', DB::raw('COUNT(log_tree_add.user_id) AS cnt'))
                    ->leftjoin('users', 'log_tree_add.user_id', '=', 'users.id')
                    ->leftjoin('cities', 'users.city_id', '=', 'cities.id')
                    ->where('users.city_id', '=', $city->id)
                    ->groupBy(['users.second_name', 'log_tree_add.user_id',  'cities.city'])
                    ->orderBy('cnt')
                    ->orderBy('cities.city')
                    ->get();

                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => '<pre><code>Сводка за ' . $city->city . ':</code></pre>',
                        'parse_mode' => 'HTML',
                    ]);

                    foreach ($counted as $key => $value) {
                        Telegram::sendMessage([
                            'chat_id' => $chat_id,
                            'text' => $value->second_name . ' - ' . $value->city . ' - ' . $value->cnt
                        ]);
                    }
                }

            }

        } else {

            $count = DB::table('log_tree_add')->where('user_id', '=', $user_id)->count();

            Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Деревьев было добавлено: ' . $count
                    ]);
        }


        return;
    }

}
