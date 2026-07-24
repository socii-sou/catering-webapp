@extends('layouts.admin')

@section('title', 'Daftar Pengguna - Admin RASACI')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Header Banner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E5E5DC] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#2D5A27]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#2D5A27]/10 text-[#2D5A27] mb-3">
                <svg class="w-4 h-4 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Manajemen User</span>
            </span>
            <h2 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 tracking-tight">
                Daftar Pengguna Sistem
            </h2>
            <p class="text-xs text-gray-500 font-light mt-1 max-w-xl">
                Kelola seluruh akun pengguna terdaftar baik pelanggan maupun penjual/admin pada platform RASACI Catering.
            </p>
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
    @if (session('error'))
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-2xl text-rose-800 text-xs font-semibold shadow-2xs flex items-center gap-2.5">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- User Metrics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Card 1: Total Pengguna -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($totalUsersCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Total Pengguna</span>
            </div>
        </div>

        <!-- Card 2: Pelanggan -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($pelangganCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Pelanggan</span>
            </div>
        </div>

        <!-- Card 3: Penjual / Admin -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($penjualCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Penjual / Admin</span>
            </div>
        </div>

        <!-- Card 4: Terverifikasi -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($verifiedCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Email Verified</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E5DC] shadow-2xs">
        <form action="{{ route('penjual.users') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto flex-1">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari nama, email, atau no telp..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-[#F1F3EA] border border-transparent rounded-xl text-xs text-gray-900 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                    />
                </div>

                <!-- Role Filter Dropdown -->
                <select name="role" onchange="this.form.submit()" class="w-full sm:w-48 px-3.5 py-2.5 bg-[#F1F3EA] border border-transparent rounded-xl text-xs font-semibold text-gray-700 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] cursor-pointer">
                    <option value="">Semua Role</option>
                    <option value="pelanggan" {{ $role === 'pelanggan' ? 'selected' : '' }}>Role: Pelanggan</option>
                    <option value="penjual" {{ $role === 'penjual' ? 'selected' : '' }}>Role: Penjual</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-2xs cursor-pointer w-full sm:w-auto">
                    Cari
                </button>

                @if($search || $role)
                    <a href="{{ route('penjual.users') }}" class="px-3.5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs font-medium rounded-xl transition-all text-center w-full sm:w-auto">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Data Table -->
    <div class="bg-white rounded-3xl border border-[#E5E5DC] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8F8F2] border-b border-[#E5E5DC] text-gray-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">No. Telp / WA</th>
                        <th class="px-6 py-4">Tipe Autentikasi</th>
                        <th class="hidden px-6 py-4">Status Verifikasi</th>
                        <th class="px-6 py-4">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5DC] text-gray-700 font-medium">
                    @forelse($users as $u)
                        <tr class="hover:bg-[#F8F8F2]/60 transition-colors">
                            <!-- User Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $u->avatar_url }}" 
                                        alt="{{ $u->name }}" 
                                        class="w-10 h-10 rounded-full object-cover border-2 border-[#2D5A27]/20 shadow-2xs"
                                    />
                                    <div>
                                        <span class="block font-bold text-gray-900 text-sm">{{ $u->name }}</span>
                                        <span class="block text-gray-500 font-light text-xs">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->isPenjual())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-purple-100 text-purple-800 border border-purple-200">
                                        <svg class="w-3.5 h-3.5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span>Penjual / Admin</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-[#2D5A27]/10 text-[#2D5A27] border border-[#2D5A27]/20">
                                        <svg class="w-3.5 h-3.5 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <span>Pelanggan</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Phone -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->no_telp)
                                    <span class="font-mono text-gray-800">{{ $u->no_telp }}</span>
                                @else
                                    <span class="text-gray-400 italic">Belum diisi</span>
                                @endif
                            </td>

                            <!-- Auth Provider -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->google_id)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-white text-stone-700 border border-stone-300 shadow-2xs">
                                        <svg style="width: 12px; height: 12px;" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                                        </svg>
                                        <span>Google OAuth</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-stone-100 text-stone-600 border border-stone-200">
                                        <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Email Manual</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Verification Status (Hidden) -->
                            <td class="hidden px-6 py-4 whitespace-nowrap">
                                @if($u->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-semibold">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-amber-600 font-medium">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Belum Verifikasi
                                    </span>
                                @endif
                            </td>

                            <!-- Registered Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $u->created_at ? $u->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>

                            <!-- Action Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if(auth()->id() !== $u->id)
                                    <button 
                                        type="button" 
                                        onclick="confirmDeleteUser({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}')"
                                        class="px-3 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-semibold transition-colors cursor-pointer inline-flex items-center justify-center gap-1.5"
                                    >
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                @else
                                    <span class="text-xs text-stone-400 font-light italic">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="space-y-2 flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <p class="font-medium text-gray-500">Tidak ada data pengguna yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($users->hasPages())
            <div class="px-6 py-4 bg-[#F8F8F2] border-t border-[#E5E5DC]">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- DELETE USER CONFIRMATION MODAL -->
<div id="deleteUserModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-xs transition-opacity" onclick="closeDeleteUserModal()"></div>

    <!-- Modal Content Card -->
    <div class="relative bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-[#E5E5DC] z-10 space-y-6 transform transition-all scale-100">
        
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-serif font-bold text-gray-900">Konfirmasi Hapus Pengguna</h3>
                <p class="text-xs text-gray-500 font-light mt-1">
                    Tindakan ini permanen dan tidak dapat dibatalkan.
                </p>
            </div>
        </div>

        <div class="p-4 bg-rose-50/70 border border-rose-100 rounded-2xl text-xs text-rose-900 space-y-1">
            <span class="block font-medium text-gray-600">Pengguna yang akan dihapus:</span>
            <span id="deleteModalUserName" class="block font-bold text-sm text-gray-900"></span>
            <span id="deleteModalUserEmail" class="block font-mono text-stone-500 text-[11px]"></span>
        </div>

        <!-- Form action will be updated dynamically via JS -->
        <form id="deleteUserForm" action="" method="POST" class="flex items-center gap-3 pt-2">
            @csrf
            @method('DELETE')

            <button 
                type="button" 
                onclick="closeDeleteUserModal()"
                class="flex-1 py-3 px-4 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold rounded-xl transition-all cursor-pointer text-center"
            >
                Batal
            </button>

            <button 
                type="submit" 
                class="flex-1 py-3 px-4 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer text-center"
            >
                Ya, Hapus Pengguna
            </button>
        </form>
    </div>
</div>

<script>
    function confirmDeleteUser(userId, userName, userEmail) {
        const modal = document.getElementById('deleteUserModal');
        const form = document.getElementById('deleteUserForm');
        const nameEl = document.getElementById('deleteModalUserName');
        const emailEl = document.getElementById('deleteModalUserEmail');

        if (form && modal && nameEl && emailEl) {
            form.action = '/penjual/users/' + userId;
            nameEl.textContent = userName;
            emailEl.textContent = userEmail;
            modal.classList.remove('hidden');
        }
    }

    function closeDeleteUserModal() {
        const modal = document.getElementById('deleteUserModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
