<?php

use App\Classes\Core;

const DEBUG_MODE = true;

ini_set("error_reporting", DEBUG_MODE ? E_ALL : false);
ini_set("display_errors", DEBUG_MODE);
ini_set("display_startup_errors", DEBUG_MODE);

date_default_timezone_set("Europe/Moscow");

const ROOT_DIR = __DIR__ . '/..';

require_once ROOT_DIR . '/config/db_config.php';

require_once ROOT_DIR . '/vendor/autoload.php';

try {
    $core = new Core();
    $core->run();
} catch (Exception $exception) {
    exit($exception->getMessage());
}
