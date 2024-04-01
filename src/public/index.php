<?php

use Code\App;
use Code\Container;
use Code\Controller\CardController;
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

$router = new Router(new Container());

$router->get('/', [HomeController::class, 'index'])
    ->get('/perfil', [ProfileController::class, 'perfil'])
    ->post('/perfil', [ProfileController::class, 'newInsert'])
    ->get('/login', [ProfileController::class, 'loginPage'])
    ->post('/login', [ProfileController::class, 'loginValid'])
    ->get('/registro', [ProfileController::class, 'registerPage'])
    ->post('/registro', [ProfileController::class, 'registerValid'])
    ->get('/produto', [ProductController::class, 'index'])
    ->post('/produto', [ProductController::class, 'buying'])
    ->get('/pesquisa', [ProductController::class, 'search'])
    ->post('/novoproduto', [ProductController::class, 'newProduct'])
    ->post('/sair', [ProfileController::class, 'sair'])
    ->get('/carrinho', [CardController::class, 'index'])
    ->get('/remover', [CardController::class, 'remove'])
    ;

(new App($router, [
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD']
], new DB($_ENV)))->run();
