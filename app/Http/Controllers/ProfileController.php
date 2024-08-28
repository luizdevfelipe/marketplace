<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;

class ProfileController
{
    public function __construct(private UserService $userService, private ProfileService $profileService) {}

    public function registerPage(): Response
    {
        return response()->view('user.register');
    }

    public function registerValid(Request $request): Response|RedirectResponse
    {
        $data = $request->validate([
            'email' => 'bail|required|email',
            'name' => 'bail|required|min:4|max:30',
            'lastname' => 'bail|required|min:4|max:30',
            'state' => 'bail|required|size:2',
            'city' => 'bail|required|min:4|max:40',
            'pass1' => 'bail|required|min:8|max:60',
            'pass2' => 'bail|required|min:8|max:60|same:pass1',
        ]);

        if ($this->userService->registerUser($data)) return redirect('/perfil');
        
        return response()->view('user.register', ['error' => 'Email já utilizado']);
    }

    public function loginPage(): Response|RedirectResponse
    {
        if (session()->has('id')) return redirect('/perfil');
        
        return response()->view('user.login');
    }

    public function loginValid(Request $request): Response|RedirectResponse
    {
        $data = $request->validate([
            'email' => 'bail|required|email',
            'senha' => 'bail|required|min:8|max:60',
        ]);

        if ($this->userService->loginUser($data)) return redirect('/perfil');
        
        return response()->view('user.login', ['error' => 'Email e/ou senha inválido(s)']);
    }

    public function perfil(): Response
    {
        if (session()->has('id')) {
            [$user, $products, $purchases] = $this->profileService->requestData();
            return response()->view('user.profile', ['user' => $user, 'products' => $products, 'purchases' => $purchases]);
        }
        return response()->view('error.profile');
    }

    public function newProfilePicture(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'foto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->profileService->newPhoto($data['foto']);

        return redirect('/perfil');
    }

    public function sair(): RedirectResponse
    {
        session()->remove('id');
        return redirect('/');
    }
}
