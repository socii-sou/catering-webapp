@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="min-h-screen bg-[#F8F8F2] py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Banner & User Profile Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC] flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <!-- Decorative Accent Blur -->
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#2D5A27]/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 text-left z-10">
                <!-- Avatar with Badge -->
                <div class="relative group flex-shrink-0">
                    <img
                        id="avatar-preview-header"
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}"
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-[#2D5A27]/20 shadow-md transition-transform group-hover:scale-105"
                    />
                    @if($user->google_id)
                        <div class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow-md border border-stone-200" title="Akun Terhubung dengan Google">
                            <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-start text-left">
                    <h1 class="text-2xl sm:text-3xl font-serif font-bold text-stone-900 tracking-tight text-left">
                        {{ $user->name }}
                    </h1>
                    <p class="text-sm text-stone-500 font-light mt-0.5 text-left">
                        {{ $user->email }}
                    </p>
                    <div class="mt-2.5 flex flex-wrap items-center justify-start gap-2">
                        <!-- Role Badge -->
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#2D5A27]/10 text-[#2D5A27] border border-[#2D5A27]/20 shadow-2xs whitespace-nowrap">
                            <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px;" class="w-3.5 h-3.5 text-[#2D5A27] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="whitespace-nowrap">Akun {{ ucfirst($user->role) }}</span>
                        </span>

                        <!-- Google Auth Badge -->
                        @if($user->google_id)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-white text-stone-700 border border-stone-300 shadow-2xs whitespace-nowrap">
                                <svg style="width: 14px; height: 14px; min-width: 14px; min-height: 14px;" class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                                </svg>
                                <span class="whitespace-nowrap">Google Auth</span>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('pesanan.index') }}" class="z-10 inline-flex items-center gap-2 px-4 py-2.5 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-sm font-semibold rounded-xl transition-all shadow-xs cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                Pesanan Saya
            </a>
        </div>

        <!-- Global Alert Notifications -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl text-emerald-800 text-sm font-medium shadow-xs flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl text-rose-800 text-sm font-medium shadow-xs">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabbed Navigation Header -->
        <div class="flex border-b border-stone-200 bg-white p-1.5 rounded-2xl shadow-xs gap-2">
            <button
                type="button"
                id="tab-btn-profile"
                onclick="switchTab('profile')"
                class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-[#2D5A27] text-white shadow-xs"
            >
                <!-- User / ID Card Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span>Data Diri Personal</span>
            </button>

            <button
                type="button"
                id="tab-btn-security"
                onclick="switchTab('security')"
                class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100"
            >
                <!-- Shield / Security Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                </svg>
                <span>Keamanan & Password</span>
            </button>
        </div>

        <!-- TAB 1 CONTENT: Data Diri Personal -->
        <div id="tab-content-profile" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left: Foto Profil Card -->
                <div class="lg:col-span-1 bg-white rounded-3xl p-6 shadow-xs border border-[#E5E5DC] space-y-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 border-b border-stone-100 pb-3 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-[#2D5A27]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                            <h3 class="text-base font-serif font-bold text-stone-900">Foto Profil</h3>
                        </div>

                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-stone-200 rounded-2xl bg-stone-50/50 hover:bg-stone-50 transition-colors text-center">
                                <img
                                    id="avatar-preview-form"
                                    src="{{ $user->avatar_url }}"
                                    alt="Preview"
                                    class="w-28 h-28 rounded-full object-cover mb-4 border-2 border-[#2D5A27]/20 shadow-xs"
                                />

                                <label for="avatar-input" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white border border-stone-300 rounded-xl text-xs font-semibold text-stone-700 hover:bg-stone-100 transition-all shadow-2xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    Pilih Gambar Baru
                                </label>
                                <input
                                    type="file"
                                    id="avatar-input"
                                    name="avatar"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(event)"
                                />
                                <span class="text-[11px] text-stone-400 mt-2">Maksimal 2MB (JPG, PNG, WEBP)</span>
                            </div>

                            <button
                                type="submit"
                                class="w-full py-3 px-4 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-xs cursor-pointer"
                            >
                                Simpan Foto Profil
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Form Data Diri -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC]">
                    <div class="flex items-center gap-2 border-b border-stone-100 pb-4 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-[#2D5A27]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-serif font-bold text-stone-900">Informasi Pribadi</h3>
                            <p class="text-xs text-stone-500 mt-0.5">Perbarui informasi diri dan Kontak Anda.</p>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Nama Lengkap -->
                            <div class="space-y-1.5">
                                <label for="name" class="text-xs font-semibold text-stone-700 block">
                                    Nama Lengkap / Username
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                                />
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5">
                                <label for="email" class="text-xs font-semibold text-stone-700 block">
                                    Alamat Email
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                                />
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="space-y-1.5">
                            <label for="no_telp" class="text-xs font-semibold text-stone-700 block">
                                Nomor Telepon / WhatsApp
                            </label>
                            <input
                                type="tel"
                                name="no_telp"
                                id="no_telp"
                                value="{{ old('no_telp', $user->no_telp) }}"
                                placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                            />
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button
                                type="submit"
                                class="py-3 px-6 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer"
                            >
                                Simpan Data Diri
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- TAB 2 CONTENT: Keamanan & Password -->
        <div id="tab-content-security" class="hidden space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC] space-y-6">

                <div class="flex items-center gap-2 border-b border-stone-100 pb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-[#2D5A27]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-serif font-bold text-stone-900">Keamanan & Password</h3>
                        <p class="text-xs text-stone-500 mt-0.5">Kelola kata sandi untuk keamanan akun Anda.</p>
                    </div>
                </div>

                <!-- Google OAuth Info Notice Banner -->
                @if($user->google_id)
                    <div class="p-4 bg-blue-50/80 border border-blue-200 rounded-2xl text-blue-900 text-xs sm:text-sm leading-relaxed space-y-2">
                        <div class="flex items-center gap-2 font-bold text-blue-800">
                            <!-- Google Logo -->
                            <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                            <span>Informasi Akun Terhubung Google</span>
                        </div>
                        <p class="text-stone-600 font-light">
                            Anda mendaftar/masuk menggunakan <strong>Akun Google ({{ $user->email }})</strong>. Saat ini Anda belum menyetel password manual. Anda dapat langsung memasukkan password baru di bawah ini jika ingin mengaktifkan opsi login biasa menggunakan Email & Password.
                        </p>
                    </div>
                @endif

                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Password Saat Ini (Hanya muncul jika bukan user Google) -->
                    @if(empty($user->google_id) && !empty($user->password))
                        <div class="space-y-1.5">
                            <label for="current_password" class="text-xs font-semibold text-stone-700 block">
                                Password Saat Ini
                            </label>
                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                required
                                placeholder="••••••••"
                                class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                            />
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Password Baru -->
                        <div class="space-y-1.5">
                            <label for="password" class="text-xs font-semibold text-stone-700 block">
                                Password Baru
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                            />
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="text-xs font-semibold text-stone-700 block">
                                Konfirmasi Password Baru
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                required
                                placeholder="••••••••"
                                class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                            />
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button
                            type="submit"
                            class="py-3 px-6 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer"
                        >
                            {{ $user->google_id ? 'Buat Password Manual' : 'Perbarui Password' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tabName) {
        const profileTabBtn = document.getElementById('tab-btn-profile');
        const securityTabBtn = document.getElementById('tab-btn-security');
        const profileContent = document.getElementById('tab-content-profile');
        const securityContent = document.getElementById('tab-content-security');

        if (tabName === 'security') {
            securityContent.classList.remove('hidden');
            profileContent.classList.add('hidden');

            securityTabBtn.className = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-[#2D5A27] text-white shadow-xs";
            profileTabBtn.className = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100";
        } else {
            profileContent.classList.remove('hidden');
            securityContent.classList.add('hidden');

            profileTabBtn.className = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-[#2D5A27] text-white shadow-xs";
            securityTabBtn.className = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100";
        }
    }

    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview-form').src = e.target.result;
                document.getElementById('avatar-preview-header').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto switch to security tab if there are password errors
    @if ($errors->has('password') || $errors->has('current_password'))
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('security');
        });
    @endif
</script>
@endsection
