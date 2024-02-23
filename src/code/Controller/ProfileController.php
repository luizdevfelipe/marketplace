<?php

namespace Code\Controller;

use Code\Models\Queries;
use Code\Models\UserModel;
use Code\View;

class ProfileController

{
    public function registerPage(): View
    {
        return View::make('user/register');
    }

    public function registerValid()
    {
        $erro = (new UserModel(new Queries))->registerUser();
        if (!$erro) {
            $this->perfil();
        } else {
            return View::make('user/register', ['erro' => $erro]);
        }
    }

    public function loginPage(): View
    {
        if (isset($_SESSION['id'])) {
            $this->perfil();
        }
        return View::make('user/login');
    }

    public function loginValid()
    {
        $erro = (new UserModel(new Queries))->loginUser();
        if (!$erro) {
            $this->perfil();
        } else {
            return View::make('user/login', ['erro' => $erro]);
        }
    }

    public function perfil(): View
    {
        return View::make('user/perfil');
    }
}
