<?php

require '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'zinobeprueba',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);
$map->get('addUser', '/user/add', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'getAddUserAction'
]);
$map->post('saveUser', '/user/add', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'saveAddUserAction'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'PAGE 404';
} else {
    $handlerData = $route->handler;
    $actionName = $handlerData['action'];
    $controllerName = $handlerData['controller'];
    $controller = new $controllerName;
    $response = $controller->$actionName($request);
    echo $response->getBody();
}



// require '../index.php';
