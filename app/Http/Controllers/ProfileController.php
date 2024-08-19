<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\View\View;

class ProfileController
{
    public function __construct(private UserService $userService, private ProfileService $profileService)
    {
    }

    public function registerPage(): View
    {
        return view('user/register');
    }

    public function registerValid()
    {
        $erro = $this->userService->registerUser();
        if (!$erro) {
            return $this->perfil();
        }
        return view('user/register', ['erro' => $erro]);
    }

    public function loginPage()
    {
        if (session('id') !== null) {
            header('Location: /perfil');
        }
        return view('user/login');
    }

    public function loginValid(): View
    {
        $erro = $this->userService->loginUser();
        if (!$erro) {
            $this->perfil();
        }
        return view('user/login', ['erro' => $erro]);
    }

    public function perfil(): View
    {
        if (session('id') !== null) {
            $data =  $this->profileService->requestData();
            [$user, $products, $purchases] = $data;

            return view('user/profile', ['user' => $user, 'products' => $products, 'purchases' => $purchases]);
        }
        return view('error/profile');
    }

    public function newInsert()
    {       
        if (isset($_FILES['foto'])) {           
            $this->profileService->newPhoto();
            header('Location: /perfil');
        }
    }

    public function sair()
    {
        session(['id' => null]);
        header('Location: /');
    }
}