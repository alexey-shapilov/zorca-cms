<?php

namespace Zorca;

use Zorca\Database;
/**
 * Class Routes
 *
 * @package Zorca
 */
class Routes {
    static function get() {
        $routesConfig =
        foreach ($routesConfig as $routesConfigItem) {
            if ($routesConfigItem['extType'] === 'component') $routes->add($routesConfigItem['extKey'], new Routing\Route($routesConfigItem['extSlug'] . '/{extAction}', ['extAction'=> 'index'], ['extAction'=> '^[a-z0-9-]+']));
        }
        return $routes;
    }
}