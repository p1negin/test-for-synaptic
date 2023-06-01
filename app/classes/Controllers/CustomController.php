<?php

namespace App\Classes\Controllers;

use App\Classes\Traits\AuthorizationTrait;

class CustomController extends Controller
{
    use AuthorizationTrait;

    public function index(): void
    {
        if (!$this->checkAuthorization($this->getMysql())) {
            $response = [
                'code' => 401,
                'message' => 'you are not logged in'
            ];
            http_response_code(401);
        } else {
            $response = [
                'code' => 200,
                'message' => 'synaptic forever'
            ];
        }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}