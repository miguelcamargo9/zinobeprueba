<?php

require '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;
use Zend\Diactoros\Response\RedirectResponse;

session_start();

//manage ENV vars 
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/..');
$dotenv->load();

//Container of dependency injection
$container = new DI\Container();

//Eloquen capsule
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

//PSR 7 Messages with Diactoros
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

//Route container with Aurora
$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction',
    'auth' => true
]);
$map->get('addUser', '/user/add', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'getAddUserAction',
    'auth' => false
]);
$map->post('saveUser', '/user/add', [
    'controller' => 'App\Controllers\UserController',
    'action' => 'saveAddUserAction',
    'auth' => false
]);
$map->get('loginForm', '/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin',
    'auth' => false
]);
$map->get('logoutForm', '/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout',
    'auth' => true
]);
$map->post('auth', '/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin',
    'auth' => false
]);
$map->get('loaddir1', '/loaddir1', [
    'controller' => 'App\Controllers\DirectoryController',
    'action' => 'getLoadDir1',
    'auth' => true
]);
$map->get('loaddir2', '/loaddir2', [
    'controller' => 'App\Controllers\DirectoryController',
    'action' => 'getLoadDir2',
    'auth' => true
]);
$map->post('search', '/search', [
    'controller' => 'App\Controllers\DirectoryController',
    'action' => 'search',
    'auth' => true
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'PAGE 404';
} else {
    $handlerData = $route->handler;
    $actionName = $handlerData['action'];
    $controllerName = $handlerData['controller'];
    $needsAuth = $handlerData['auth'];
    $sessionuserId = $_SESSION['userId'] ?? null;
    if ($needsAuth && !$sessionuserId) {
        $response = new RedirectResponse('/login');
    } else {
        $controller = $container->get($controllerName);
        $response = $controller->$actionName($request);
    }

    foreach ($response->getHeaders() as $headerName => $headerValues) {
        foreach ($headerValues as $headerValue) {
            header(sprintf('%s: %s', $headerName, $headerValue));
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}



// require '../index.php';
