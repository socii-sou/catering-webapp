<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\WelcomeMail;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class WebAuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $loginField => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isPenjual()) {
                return redirect()->intended('/penjual/dashboard');
            }

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'login' => ['Kredensial yang Anda berikan tidak cocok dengan data kami.'],
        ]);
    }

    /**
     * Tampilkan form registrasi langkah 1 (Data Diri).
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        return view('auth.register');
    }

    /**
     * Proses registrasi langkah 1: Simpan data awal & Kirim OTP.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telp' => ['required', 'string', 'max:20', 'unique:users,no_telp'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.unique' => 'Nama lengkap/username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'no_telp' => $request->no_telp,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'verified_at' => null,
            ]
        );

        $request->session()->put('register_email', $request->email);

        try {
            Mail::to($request->email)->send(new OtpMail($otp, $request->name));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('register.otp.show')->with('success', 'Kode OTP verifikasi telah dikirimkan ke email Anda.');
    }

    /**
     * Tampilkan halaman verifikasi OTP (Langkah 2).
     */
    public function showVerifyOtp(Request $request)
    {
        if (! $request->session()->has('register_email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp');
    }

    /**
     * Proses verifikasi OTP.
     */
    public function verifyOtp(Request $request)
    {
        $email = $request->session()->get('register_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $otpRecord = EmailOtp::where('email', $email)->first();

        if (! $otpRecord || $otpRecord->otp !== $request->otp) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP yang Anda masukkan salah.'],
            ]);
        }

        if ($otpRecord->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP sudah kadaluwarsa (lebih dari 10 menit). Silakan klik kirim ulang OTP.'],
            ]);
        }

        $otpRecord->update(['verified_at' => now()]);

        return redirect()->route('register.password.show')->with('success', 'Email berhasil diverifikasi! Silakan buat password akun Anda.');
    }

    /**
     * Kirim ulang kode OTP.
     */
    public function resendOtp(Request $request)
    {
        $email = $request->session()->get('register_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $otpRecord = EmailOtp::where('email', $email)->first();

        if (! $otpRecord) {
            return redirect()->route('register');
        }

        $newOtp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $otpRecord->update([
            'otp' => $newOtp,
            'expires_at' => now()->addMinutes(10),
            'verified_at' => null,
        ]);

        try {
            Mail::to($email)->send(new OtpMail($newOtp, $otpRecord->name));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('register.otp.show')->with('success', 'Kode OTP baru telah berhasil dikirimkan ke email Anda.');
    }

    /**
     * Tampilkan form buat password (Langkah 3).
     */
    public function showSetPassword(Request $request)
    {
        $email = $request->session()->get('register_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $otpRecord = EmailOtp::where('email', $email)->whereNotNull('verified_at')->first();

        if (! $otpRecord) {
            return redirect()->route('register.otp.show');
        }

        return view('auth.set-password');
    }

    /**
     * Simpan password & selesaikan registrasi.
     */
    public function setPassword(Request $request)
    {
        $email = $request->session()->get('register_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $otpRecord = EmailOtp::where('email', $email)->whereNotNull('verified_at')->first();

        if (! $otpRecord) {
            return redirect()->route('register.otp.show');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = User::create([
            'name' => $otpRecord->name,
            'email' => $otpRecord->email,
            'no_telp' => $otpRecord->no_telp,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan',
            'email_verified_at' => now(),
        ]);

        $otpRecord->delete();
        $request->session()->forget('register_email');

        Auth::login($user);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect('/')->with('status', 'Registrasi berhasil dan email Anda terverifikasi! Anda telah otomatis masuk.');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah berhasil keluar.');
    }
}
