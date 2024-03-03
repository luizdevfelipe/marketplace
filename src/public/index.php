<?php

use Code\App;
use Code\DB;
use \Code\Router;
use \Code\Controller\HomeController;
use \Code\Controller\ProfileController;
use \Code\Controller\ProductController;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('VIEW_PATH', __DIR__ . '/../view');
define('STORAGE_PATH', __DIR__ . '/../storage');

$router = new Router();

$router->get('/', [HomeController::class, 'index'])
    ->get('/perfil', [ProfileController::class, 'perfil'])
    ->get('/login', [ProfileController::class, 'loginPage'])
    ->post('/login', [ProfileController::class, 'loginValid'])
    ->get('/registro', [ProfileController::class, 'registerPage'])
    ->post('/registro', [ProfileController::class, 'registerValid'])
    ->get('/produto', [ProductController::class, 'index'])
    ->post('/sair', [ProfileController::class, 'sair']);

(new App($router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD']
], new DB($_ENV)))->run();
