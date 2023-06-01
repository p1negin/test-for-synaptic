<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitacbc11f03c6113f265bf7daacc75b4b7
{
    public static $classMap = array (
        'App\\Classes\\Controllers\\AuthController' => __DIR__ . '/../..' . '/app/classes/Controllers/AuthController.php',
        'App\\Classes\\Controllers\\Controller' => __DIR__ . '/../..' . '/app/classes/Controllers/Controller.php',
        'App\\Classes\\Controllers\\CustomController' => __DIR__ . '/../..' . '/app/classes/Controllers/CustomController.php',
        'App\\Classes\\Controllers\\NotFoundController' => __DIR__ . '/../..' . '/app/classes/Controllers/NotFoundController.php',
        'App\\Classes\\Core' => __DIR__ . '/../..' . '/app/classes/Core.php',
        'App\\Classes\\Helpers\\Generator' => __DIR__ . '/../..' . '/app/classes/Helpers/Generator.php',
        'App\\Classes\\Helpers\\UrlHelper' => __DIR__ . '/../..' . '/app/classes/Helpers/UrlHelper.php',
        'App\\Classes\\Router\\Route' => __DIR__ . '/../..' . '/app/classes/Router/Route.php',
        'App\\Classes\\Router\\Router' => __DIR__ . '/../..' . '/app/classes/Router/Router.php',
        'App\\Classes\\Traits\\AuthorizationTrait' => __DIR__ . '/../..' . '/app/classes/Traits/AuthorizationTrait.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitacbc11f03c6113f265bf7daacc75b4b7::$classMap;

        }, null, ClassLoader::class);
    }
}
