@extends('layouts.admin')

@section('title', 'Pengaturan Profil - Admin RASACI')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Banner & Profile Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC] flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <!-- Decorative Accent Blur -->
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#2D5A27]/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 text-left z-10">
            <!-- Avatar with Badge -->
            <div class="relative group shrink-0">
                <img 
                    id="avatar-preview-header"
                    src="{{ $user->avatar_url }}" 
                    alt="{{ $user->name }}" 
                    class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-[#2D5A27]/20 shadow-md transition-transform group-hover:scale-105"
                />
                @if($user->google_id)
                    <div class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow-md border border-stone-200" title="Terhubung dengan Google OAuth">
                        <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="flex flex-col items-start text-left">
                <h1 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 tracking-tight text-left">
                    {{ $user->name }}
                </h1>
                <p class="text-xs text-gray-500 font-light mt-0.5 text-left">
                    {{ $user->email }}
                </p>

                <div class="mt-3 flex flex-wrap items-center justify-start gap-2">
                    <!-- Role Badge -->
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 border border-purple-200 shadow-2xs whitespace-nowrap">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Penjual / Kitchen Lead</span>
                    </span>

                    <!-- Google Auth Badge -->
                    @if($user->google_id)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white text-stone-700 border border-stone-300 shadow-2xs whitespace-nowrap">
                            <svg style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                            <span class="whitespace-nowrap">Google Terkait</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success Notifications -->
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl text-emerald-800 text-xs font-semibold shadow-2xs flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert Error Notifications -->
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl text-rose-800 text-xs font-semibold shadow-2xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabbed Navigation Bar -->
    <div class="flex border-b border-stone-200 bg-white p-1.5 rounded-2xl shadow-xs gap-2">
        <button 
            type="button"
            id="tab-btn-info"
            onclick="switchAdminTab('info')"
            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold transition-all cursor-pointer bg-[#2D5A27] text-white shadow-2xs"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Informasi Diri</span>
        </button>

        <button 
            type="button"
            id="tab-btn-security"
            onclick="switchAdminTab('security')"
            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>Keamanan & Password</span>
        </button>

        <button 
            type="button"
            id="tab-btn-google"
            onclick="switchAdminTab('google')"
            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100"
        >
            <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            <span>Kaitan Google OAuth</span>
        </button>
    </div>

    <!-- TAB 1 CONTENT: Informasi Diri -->
    <div id="tab-content-info" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Foto Profil Card -->
            <div class="lg:col-span-1 bg-white rounded-3xl p-6 shadow-xs border border-[#E5E5DC] space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 border-b border-stone-100 pb-3 mb-4">
                        <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h3 class="text-base font-serif font-bold text-gray-900">Foto Profil Penjual</h3>
                    </div>

                    <form action="{{ route('penjual.profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="flex flex-col items-center justify-center p-5 border-2 border-dashed border-stone-200 rounded-2xl bg-stone-50/50 hover:bg-stone-50 transition-colors text-center">
                            <img 
                                id="avatar-preview-form"
                                src="{{ $user->avatar_url }}" 
                                alt="Preview" 
                                class="w-28 h-28 rounded-full object-cover mb-4 border-2 border-[#2D5A27]/20 shadow-xs"
                            />
                            
                            <label for="avatar-input" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white border border-stone-300 rounded-xl text-xs font-semibold text-stone-700 hover:bg-stone-100 transition-all shadow-2xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Pilih Foto Baru
                            </label>
                            <input 
                                type="file" 
                                id="avatar-input" 
                                name="avatar" 
                                accept="image/*" 
                                class="hidden"
                                onchange="previewAdminImage(event)"
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

            <!-- Right: Form Data Profil Penjual -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC]">
                <div class="flex items-center gap-2 border-b border-stone-100 pb-4 mb-6">
                    <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-serif font-bold text-gray-900">Informasi Diri & Kontak Penjual</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Ubah nama, email, atau kontak operasional katering Anda.</p>
                    </div>
                </div>

                <form action="{{ route('penjual.profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div class="space-y-1.5">
                            <label for="name" class="text-xs font-semibold text-gray-700 block">
                                Nama Lengkap / Display Name
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
                            <label for="email" class="text-xs font-semibold text-gray-700 block">
                                Alamat Email Utama (Username Login)
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', $user->email) }}" 
                                required
                                class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                            />
                            <p class="text-[11px] text-stone-400 font-light">Email ini dapat diubah langsung tanpa perlu verifikasi kode.</p>
                        </div>
                    </div>

                    <!-- Nomor Telepon / WA -->
                    <div class="space-y-1.5">
                        <label for="no_telp" class="text-xs font-semibold text-gray-700 block">
                            Nomor Telepon / WhatsApp Operasional
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

                    <!-- Alamat Dapur / Kantor -->
                    <div class="space-y-1.5">
                        <label for="alamat" class="text-xs font-semibold text-gray-700 block">
                            Alamat Dapur / Kantor Utama
                        </label>
                        <textarea 
                            name="alamat" 
                            id="alamat" 
                            rows="3"
                            placeholder="Alamat lokasi dapur katering..."
                            class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all resize-none"
                        >{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button 
                            type="submit" 
                            class="py-3 px-6 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer"
                        >
                            Simpan Perubahan Profil
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
                <svg class="w-5 h-5 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-serif font-bold text-gray-900">Keamanan & Ubah Password</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Ubah password akun Penjual Anda dengan verifikasi password saat ini.</p>
                </div>
            </div>

            <form action="{{ route('penjual.profile.password.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Password Saat Ini -->
                <div class="space-y-1.5">
                    <label for="current_password" class="text-xs font-semibold text-gray-700 block">
                        Password Saat Ini <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        required
                        placeholder="Masukkan password saat ini untuk verifikasi"
                        class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Password Baru -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-semibold text-gray-700 block">
                            Password Baru <span class="text-rose-500">*</span>
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
                        <label for="password_confirmation" class="text-xs font-semibold text-gray-700 block">
                            Konfirmasi Password Baru <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required
                            placeholder="Ulangi password baru"
                            class="w-full px-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                        />
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button 
                        type="submit" 
                        class="py-3 px-6 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer"
                    >
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TAB 3 CONTENT: Integrasi Google OAuth -->
    <div id="tab-content-google" class="hidden space-y-6">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-[#E5E5DC] space-y-6">
            
            <div class="flex items-center gap-2 border-b border-stone-100 pb-4">
                <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                </svg>
                <div>
                    <h3 class="text-lg font-serif font-bold text-gray-900">Integrasi Akun Google OAuth</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kaitkan akun Google milik Anda untuk opsi login instan ke Admin Dashboard.</p>
                </div>
            </div>

            <!-- Explanatory Banner -->
            <div class="p-4 bg-[#F1F3EA] border border-[#2D5A27]/30 rounded-2xl text-xs leading-relaxed text-stone-700 space-y-1.5">
                <span class="font-bold text-[#2D5A27] block">ℹ️ Catatan Penting Mengenai Login Penjual:</span>
                <p>
                    Mengkaitkan akun Google ke akun Penjual <strong>tidak akan mengganti email login utama Anda</strong> di database (saat ini: <code class="bg-white px-1.5 py-0.5 rounded border border-stone-300 font-mono text-stone-900 font-semibold">{{ $user->email }}</code>).
                </p>
                <p>
                    Sesudah akun Google terhubung, Anda dapat masuk ke Dashboard Penjual menggunakan tombol <em>Sign In with Google</em> secara instan tanpa perlu memasukkan password manual.
                </p>
            </div>

            <!-- Connection Status Box -->
            @if($user->google_id)
                <div class="p-5 bg-emerald-50/80 border border-emerald-200 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-full bg-white border border-emerald-300 flex items-center justify-center shadow-2xs shrink-0">
                            <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-emerald-900">Akun Google Terhubung</span>
                            <span class="block text-[11px] text-emerald-700 font-light mt-0.5">Google ID: {{ $user->google_id }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <a 
                            href="{{ route('penjual.profile.google.link') }}" 
                            class="flex-1 sm:flex-none px-4 py-2.5 bg-white border border-stone-300 rounded-xl text-xs font-semibold text-stone-700 hover:bg-stone-50 transition-all text-center cursor-pointer shadow-2xs"
                        >
                            Ganti Akun Google
                        </a>
                        <form action="{{ route('penjual.profile.google.unlink') }}" method="POST" class="inline">
                            @csrf
                            <button 
                                type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin melepas kaitan akun Google ini?')"
                                class="px-4 py-2.5 bg-rose-50 border border-rose-200 rounded-xl text-xs font-semibold text-rose-700 hover:bg-rose-100 transition-all cursor-pointer shadow-2xs"
                            >
                                Lepas Kaitan
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="p-5 bg-stone-50 border border-stone-200 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-full bg-white border border-stone-300 flex items-center justify-center shadow-2xs shrink-0 text-lg">
                            🔓
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-stone-800">Belum Terkait dengan Google</span>
                            <span class="block text-[11px] text-stone-500 font-light mt-0.5">Klik tombol di samping untuk menghubungkan akun Google Anda.</span>
                        </div>
                    </div>

                    <a 
                        href="{{ route('penjual.profile.google.link') }}" 
                        class="w-full sm:w-auto px-5 py-3 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-xs text-center cursor-pointer flex items-center justify-center gap-2"
                    >
                        <svg style="width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#ffffff"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#ffffff"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#ffffff"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#ffffff"/>
                        </svg>
                        <span>Kaitkan Akun Google</span>
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>

<script>
    function switchAdminTab(tabName) {
        const infoBtn = document.getElementById('tab-btn-info');
        const securityBtn = document.getElementById('tab-btn-security');
        const googleBtn = document.getElementById('tab-btn-google');

        const infoContent = document.getElementById('tab-content-info');
        const securityContent = document.getElementById('tab-content-security');
        const googleContent = document.getElementById('tab-content-google');

        // Hide all
        infoContent.classList.add('hidden');
        securityContent.classList.add('hidden');
        googleContent.classList.add('hidden');

        // Reset classes
        const inactiveClass = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold transition-all cursor-pointer bg-transparent text-stone-600 hover:bg-stone-100";
        const activeClass = "flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold transition-all cursor-pointer bg-[#2D5A27] text-white shadow-2xs";

        infoBtn.className = inactiveClass;
        securityBtn.className = inactiveClass;
        googleBtn.className = inactiveClass;

        if (tabName === 'security') {
            securityContent.classList.remove('hidden');
            securityBtn.className = activeClass;
        } else if (tabName === 'google') {
            googleContent.classList.remove('hidden');
            googleBtn.className = activeClass;
        } else {
            infoContent.classList.remove('hidden');
            infoBtn.className = activeClass;
        }
    }

    function previewAdminImage(event) {
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

    @if ($errors->has('current_password') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            switchAdminTab('security');
        });
    @endif
</script>
@endsection
