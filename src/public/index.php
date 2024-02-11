<?php

use Code\App;
use \Code\Router;
use \Code\Controller\HomeController;
use \Code\Controller\ProfileController;

require_once __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../view');
define('STORAGE_PATH', __DIR__ . '/../storage');

$router = new Router();

$router->get('/', [HomeController::class, 'index'])
    ->get('/perfil', [ProfileController::class, 'index'])
    ->get('/registro', [ProfileController::class, 'register']);

(new App($router, ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]))->run();
