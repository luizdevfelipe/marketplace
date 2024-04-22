<?php

namespace Code\Controller;

use Code\Attributes\Get;
use Code\Attributes\Post;
use Code\Models\ProfileModel;
use Code\Models\UserModel;
use Code\View;

class ProfileController
{
    public function __construct(private UserModel $userModel, private ProfileModel $profileModel)
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
        $erro = $this->userModel->registerUser();
        if (!$erro) {
            return $this->perfil();
        } else {
            return View::make('user/register', ['erro' => $erro]);
        }
    }

    #[Get('/login')]
    public function loginPage()
    {
        if (isset($_SESSION['id'])) {
            header('Location: /perfil');
        } else {
            return View::make('user/login');
        }
    }

    #[Post('/login')]
    public function loginValid(): View
    {
        $erro = $this->userModel->loginUser();
        if (!$erro) {
            $this->perfil();
        } else {
            return View::make('user/login', ['erro' => $erro]);
        }
    }

    #[Get('/perfil')]
    public function perfil(): View
    {
        if (isset($_SESSION['id'])) {
            $data =  $this->profileModel->requestData();
            [$user, $products, $purchases] = $data;

            return View::make('user/perfil', ['user' => $user, 'products' => $products, 'purchases' => $purchases]);
        } else {
            return View::make('error/perfil');
        }
    }

    #[Post('/perfil')]
    public function newInsert()
    {
        // inserir a foto ou novo produto e recarregar a página
        if(isset($_POST['descricao'])){
            // insere um novo produto
        } else {
            // insere uma foto de usuário
            $this->profileModel->newPhoto();
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
