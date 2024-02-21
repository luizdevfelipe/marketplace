<?php 
namespace Code\Controller;

use Code\View;

class ProfileController

{
    public function register(): View
    {
        if (isset($_SESSION['id'])){
            $this->perfil();
        }
        return View::make('user/register');
    }

    public function login(): View
    {
        return View::make('user/login');
    }

    public function perfil(): View
    {
        return View::make('user/perfil');
    }


}