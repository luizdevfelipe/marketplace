<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Auth;


class ProfileController
{
    public function __construct(private ProfileService $profileService) {}

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
