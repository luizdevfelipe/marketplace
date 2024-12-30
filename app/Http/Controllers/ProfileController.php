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
    private int $userId;

    public function __construct
    (
        private ProfileService $profileService,
        private AuthManager $auth,
        private Request $request
    ) 
    {
        $this->userId = $this->auth->id();
    }

    public function perfil(): Response
    {
        $user = $this->profileService->getUserData($this->userId);

        return response()->view('user.profile', ['user' => $user]);
    }

    public function load()
    {
        if ($this->request->has('products')) {
            $products = $this->profileService->getPaginatedProducts($this->userId);

            if ($products->total() === 0) $products = null;

            return response()->json($products);
        } 

        if ($this->request->has('purchases')) {
            $purchases = $this->profileService->getPaginatedPurchases($this->userId);

            if ($purchases->total() === 0) $purchases = null;

            return response()->json($purchases);
        }        
        
        $purchases = $this->profileService->getPaginatedPurchases($this->userId);
        $products = $this->profileService->getPaginatedProducts($this->userId);

        if ($products->total() === 0) $products = null;
        if ($purchases->total() === 0) $purchases = null;

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

        $this->profileService->newPhoto($data['foto'], $this->userId);

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
