<?php

namespace App\Classes;

use App\Classes\Router\Router;
use Exception;
use mysqli;

final class Core
{
    private mysqli $mysql;

    private Router $router;

    public function run(): void
    {
        $this->mysqlInit();
        $this->routerInit();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    private function routerInit(): void
    {
        require_once ROOT_DIR . '/app/classes/Router/Routes.php';
        $this->setRouter(new Router());
        $this->getRouter()->run($this->getMysql());
    }

    private function mysqlInit(): void
    {
        try {
            $this->setMysql(new mysqli(MySQL_HOST, MySQL_USER, MySQL_PASSWORD, MySQL_DATABASE));
            if ($this->getMysql()->errno) {
                throw new Exception('Mysql error: ' . $this->getMysql()->error);
            }
        } catch (Exception $exception) {
            exit($exception->getMessage());
        }
    }

    protected function getMysql(): mysqli
    {
        return $this->mysql;
    }

    protected function setMysql(mysqli $mysql): void
    {
        $this->mysql = $mysql;
    }
}