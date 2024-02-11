<?php 
namespace Code\Controller;

use Code\View;

class ProfileController

{
    public function register(): View
    {
        if (isset($_SESSION['id'])){
            $this->index();
        }
        return View::make('user/login');
    }

    public function index()
    {
        return View::make('user/perfil');
    }


}