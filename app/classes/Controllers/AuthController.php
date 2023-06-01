<?php

namespace App\Classes\Controllers;

use App\Classes\Helpers\Generator;

final class AuthController extends Controller
{
    protected const KEEP_ALIVE_ACCESS_TOKEN = 3600; # 1 hour

    protected const KEEP_ALIVE_REFRESH_TOKEN = 3600 * 24 * 30; # 30 days

    public function refresh(): void
    {
        $access_token = base64_encode(Generator::token());
        $refresh_token = base64_encode(Generator::token());

        $refresh_token_param = $_POST['refresh_token'] ?? null;
        $sql = 'SELECT * FROM `refresh_tokens` WHERE `token` = ?';
        $stmt = $this->getMysql()->prepare($sql);
        $stmt->bind_param('s', $refresh_token_param);
        $stmt->execute();
        $refresh_token_obj = $stmt->get_result()->fetch_object();

        if (time() > $refresh_token_obj->keep_alive) {

            //todo: тут удаляем refresh токен и access токен, чтобы не засорять базу

            $response = [
                'status' => 200,
                'error' => 'the tokens lifetime has expired'
            ];
        } else if (!$refresh_token_obj) {
            $response = [
                'status' => 404,
                'error' => 'refresh token not found'
            ];
            http_response_code(404);
        } else {
            $sql = 'UPDATE `access_tokens` SET `token` = ?, `keep_alive` = ? WHERE id = ?';
            $stmt = $this->getMysql()->prepare($sql);
            $keep_alive = time() + self::KEEP_ALIVE_ACCESS_TOKEN;
            $stmt->bind_param('sii', $access_token, $keep_alive, $refresh_token_obj->access_token_id);
            $stmt->execute();

            $sql = 'UPDATE `refresh_tokens` SET `token` = ?, `keep_alive` = ? WHERE id = ?';
            $stmt = $this->getMysql()->prepare($sql);
            $keep_alive = time() + self::KEEP_ALIVE_REFRESH_TOKEN;
            $stmt->bind_param('sii', $refresh_token, $keep_alive, $refresh_token_obj->id);
            $stmt->execute();

            $response = [
                'status' => 200,
                'success' => 'new token has been generated',
                'authorization' => [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token
                ]
            ];
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function auth(): void
    {
        $login = $_POST['login'] ?? null;
        $password = $_POST['password'] ?? null;

        $sql = 'SELECT * FROM `users` WHERE `login` = ? AND `password` = ?';
        $stmt = $this->getMysql()->prepare($sql);
        $stmt->bind_param('ss', $login, $password);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_object();
        $stmt->free_result();

        if ($user) {
            $access_token = base64_encode(Generator::token());
            $refresh_token = base64_encode(Generator::token());

            $sql = 'INSERT INTO `access_tokens` (`user_id`, `token`, `keep_alive`) VALUES (?, ?, ?)';
            $stmt = $this->getMysql()->prepare($sql);
            $keep_alive = time() + self::KEEP_ALIVE_ACCESS_TOKEN;
            $stmt->bind_param('isi', $user->id, $access_token, $keep_alive);
            $stmt->execute();

            $access_token_id = $stmt->insert_id;

            $sql = 'INSERT INTO `refresh_tokens` (`access_token_id`, `token`, `keep_alive`) VALUES (?, ?, ?)';
            $stmt = $this->getMysql()->prepare($sql);
            $keep_alive = time() + self::KEEP_ALIVE_REFRESH_TOKEN;
            $stmt->bind_param('isi', $access_token_id, $refresh_token, $keep_alive);
            $stmt->execute();

            //todo: тут проверяем refresh токены на keep_alive и подчищаем их совместно с access токенами, чтобы не засорять базу

            $response = [
                'status' => 200,
                'success' => 'you are successfully logged in!',
                'user' => $user,
                'authorization' => [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token
                ]
            ];

        } else {
            $response = [
                'status' => 401,
                'error' => 'not authorized!'
            ];
            http_response_code(401);
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}