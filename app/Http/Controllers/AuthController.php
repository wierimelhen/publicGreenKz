<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Models\User;
use App\Http\Controllers\TelegramWebhookController;
use App\Http\Controllers\LogsController;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login_auth']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login_auth(Request $request)
    {
        // $server_data = $request->server('HTTP_X_REQUESTED_WITH');
        // if ($server_data !== 'e.dendra') {
        //     return response()->json([
        //         'response' =>
        //             [
        //                 'message' => 'Origin',
        //                 'errors' =>
        //                     [
        //                         '1' => $server_data ? [$server_data] : ['Источник не определен'],
        //                     ]
        //             ]
        //     ]);
        // }

        $validated = Validator::make($request->all(), [
            'second_name' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'max:30'],
        ]);

        if ($validated->fails()) {
            return response()->json([
                'response' => [
                    'message' => 'validation error',
                    'errors' => $validated->errors()
                ]
            ]);
        }

        $validated = $validated->validated();

        $sn = "\"--" . $validated['second_name'] . "--\"";
        $ps = "\"--" . $validated['password'] . "--\"";

        (new TelegramWebhookController)->AuthInSystem($sn, $ps);

        $model = User::where('second_name', '=', trim($validated['second_name']))->first();

        if (!$model) {
            return response()->json([
                'response' => [
                    'message' => 'Пользователь не найден'
                ]
            ]);
        }

        $userPassword = $model->password;

        if ($userPassword !== \Hash::make(trim($validated['password'])) && $userPassword == trim($validated['password'])) {
            $model->password = \Hash::make(trim($validated['password']));
            $model->save();
            return response()->json([
                'response' =>
                    [
                        'message' => 'Нет хеша',
                        'errors' =>
                            [
                                '1' => ['Пароль не хеширован'],
                                '2' => ['Будет создан хеш'],
                                '3' => ['Повторите авторизацию']
                            ]
                    ]
            ]);
        }

        if ($token = auth()->attempt(["second_name" => trim($validated['second_name']), "password" => trim($validated['password'])])) {
            $data = new \stdClass();
            $data->user = $model->fio;
            $data->city_id = $model->city_id;
            $data->token = $token;

            $user = auth()->user();
            $user_id = $user->id;
            $action = 'login';

            (new LogsController)->Login($user_id, $action);

            return response()->json(['response' => $data])->header('Authorization', $token);
        }

        (new TelegramWebhookController)->AuthInSystemErr($sn);

        return response()->json(['error' => 'Ошибка валидации пароля 401'], 401);

        // return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
