<?php 
namespace Code\Exeption;

class RouteNotFoundExeption extends \Exception
{
    protected $message = 'Rota não encontrada';
}