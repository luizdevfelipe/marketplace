<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function __construct(private UserService $userService) {}

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
}
