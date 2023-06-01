<?php

namespace App\Classes\Helpers;

use Exception;

abstract class Generator
{
    public static function token(int $length = 2048): string
    {
        try {
            $bytes = random_bytes($length);
            return bin2hex($bytes);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}