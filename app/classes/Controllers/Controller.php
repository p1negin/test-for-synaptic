<?php

namespace App\Classes\Controllers;

use mysqli;

class Controller
{
    public function __construct(
        protected mysqli $mysql
    )
    {
    }

    protected function getMysql(): mysqli
    {
        return $this->mysql;
    }
}