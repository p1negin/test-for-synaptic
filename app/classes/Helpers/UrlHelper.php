<?php

namespace App\Classes\Helpers;

abstract class UrlHelper
{
    final static public function removeGetParamsFromUri(string $uri) : string
    {
        return preg_replace('/\\?.*/', '', $uri);
    }
}