<?php

namespace Code\Controller;

use Code\Models\ProfileModel;
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
            return $this->perfil();
        } else {
            return View::make('user/register', ['erro' => $erro]);
        }
    }

    public function loginPage()
    {
        if (isset($_SESSION['id'])) {
            return $this->perfil();
        } else {
            return View::make('user/login');
        }       
    }

    public function loginValid(): View
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
        if (isset($_SESSION['id'])) {
            // comandos para pegar os dados necessários
           $data =  (new ProfileModel(new Queries))->requestData() ;
           [$user, $products, $purchases] = $data;

            return View::make('user/perfil', ['user' => $user, 'products' => $products, 'purchases' => $purchases ]);
        } else {
            return View::make('error/perfil');
        }
        
    }

    public function sair()
    {
        unset($_SESSION['id']);
        header('Location: /');
    }
}
