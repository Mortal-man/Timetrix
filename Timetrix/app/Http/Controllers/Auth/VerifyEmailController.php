<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\User; // Add this import

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = User::findOrFail($request->route('id')); // Now correctly referenced

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('verification.already');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        auth()->logout();
        return redirect()->route('verification.success');
    }
}
