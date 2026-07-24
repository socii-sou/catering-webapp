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
            try {
                $googleUser = Socialite::driver('google')->user();
            } catch (Throwable $e) {
                $googleUser = Socialite::driver('google')->stateless()->user();
            }

            // Check if this callback was triggered to link an active seller/user account
            if ($request->session()->has('link_google_user_id')) {
                $targetUserId = $request->session()->pull('link_google_user_id');
                $targetUser = User::find($targetUserId);

                if ($targetUser) {
                    $existingGoogleUser = User::where('google_id', $googleUser->getId())
                        ->where('id', '!=', $targetUser->id)
                        ->first();

                    if ($existingGoogleUser) {
                        $redirectRoute = $targetUser->isPenjual() ? 'penjual.profile.edit' : 'profile.edit';
                        return redirect()->route($redirectRoute)->withErrors([
                            'google' => 'Akun Google (' . $googleUser->getEmail() . ') ini sudah dikaitkan dengan pengguna lain.'
                        ]);
                    }

                    $targetUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $targetUser->avatar ?: $googleUser->getAvatar(),
                    ]);

                    Auth::login($targetUser, true);
                    $request->session()->regenerate();

                    if ($targetUser->isPenjual()) {
                        return redirect()->route('penjual.profile.edit')->with('success', 'Akun Google (' . $googleUser->getEmail() . ') berhasil dikaitkan!');
                    }

                    return redirect()->route('profile.edit')->with('success', 'Akun Google (' . $googleUser->getEmail() . ') berhasil dikaitkan!');
                }
            }

            // Normal login/signup flow
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
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
            return redirect()->route('login')->withErrors(['google' => 'Gagal melakukan autentikasi dengan Google (' . $e->getMessage() . '). Silakan coba lagi.']);
        }
    }
}
