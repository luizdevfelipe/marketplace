<?php

namespace Code\Controller;

use Code\Attributes\Get;
use Code\Attributes\Post;
use Code\Service\ProfileService;
use Code\Service\UserService;
use Code\View;

class ProfileController
{
    public function __construct(private UserService $userService, private ProfileService $profileService)
    {
    }

    #[Get('/registro')]
    public function registerPage(): View
    {
        return View::make('user/register');
    }

    #[Post('/registro')]
    public function registerValid()
    {
        $erro = $this->userService->registerUser();
        if (!$erro) {
            return $this->perfil();
        }
        return View::make('user/register', ['erro' => $erro]);
    }

    #[Get('/login')]
    public function loginPage()
    {
        if (isset($_SESSION['id'])) {
            header('Location: /perfil');
        }
        return View::make('user/login');
    }

    #[Post('/login')]
    public function loginValid(): View
    {
        $erro = $this->userService->loginUser();
        if (!$erro) {
            $this->perfil();
        }
        return View::make('user/login', ['erro' => $erro]);
    }

    #[Get('/perfil')]
    public function perfil(): View
    {
        if (isset($_SESSION['id'])) {
            $data =  $this->profileService->requestData();
            [$user, $products, $purchases] = $data;

            return View::make('user/perfil', ['user' => $user, 'products' => $products, 'purchases' => $purchases]);
        }
        return View::make('error/perfil');
    }

    #[Post('/perfil')]
    public function newInsert()
    {       
        if (isset($_FILES['foto'])) {           
            $this->profileService->newPhoto();
            header('Location: /perfil');
        }
    }

    #[Post('/sair')]
    public function sair()
    {
        unset($_SESSION['id']);
        header('Location: /');
    }
}
