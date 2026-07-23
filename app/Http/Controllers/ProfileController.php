<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil / pengaturan user.
     */
    public function edit()
    {
        $user = Auth::user();
        $myOrders = $user->pesanans()
            ->with(['pesananPaket.paket', 'pembayarans', 'pengiriman', 'review'])
            ->latest()
            ->get();

        return view('profile.edit', compact('user', 'myOrders'));
    }

    /**
     * Update data diri (nama, email, no_telp, alamat).
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.unique' => 'Nama sudah digunakan oleh pengguna lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Data profil berhasil diperbarui!');
    }

    /**
     * Update foto profil.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ], [
            'avatar.required' => 'Pilih foto yang akan diunggah.',
            'avatar.image' => 'Berkas harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'avatar.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Hapus foto profil lama jika ada di local storage
        if ($user->avatar && !str_starts_with($user->avatar, 'http://') && !str_starts_with($user->avatar, 'https://')) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $rules = [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Jika user bukan terdaftar via Google OAuth dan memiliki password, wajibkan current_password
        $requiresCurrentPassword = !empty($user->password) && empty($user->google_id);

        if ($requiresCurrentPassword) {
            $rules['current_password'] = ['required', 'string'];
        }

        $messages = [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ];

        $request->validate($rules, $messages);

        if ($requiresCurrentPassword && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}
