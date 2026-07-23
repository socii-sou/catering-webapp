<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google's OAuth server.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google OAuth server.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find user by google_id or by email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update google_id, avatar, or email_verified_at if missing
                $updateData = [];
                if (empty($user->google_id)) {
                    $updateData['google_id'] = $googleUser->getId();
                }
                if (empty($user->avatar) && $googleUser->getAvatar()) {
                    $updateData['avatar'] = $googleUser->getAvatar();
                }
                if (empty($user->email_verified_at)) {
                    $updateData['email_verified_at'] = now();
                }
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } else {
                // Automatic account creation (signup) if user doesn't exist yet
                $name = $googleUser->getName() ?: ($googleUser->getNickname() ?: explode('@', $googleUser->getEmail())[0]);

                $user = User::create([
                    'name' => $name,
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'pelanggan',
                    'email_verified_at' => now(),
                ]);

                try {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeMail($user));
                } catch (\Throwable $e) {
                    \report($e);
                }
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            if ($user->isPenjual()) {
                return redirect()->intended('/penjual/dashboard')->with('status', 'Berhasil masuk dengan akun Google!');
            }

            return redirect()->intended('/')->with('status', 'Berhasil masuk dengan akun Google!');
        } catch (Throwable $e) {
            report($e);
            return redirect()->route('login')->withErrors(['google' => 'Gagal melakukan autentikasi dengan Google. Silakan coba lagi.']);
        }
    }
}
