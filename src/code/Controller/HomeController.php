<?php 
namespace Code\Controller;
use \Code\View;

class HomeController

{
    public function index(){
        return View::make('index');
    }
}




