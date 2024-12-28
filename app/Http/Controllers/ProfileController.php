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
        private AuthManager $auth,
        private Request $request
    ) 
    {}

    public function perfil(): Response
    {
        $user = $this->profileService->getUserData($this->auth->id());

        return response()->view('user.profile', ['user' => $user]);
    }

    public function load()
    {
        if ($this->request->has('products')) {
            $products = $this->profileService->getPaginatedProducts($this->auth->id());

            return response()->json($products);
        } 

        if ($this->request->has('purchases')) {
            $purchases = $this->profileService->getPaginatedPurchases($this->auth->id());

            return response()->json($purchases);
        }        
        
        $purchases = $this->profileService->getPaginatedPurchases($this->auth->id());
        $products = $this->profileService->getPaginatedProducts($this->auth->id());

        return [
            'purchases' => $purchases,
            'products' => $products
        ];
    }

    public function newProfilePicture(): RedirectResponse
    {
        $data = $this->request->validate([
            'foto' => ['bail', 'required', File::types(['jpg', 'jpeg', 'png'])->max('5mb')],
        ]);

        $this->profileService->newPhoto($data['foto'], $this->auth->id());

        return redirect('/perfil');
    }

    public function sair(): RedirectResponse
    {
        $this->auth->logout();

        $this->request->session()->invalidate();

        $this->request->session()->regenerateToken();

        return redirect('/');
    }
}
