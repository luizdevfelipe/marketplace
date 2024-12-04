<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;

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

        if (($user = $this->userService->registerUser($data)) !== false) {
            event(new Registered($user));

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['pass1']], false)) {
                $request->session()->regenerate();
            }

            return redirect('/email-verify');
        }

        return response()->view('user.register', ['error' => 'Email já utilizado']);
    }

    public function loginPage(): Response|RedirectResponse
    {
        if (Auth::viaRemember() || Auth::check()) return redirect('/perfil');

        return response()->view('user.login');
    }

    public function loginValid(Request $request): Response|RedirectResponse
    {
        $data = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:8|max:60',
        ]);

        $remember = ($request->validate(['remember' => Rule::in(['on'])])['remember'] ?? null) == 'on' ? true : false;

        if (Auth::attempt($data, $remember)) {
            $request->session()->regenerate();
            return redirect('/perfil');
        }

        return response()->view('user.login', ['error' => 'Email e/ou senha inválido(s)']);
    }

    public function perfil(): Response
    {
        [$user, $products, $purchases] = $this->profileService->requestData(Auth::id());

        return response()->view(
            'user.profile',
            [
                'user' => $user,
                'products' => $products,
                'purchases' => $purchases
            ]
        );
    }

    public function newProfilePicture(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'foto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->profileService->newPhoto($data['foto'], Auth::id());

        return redirect('/perfil');
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
