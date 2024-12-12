<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;

class EmailVerificationController
{
    /**
     * Show the email verify view to the user.
     */
    public function emailVerifyView(): Response
    {
        return response()->view('error.verify-email');
    }

    /**
     * Checks the current user's email.
     */
    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        return redirect('/perfil');
    }

    /**
     * Resends the verification email to the user
     */
    public function resentVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}


