<?php

namespace App\Classes\Traits;

//todo: можно было сделать как в Laravel middleware, но этот функционал писать не совсем вижу смысла для test проекта

use mysqli;

trait AuthorizationTrait
{
    protected function checkAuthorization(mysqli $mysql): bool
    {
        $headers = getallheaders();
        $access_token = $headers['Bearer'] ?? null;
        $sql = 'SELECT * FROM `access_tokens` WHERE `token` = ?';
        $stmt = $mysql->prepare($sql);
        $stmt->bind_param('s', $access_token);
        $stmt->execute();

        $access_token_obj = $stmt->get_result()->fetch_object();

        if (time() > $access_token_obj->keep_alive) {
            //todo: тут можно сделать проверку на refresh токен, если он тоже просрочен, то удалять оба токена
            return false;
        }

        return (bool)$stmt->get_result()->fetch_object();
    }
}