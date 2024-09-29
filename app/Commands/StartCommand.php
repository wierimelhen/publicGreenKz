<?php

namespace App\Commands;

use App\Models\TelegramUsers;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand
{
    public function handle($userData, $chat_id, $tgUserID, $notRegisteredErr)
    {

        //Пробуем найти юзера в БД
        $telegramUser = TelegramUsers::where('user_id_tg', '=', "$tgUserID")->first();
        //Проверяем, если нашли пользователя отправляем сообщение как старому
        //Иначе добавляем его в бд и отправялем сообщение как новому
        if ($telegramUser) {
            if ($telegramUser->status == 'active') {
                $this->sendAnswerForOldUsers($chat_id);
            } else {
                $this->sendAnswerForOldNotActiveUsers($chat_id, $notRegisteredErr);
            }
        } else {
            $this->addNewTelegramUser($userData);
            $this->sendAnswerForNewUsers($chat_id);
        }

        return response(null, 200);
    }

    /**
     * Добавление пользователя в базу данных.
    //  * @param User $userData
     * @return void
     */
    public function addNewTelegramUser($userData)
    {



        TelegramUsers::insert([
            'user_id_tg' => $userData->id,
            'username' => $userData->username,
            'first_name' => $userData->first_name,
            'last_name' => $userData->last_name,
            'language_code' => $userData->language_code,
            'is_bot' => $userData->is_bot,
        ]);
    }

    /**
     * Ответ старому пользователю.
     * @return void
     */
    public function sendAnswerForOldUsers($chat_id): void
    {
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
            'text' => 'Вы уже авторизированы, можете просто выбрать нужную опцию',
            'parse_mode' => 'HTML',
            'one_time_keyboard' => true,
            'reply_markup' => json_encode($buttonData),
        ]);
    }

    public function sendAnswerForOldNotActiveUsers($chat_id, $notRegisteredErr): void
    {

        if ($notRegisteredErr) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => '<b>Не удалось вас авторизировать</b>'
                    . PHP_EOL
                    . PHP_EOL . 'Похоже что вы не ввели действительный логин и пароль'
                    . PHP_EOL
                    . PHP_EOL . 'Введите используемый вами <i>логин</i> и <i>пароль</i> для приложения чтобы авторизироваться в следующем формате:'
                    . PHP_EOL . '<pre><code>Грушева 4432gH</code></pre>',
                'parse_mode' => 'HTML',
                'force_reply' => true
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => '<b>Добро пожаловать, снова!</b>'
                    . PHP_EOL . 'Введите используемый вами <i>логин</i> и <i>пароль</i> для приложения чтобы авторизироваться в следующем формате:'
                    . PHP_EOL . '<pre><code>Грушева 4432gH</code></pre>',
                'parse_mode' => 'HTML',
                'force_reply' => true
            ]);
        }



    }

    public function sendAnswerForNewUsers($chat_id): void
    {
        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => '<b>Добро пожаловать!</b>'
                . PHP_EOL . 'Введите используемый вами <i>логин</i> и <i>пароль</i> для приложения чтобы авторизироваться в следующем формате:'
                . PHP_EOL . '<pre><code>Грушева 4432gH</code></pre>',
            'parse_mode' => 'HTML',
            'force_reply' => true
        ]);


    }
    //     // $message = '<b>жирный текст</b>'
    //     //     . PHP_EOL .'<i>курсивный текст</i>'
    //     //     . PHP_EOL .'<u>подчеркнутный текст</u>'
    //     //     . PHP_EOL .'<s>перечеркнутный текст</s>'
    //     //     . PHP_EOL .'<span class="tg-spoiler">Какой то спойлер Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit, voluptate!</span>'
    //     //     . PHP_EOL .'<b>жирный текст <i>еще и курсивный <s>еще и перечеркнутый </s></i></b>'
    //     //     . PHP_EOL .'<a href="http://www.example.com/">Ссылка в текстом</a>'
    //     //     . PHP_EOL .'<a href="tg://user?id=264493118">упоминание пользователя</a>'
    //     //     . PHP_EOL .'<code>код фиксированной ширины</code>'
    //     //     . PHP_EOL .'<pre>предварительно отформатированный блок кода фиксированной ширины</pre>'
    //     //     . PHP_EOL .'<pre><code class="language-python">предварительно отформатированный блок кода фиксированной ширины, написанный на языке программирования Python</code></pre>'
    //     // ;

}
