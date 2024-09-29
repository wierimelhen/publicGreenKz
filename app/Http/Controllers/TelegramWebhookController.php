<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelegramUsers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use \App\Commands\TelegramButtons;
use \App\Commands\StartCommand;

use Telegram\Bot\Laravel\Facades\Telegram;


class TelegramWebhookController extends Controller
{

    const general_chat_id = '-1002107056320';

    public function handle(Request $request)
    {

        $updates = Telegram::getWebhookUpdates();
        $message = $updates->getMessage();
        $chat_id = $message->getChat()->getId();
        $tgUserID = $message->getFrom()->getId();
        $text = $message->getText();
        $userData = $message->getChat();

        if ($updates->isType('callback_query')) {

            $callbackQuery = $updates->getCallbackQuery();
            $data = $callbackQuery->getData();
            $private = $message->getChat()->type;

            \DB::table('log_app')->insert(
                [
                    'data' => 'tg button --- ' . $chat_id . ' --- ' . $data,
                ]
            );

            // Проверяем, на какую кнопку нажал пользователь
            if ((($data === 'all_time') || ($data === 'today') || ($data === 'yesterday')) && $private === 'private') {
                (new TelegramButtons)->getButtons($userData, $data, $chat_id, $chat_id);
                return;
            }
        }

        $validator = Validator::make(
            ['text' => $text],
            [
                'text' => ['required', 'string', 'min:3', 'max:255', 'not_in:badword1,badword2'], // Запрещённые слова
            ],
            [
                'text.required' => 'Сообщение не может быть пустым.',
                'text.min' => 'Сообщение должно содержать минимум :min символа.',
                'text.max' => 'Сообщение не может быть длиннее :max символов.',
                'text.not_in' => 'Ваше сообщение содержит запрещённые слова.',
            ]
        );

        if ($validator->fails()) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => implode("\n", $validator->errors()->all()),
            ]);
            return;
        } else {

            if ($message) {
                switch ($message->getText()) {
                    case '/start':
                        (new StartCommand)->handle($userData, $chat_id, $tgUserID, false);
                        break;

                    case 'Сегодня':
                    case 'Вчера':
                    case 'За все время':
                        (new TelegramButtons)->getButtons($userData, $text, $tgUserID, $chat_id);
                        break;

                    default:
                        $this->Login($chat_id, $tgUserID, $text);
                        break;
                }
            }
        }

    }

    public function Login($chat_id, $tgUserID, $text)
    {

        \DB::table('log_app')->insert(
            [
                'data' => 'tg login --- ' . $chat_id . ' --- ' . $tgUserID . ' --- ' . $text,
            ]
        );

        $splitted = preg_split('/\s+/', $text);
        if (count($splitted) == 2) {

            $model = User::where('second_name', '=', $splitted[0])->first();

            if (!$model) {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Пользователь не найден'
                ]);

                return;
            }

            if ($token = auth()->attempt(["second_name" => $splitted[0], "password" => $splitted[1]])) {

                $user = auth()->user();
                $user_id = $user->id;
                $action = 'telegram';

                TelegramUsers::where('user_id_tg', $tgUserID)->update(['user_id' => $user_id, 'status' => 'active']);

                \DB::table('log_user')->insert(
                    [
                        'user_id' => $user_id,
                        'action' => $action,
                    ]
                );

                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Здравствуйте ' . $model->second_name . ' ' . $model->name
                ]);

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

            } else {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Не верный пароль'
                ]);
            }

        } else {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => '(⁠?⁠・⁠・⁠)⁠ -> не удалось распознать команду'
            ]);
        }
    }

    public function TreeAddMessage($tree_id, $cityName, $cityCountTrees, $fio)
    {
        Telegram::sendMessage([
            'chat_id' => self::general_chat_id,
            'parse_mode' => 'HTML',
            'text' => "<b>Добавлено дерево \xF0\x9F\x8C\xBF</b>"
                . PHP_EOL
                . PHP_EOL . 'ID дерева: ' . $tree_id
                . PHP_EOL . 'Город: ' . $cityName
                . PHP_EOL . 'Количество по городу: ' . $cityCountTrees
                . PHP_EOL . $fio
        ]);
    }

    public function MapUsedBySomeone($fio)
    {
        Telegram::sendMessage([
            'chat_id' => self::general_chat_id,
            'parse_mode' => 'HTML',
            'text' => "<b>Обновление карты \xF0\x9F\x8C\x8E</b>"
                . PHP_EOL
                . PHP_EOL . $fio
        ]);
    }

    public function AuthInSystem($second_name, $password)
    {
        Telegram::sendMessage([
            'chat_id' => self::general_chat_id,
            'parse_mode' => 'HTML',
            'text' => "<pre><b>Авторизация \xF0\x9F\x9A\xAA</b></pre>"
                . PHP_EOL . $second_name
                . PHP_EOL . $password
        ]);
    }

    public function AuthInSystemErr($second_name)
    {
        Telegram::sendMessage([
            'chat_id' => self::general_chat_id,
            'parse_mode' => 'HTML',
            'text' => "<pre><b>Не удалось авторизировать  \xF0\x9F\x94\xB3</b></pre>"
                . PHP_EOL . $second_name
        ]);
    }
}
