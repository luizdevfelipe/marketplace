<?php

use Code\App;

use Code\Controller\CardController;
use Code\DB;
use \Code\Router;
use \Code\Controller\HomeController;
use \Code\Controller\ProfileController;
use \Code\Controller\ProductController;
use Illuminate\Container\Container;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('VIEW_PATH', __DIR__ . '/../view');
define('STORAGE_PATH', __DIR__ . '/../storage');

$container = new Container();
$router = new Router($container);

$router->registerRoutesFromAttributes([
    HomeController::class,
    ProfileController::class,
    ProductController::class,
    CardController::class
]);

(new App(
    $router,
    $container,
    [
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD']
    ]
))->run();
