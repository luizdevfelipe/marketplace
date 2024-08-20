<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ProfileController
{
    public function __construct(private UserService $userService, private ProfileService $profileService)
    {
    }

    public function registerPage(): Response
    {
        return response()->view('user.register');
    }

    public function registerValid(): Response
    {
        $erro = $this->userService->registerUser();
        if (!$erro) {
            return $this->perfil();
        }
        return response()->view('user.register', ['erro' => $erro]);
    }

    public function loginPage(): Response
    {
        if (session('id') !== null) {
            header('Location: /perfil');
        }
        return response()->view('user.login');
    }

    public function loginValid(): Response
    {
        $erro = $this->userService->loginUser();
        if (!$erro) {
            $this->perfil();
        }
        return response()->view('user.login', ['erro' => $erro]);
    }

    public function perfil(): Response
    {
        if (session('id') !== null) {
            $data =  $this->profileService->requestData();
            [$user, $products, $purchases] = $data;
            return response()->view('user.profile', ['user' => $user, 'products' => $products, 'purchases' => $purchases]);
        }
        return response()->view('error.profile');
    }

    public function newInsert(): RedirectResponse
    {       
        if (isset($_FILES['foto'])) {           
            $this->profileService->newPhoto();
            return redirect('/perfil');
        }
    }

    public function sair(): RedirectResponse
    {
        session(['id' => null]);
        return redirect('/');
    }
}