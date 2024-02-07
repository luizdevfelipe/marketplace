<?php 
use \Code\Router;
use \Code\Controller\HomeController;
require_once __DIR__ . '/../vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/../view');

try{
    $router = new Router();

    $router->get('/', [HomeController::class, 'index']);

    echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (\Code\Exeption\RouteNotFoundExeption){
    http_response_code(404);    
}
