<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect('/login')->with('error', 'Session expired. Please login again.');
        }

        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect('/login')->with('error', 'Session expired');
        }

        $freshUser = User::find($user->id);

        if (
            !$freshUser ||
            $freshUser->otp_code !== $request->otp ||
            now()->greaterThan($freshUser->otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $freshUser->update([
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        Auth::login($freshUser);
        session()->forget('otp_user_id');

        return redirect()->intended('/dashboard');
    }

    public function resendOtp(Request $request)
    {
        try {
            $userId = session('otp_user_id');
            if (!$userId) {
                return response()->json(['error' => 'Session expired'], 419);
            }

            $user = User::findOrFail($userId);

            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            User::where('id', $userId)->update([
                'otp_code' => $otp,
                'otp_expires_at' => now()->addMinutes(5)
            ]);

            $user->refresh();

            $emailContent = <<<EOT
Hello {$user->name},

Your new OTP code is:

--------------------------
    {$otp}
--------------------------

This code is valid for 5 minutes.

If you did not request this code, please ignore this email.

Thank you,
The Team
EOT;

            Mail::raw($emailContent, function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your New Verification Code');
            });

            return response()->json([
                'status' => 'New OTP sent successfully',
                'cooldown' => 60
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to resend OTP'], 500);
        }
    }
}
