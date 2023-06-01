<?php

namespace App\Classes\Controllers;

final class NotFoundController extends Controller
{
    public function index(): void
    {
        $response = ['status' => 404, 'error' => 'not found!'];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        http_response_code(404);
    }

    public function method(): void
    {
        $response = ['status' => 400, 'error' => 'method incorrectly!'];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        http_response_code(400);
    }
}