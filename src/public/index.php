<?php

use Code\App;
use Code\DB;
use \Code\Router;
use \Code\Controller\HomeController;
use \Code\Controller\ProfileController;
use \Code\Controller\ProductController;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('VIEW_PATH', __DIR__ . '/../view');
define('STORAGE_PATH', __DIR__ . '/../storage');

$router = new Router();

$router->get('/', [HomeController::class, 'index'])
    ->get('/perfil', [ProfileController::class, 'index'])
    ->get('/login', [ProfileController::class, 'login'])
    ->get('/registro', [ProfileController::class, 'register'])
    ->get('/produto', [ProductController::class, 'index']);

(new App($router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD']
], new DB($_ENV)))->run();
