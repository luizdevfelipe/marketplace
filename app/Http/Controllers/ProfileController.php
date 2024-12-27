<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;

class ProfileController
{
    public function __construct
    (
        private ProfileService $profileService,
        private AuthManager $auth
    ) 
    {}

    public function perfil(): Response
    {
        $user = $this->profileService->getUserData($this->auth->id());

        return response()->view('user.profile', ['user' => $user]);
    }

    public function load()
    {
        $purchases = $this->profileService->getPaginatedPurchases($this->auth->id());
        $products = $this->profileService->getPaginatedProducts($this->auth->id());

        return [
            'purchases' => $purchases,
            'products' => $products
        ];
    }

    public function newProfilePicture(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'foto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->profileService->newPhoto($data['foto'], $this->auth->id());

        return redirect('/perfil');
    }

    public function sair(Request $request): RedirectResponse
    {
        $this->auth->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
