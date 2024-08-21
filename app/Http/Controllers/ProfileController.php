<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController
{
    public function __construct(private UserService $userService, private ProfileService $profileService) {}

    public function registerPage(): Response
    {
        return response()->view('user.register');
    }

    public function registerValid(Request $request): Response|RedirectResponse
    {
        $data = $request->input();
        $validMessage = $this->userService->registerUser($data);
        if ($validMessage === true) {
            return redirect('/perfil');
        }
        return response()->view('user.register', ['erro' => $validMessage]);
    }

    public function loginPage(): Response|RedirectResponse
    {
        if (session()->has('id')) {
            return redirect('/perfil');
        }
        return response()->view('user.login');
    }

    public function loginValid(Request $request): Response|RedirectResponse
    {
        $data = $request->input();
        $validMessage = $this->userService->loginUser($data);

        if ($validMessage === true) {
            return redirect('/perfil');
        }
        return response()->view('user.login', ['erro' => $validMessage]);
    }

    public function perfil(): Response
    {
        if (session()->has('id')) {
            [$user, $products, $purchases] = $this->profileService->requestData();
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
        session()->remove('id');
        return redirect('/');
    }
}
