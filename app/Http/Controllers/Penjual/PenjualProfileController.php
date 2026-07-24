<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PenjualProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil penjual.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('penjual.profile', compact('user'));
    }

    /**
     * Update data profil dasar (Nama, Email, No Telp, Alamat).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('penjual.profile.edit')->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Update foto profil (avatar).
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'avatar.required' => 'Pilih file gambar foto profil.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored locally
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return redirect()->route('penjual.profile.edit')->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update password dengan verifikasi password saat ini.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini yang Anda masukkan salah.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('penjual.profile.edit')->with('success', 'Password Anda berhasil diperbarui.');
    }

    /**
     * Mulai alur mengkaitkan / mengganti akun Google OAuth.
     */
    public function linkGoogleRedirect(Request $request)
    {
        $request->session()->put('link_google_user_id', Auth::id());
        return redirect()->route('auth.google.redirect');
    }

    /**
     * Lepas kaitan akun Google OAuth.
     */
    public function unlinkGoogle(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'google_id' => null,
        ]);

        return redirect()->route('penjual.profile.edit')->with('success', 'Kaitan akun Google berhasil dilepas.');
    }
}
