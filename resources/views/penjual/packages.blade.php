@extends('layouts.admin')

@section('title', 'Kelola Paket & Lauk - Manajemen RASACI Dapur')

@section('content')
<!-- TOP HEADER BAR & ACTION BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight">Kelola Paket & Lauk</h1>
        <p class="text-xs text-gray-500 font-light mt-1">Konfigurasi dan kelola menu catering serta variasi lauk pauk Anda.</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
        <button type="button" onclick="openCreatePaketModal()" class="bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3 px-5 rounded-xl shadow-md text-xs flex items-center gap-2 transition-all cursor-pointer">
            <span>+</span>
            <span>Tambah Paket Baru</span>
        </button>
        <button type="button" onclick="openCreateLaukModal()" class="bg-[#3B420C] hover:bg-black text-white font-bold py-3 px-5 rounded-xl shadow-md text-xs flex items-center gap-2 transition-all cursor-pointer">
            <span>+</span>
            <span>Tambah Lauk Baru</span>
        </button>
        <button type="button" onclick="openCreateGubukanModal()" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-5 rounded-xl shadow-md text-xs flex items-center gap-2 transition-all cursor-pointer">
            <span>+</span>
            <span>Tambah Gubukan Baru</span>
        </button>
    </div>
</div>

<!-- 4 METRIC SUMMARY CARDS GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Card 1: TOTAL PACKAGES -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PAKET</span>
        <div class="text-3xl font-bold font-serif text-gray-900">
            {{ $totalPaketsCount > 0 ? $totalPaketsCount : 24 }}
        </div>
    </div>

    <!-- Card 2: ACTIVE -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">AKTIF</span>
        <div class="text-3xl font-bold font-serif text-[#2D5A27]">
            {{ $activePaketsCount > 0 ? $activePaketsCount : 18 }}
        </div>
    </div>

    <!-- Card 3: OUT OF STOCK -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">STOK HABIS</span>
        <div class="text-3xl font-bold font-serif text-amber-600">
            {{ $outOfStockCount }}
        </div>
    </div>

    <!-- Card 4: DRAFTS / INACTIVE -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">DRAF</span>
        <div class="text-3xl font-bold font-serif text-gray-500">
            {{ $inactivePaketsCount > 0 ? $inactivePaketsCount : 3 }}
        </div>
    </div>
</div>

<!-- MAIN MANAGEMENT CONTAINER WITH SEARCH & TABS -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <!-- SEARCH & FILTER BAR -->
    <div class="bg-[#F8F9F3] p-3 rounded-2xl border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-3">
        <!-- Search Input -->
        <div class="relative flex-1 w-full">
            <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 text-sm">🔍</span>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama paket atau kategori..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:border-[#2D5A27] shadow-2xs">
        </div>

        <!-- Category Dropdown & Tab Toggle -->
        <div class="flex items-center gap-3 w-full md:w-auto">
            <select id="categoryFilter" onchange="filterTable()" class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 focus:outline-none cursor-pointer">
                <option value="Prasmanan">Prasmanan</option>
                <option value="Nasi Kotak">Nasi Kotak</option>
                <option value="Tumpeng">Tumpeng</option>
                <option value="Gubukan">Gubukan</option>
                <option value="Lauk">Lauk Pauk</option>
            </select>

            <!-- Tab Buttons -->
            <div class="bg-gray-200/70 p-1 rounded-xl flex gap-1 text-xs">
                <button type="button" id="tabPaketBtn" onclick="switchTab('paket')" class="px-4 py-2 rounded-lg font-bold transition-all bg-[#2D5A27] text-white shadow-xs cursor-pointer">
                    Paket Catering
                </button>
                <button type="button" id="tabLaukBtn" onclick="switchTab('lauk')" class="px-4 py-2 rounded-lg font-bold transition-all text-gray-600 hover:text-gray-900 cursor-pointer">
                    Lauk Pauk
                </button>
                <button type="button" id="tabGubukanBtn" onclick="switchTab('gubukan')" class="px-4 py-2 rounded-lg font-bold transition-all text-gray-600 hover:text-gray-900 cursor-pointer">
                    Gubukan / Pondokan
                </button>
            </div>
        </div>
    </div>

    <!-- CATERING PACKAGES TABLE -->
    <!-- CATERING PACKAGES TABLE -->
    <div id="paketTableContainer" class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">GAMBAR</th>
                    <th class="py-3 px-4">NAMA PAKET</th>
                    <th class="py-3 px-4">KATEGORI</th>
                    <th class="py-3 px-4">HARGA</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">AKSI</th>
                </tr>
            </thead>
            <tbody id="paketTableBody" class="divide-y divide-gray-100 font-medium">
                @forelse($pakets as $index => $paket)
                    @php
                        $sku = 'NS-' . str_pad($paket->id, 3, '0', STR_PAD_LEFT);
                        $priceUnit = ' / pax';

                        if(str_contains(strtolower($paket->nm_paket), 'bento') || str_contains(strtolower($paket->nm_paket), 'box') || str_contains(strtolower($paket->nm_paket), 'kotak')) {
                            $catName = 'Nasi Kotak';
                            $catBg = 'bg-amber-100 text-amber-800';
                            $priceUnit = ' / box';
                            $imgUrl = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
                        } elseif(str_contains(strtolower($paket->nm_paket), 'gala') || str_contains(strtolower($paket->nm_paket), 'tumpeng')) {
                            $catName = 'Tumpeng';
                            $catBg = 'bg-emerald-100 text-emerald-800';
                            $imgUrl = 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=300';
                        } else {
                            $catName = 'Prasmanan';
                            $catBg = 'bg-[#FDF0ED] text-[#8A3017]';
                            $imgUrl = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors paket-row" data-name="{{ strtolower($paket->nm_paket) }}" data-cat="{{ strtolower($catName) }}">
                        <!-- Image -->
                        <td class="py-4 px-4">
                            <img src="{{ $imgUrl }}" alt="{{ $paket->nm_paket }}" class="w-14 h-10 rounded-xl object-cover border border-gray-200">
                        </td>

                        <!-- Name -->
                        <td class="py-4 px-4">
                            <div>
                                <span class="font-bold text-gray-900 block text-xs">{{ $paket->nm_paket }}</span>
                                <span class="text-[10px] font-mono text-gray-400">SKU: {{ $sku }}</span>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold inline-block {{ $catBg }}">
                                {{ $catName }}
                            </span>
                        </td>

                        <!-- Price -->
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}<span class="text-xs font-sans font-light text-gray-500">{{ $priceUnit }}</span>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4">
                            @if($paket->status_aktif)
                                <span class="flex items-center gap-1.5 text-green-600 font-bold text-xs">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-gray-400 font-medium text-xs">
                                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                    <span>Tidak Aktif</span>
                                </span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-base">
                                <button type="button" onclick="openEditPaketModal({{ json_encode($paket) }})" class="text-gray-400 hover:text-[#2D5A27] transition-colors cursor-pointer" title="Edit Paket">
                                    ✏️
                                </button>
                                <button type="button" onclick="deletePaket({{ $paket->id }})" class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer" title="Hapus Paket">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 font-light">
                            Belum ada paket catering. Klik tombol **+ Tambah Paket Baru** untuk membuat paket.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- LAUK PAUK TABLE (Hidden by default, shown on tab click) -->
    <div id="laukTableContainer" class="overflow-x-auto hidden">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">GAMBAR</th>
                    <th class="py-3 px-4">NAMA LAUK</th>
                    <th class="py-3 px-4">KETERANGAN</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">AKSI</th>
                </tr>
            </thead>
            <tbody id="laukTableBody" class="divide-y divide-gray-100 font-medium">
                @forelse($lauks as $lauk)
                    <tr class="hover:bg-gray-50 transition-colors lauk-row" data-name="{{ strtolower($lauk->nama_lauk) }}">
                        <td class="py-4 px-4">
                            <div class="w-12 h-12 rounded-xl bg-[#EAEFE2] text-[#2D5A27] font-bold flex items-center justify-center text-lg border border-gray-200">
                                🍗
                            </div>
                        </td>
                        <td class="py-4 px-4 font-bold text-gray-900">
                            {{ $lauk->nama_lauk }}
                        </td>
                        <td class="py-4 px-4 text-gray-500 font-light">
                            {{ $lauk->keterangan ?? 'Lauk autentik pilihan dapur RASACI' }}
                        </td>
                        <td class="py-4 px-4">
                            @if($lauk->status_aktif)
                                <span class="flex items-center gap-1.5 text-green-600 font-bold text-xs">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-gray-400 font-medium text-xs">
                                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                    <span>Tidak Aktif</span>
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-base">
                                <button type="button" onclick="openEditLaukModal({{ json_encode($lauk) }})" class="text-gray-400 hover:text-[#2D5A27] transition-colors cursor-pointer" title="Edit Lauk">
                                    ✏️
                                </button>
                                <button type="button" onclick="deleteLauk({{ $lauk->id }})" class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer" title="Hapus Lauk">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 font-light">
                            Belum ada pilihan lauk pauk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- GUBUKAN TABLE (Hidden by default, shown on tab click) -->
    <div id="gubukanTableContainer" class="overflow-x-auto hidden">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">GAMBAR</th>
                    <th class="py-3 px-4">NAMA GUBUKAN</th>
                    <th class="py-3 px-4">HARGA SEWA</th>
                    <th class="py-3 px-4">KAPASITAS</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">AKSI</th>
                </tr>
            </thead>
            <tbody id="gubukanTableBody" class="divide-y divide-gray-100 font-medium">
                @forelse($gubukans as $gubukan)
                    <tr class="hover:bg-gray-50 transition-colors gubukan-row" data-name="{{ strtolower($gubukan->nama_gubukan) }}">
                        <td class="py-4 px-4">
                            <div class="w-12 h-12 rounded-xl bg-[#EAEFE2] text-[#2D5A27] font-bold flex items-center justify-center text-lg border border-gray-200">
                                🛖
                            </div>
                        </td>
                        <td class="py-4 px-4 font-bold text-gray-900">
                            {{ $gubukan->nama_gubukan }}
                        </td>
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">
                            Rp {{ number_format($gubukan->harga_gubukan, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 text-gray-500 font-light">
                            {{ $gubukan->kapasitas_orang }} Orang
                        </td>
                        <td class="py-4 px-4">
                            @if($gubukan->status_aktif)
                                <span class="flex items-center gap-1.5 text-green-600 font-bold text-xs">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-gray-400 font-medium text-xs">
                                    <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                    <span>Tidak Aktif</span>
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-base">
                                <button type="button" onclick="openEditGubukanModal({{ json_encode($gubukan) }})" class="text-gray-400 hover:text-[#2D5A27] transition-colors cursor-pointer" title="Edit Gubukan">
                                    ✏️
                                </button>
                                <button type="button" onclick="deleteGubukan({{ $gubukan->id }})" class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer" title="Hapus Gubukan">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 font-light">
                            Belum ada pilihan pondokan/gubukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION FOOTER -->
    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 font-medium">
        <div>
            Menampilkan 1-{{ count($pakets) }} dari {{ $totalPaketsCount }} paket | © 2024 RASACI
        </div>
        <div class="flex items-center gap-1">
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-400 hover:bg-gray-50 flex items-center justify-center font-bold">‹</button>
            <button type="button" class="w-8 h-8 rounded-xl bg-[#2D5A27] text-white flex items-center justify-center font-bold shadow-xs">1</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">2</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">3</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">›</button>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- CREATE / EDIT PAKET MODAL -->
<div id="paketModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <h3 id="paketModalTitle" class="text-xl font-bold font-serif text-gray-900">Tambah Paket Baru</h3>
            <button onclick="closePaketModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="paketForm" onsubmit="savePaket(event)" class="space-y-4 text-xs">
            <input type="hidden" id="paketId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Nama Paket</label>
                <input type="text" id="nm_paket" required placeholder="misal: Prasmanan Nusantara Premium A" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="font-bold text-gray-700 block">Harga Paket (Rp)</label>
                    <input type="number" id="harga_paket" required placeholder="125000" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
                </div>
                <div class="space-y-1.5">
                    <label class="font-bold text-gray-700 block">Jml Lauk Pilihan</label>
                    <input type="number" id="jumlah_lauk_pilihan" required value="5" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Deskripsi Paket</label>
                <textarea id="deskripsi" rows="3" placeholder="Tuliskan porsi, keunggulan, dan isi sajian..." class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="status_aktif_paket" checked class="w-4 h-4 text-[#2D5A27] rounded-md border-gray-300 focus:ring-0">
                <label for="status_aktif_paket" class="font-bold text-gray-700">Aktifkan Paket (Bisa dipesan pelanggan)</label>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="submitPaketBtn" class="flex-1 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Paket
                </button>
                <button type="button" onclick="closePaketModal()" class="px-4 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CREATE / EDIT LAUK MODAL -->
<div id="laukModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <h3 id="laukModalTitle" class="text-xl font-bold font-serif text-gray-900">Tambah Lauk Baru</h3>
            <button onclick="closeLaukModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="laukForm" onsubmit="saveLauk(event)" class="space-y-4 text-xs">
            <input type="hidden" id="laukId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Nama Lauk Pauk</label>
                <input type="text" id="nama_lauk" required placeholder="misal: Rendang Daging Sapi" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Keterangan / Deskripsi Singkat</label>
                <input type="text" id="keterangan_lauk" placeholder="Olahan daging sapi olahan rempah khas Minang" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="status_aktif_lauk" checked class="w-4 h-4 text-[#2D5A27] rounded-md border-gray-300 focus:ring-0">
                <label for="status_aktif_lauk" class="font-bold text-gray-700">Aktifkan Lauk ini</label>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="submitLaukBtn" class="flex-1 bg-[#3B420C] hover:bg-black text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Lauk
                </button>
                <button type="button" onclick="closeLaukModal()" class="px-4 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CREATE / EDIT GUBUKAN MODAL -->
<div id="gubukanModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <h3 id="gubukanModalTitle" class="text-xl font-bold font-serif text-gray-900">Tambah Gubukan Baru</h3>
            <button onclick="closeGubukanModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="gubukanForm" onsubmit="saveGubukan(event)" class="space-y-4 text-xs">
            <input type="hidden" id="gubukanId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Nama Gubukan / Pondokan</label>
                <input type="text" id="nama_gubukan" required placeholder="misal: Gubukan Kambing Guling" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="font-bold text-gray-700 block">Harga Sewa (Rp)</label>
                    <input type="number" id="harga_gubukan" required placeholder="250000" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
                </div>
                <div class="space-y-1.5">
                    <label class="font-bold text-gray-700 block">Kapasitas Orang</label>
                    <input type="number" id="kapasitas_orang" required placeholder="50" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium focus:bg-white focus:outline-none focus:border-[#2D5A27]">
                </div>
            </div>

            <div class="flex items-center gap-2 pt-2">
                <input type="checkbox" id="status_aktif_gubukan" checked class="w-4 h-4 text-[#2D5A27] rounded-md border-gray-300 focus:ring-0">
                <label for="status_aktif_gubukan" class="font-bold text-gray-700">Aktifkan Gubukan ini</label>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="submitGubukanBtn" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Gubukan
                </button>
                <button type="button" onclick="closeGubukanModal()" class="px-4 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeTab = 'paket';

    function switchTab(tab) {
        activeTab = tab;
        const paketContainer = document.getElementById('paketTableContainer');
        const laukContainer = document.getElementById('laukTableContainer');
        const gubukanContainer = document.getElementById('gubukanTableContainer');
        
        const tabPaketBtn = document.getElementById('tabPaketBtn');
        const tabLaukBtn = document.getElementById('tabLaukBtn');
        const tabGubukanBtn = document.getElementById('tabGubukanBtn');

        paketContainer.classList.add('hidden');
        laukContainer.classList.add('hidden');
        if (gubukanContainer) gubukanContainer.classList.add('hidden');

        tabPaketBtn.className = "px-4 py-2 rounded-lg font-bold transition-all text-gray-600 hover:text-gray-900 cursor-pointer";
        tabLaukBtn.className = "px-4 py-2 rounded-lg font-bold transition-all text-gray-600 hover:text-gray-900 cursor-pointer";
        if (tabGubukanBtn) tabGubukanBtn.className = "px-4 py-2 rounded-lg font-bold transition-all text-gray-600 hover:text-gray-900 cursor-pointer";

        if (tab === 'paket') {
            paketContainer.classList.remove('hidden');
            tabPaketBtn.className = "px-4 py-2 rounded-lg font-bold transition-all bg-[#2D5A27] text-white shadow-xs cursor-pointer";
        } else if (tab === 'lauk') {
            laukContainer.classList.remove('hidden');
            tabLaukBtn.className = "px-4 py-2 rounded-lg font-bold transition-all bg-[#3B420C] text-white shadow-xs cursor-pointer";
        } else if (tab === 'gubukan') {
            if (gubukanContainer) gubukanContainer.classList.remove('hidden');
            if (tabGubukanBtn) tabGubukanBtn.className = "px-4 py-2 rounded-lg font-bold transition-all bg-amber-600 text-white shadow-xs cursor-pointer";
        }
    }

    function filterTable() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const catFilter = document.getElementById('categoryFilter').value.toLowerCase();

        if (catFilter === 'gubukan') {
            switchTab('gubukan');
        } else if (catFilter === 'lauk') {
            switchTab('lauk');
        } else {
            switchTab('paket');
        }

        const paketRows = document.querySelectorAll('.paket-row');
        paketRows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const cat = row.getAttribute('data-cat') || '';
            const matchName = name.includes(query);
            let matchCat = false;
            if (catFilter === 'nasi kotak') {
                matchCat = cat.includes('nasi kotak') || cat.includes('bento') || cat.includes('box');
            } else {
                matchCat = cat.includes(catFilter);
            }
            row.style.display = (matchName && matchCat) ? '' : 'none';
        });

        const laukRows = document.querySelectorAll('.lauk-row');
        laukRows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            row.style.display = name.includes(query) ? '' : 'none';
        });

        const gubukanRows = document.querySelectorAll('.gubukan-row');
        gubukanRows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            row.style.display = name.includes(query) ? '' : 'none';
        });
    }

    // PAKET MODAL ACTIONS
    function openCreatePaketModal() {
        document.getElementById('paketId').value = '';
        document.getElementById('paketModalTitle').innerText = 'Tambah Paket Baru';
        document.getElementById('nm_paket').value = '';
        document.getElementById('harga_paket').value = '';
        document.getElementById('jumlah_lauk_pilihan').value = '5';
        document.getElementById('deskripsi').value = '';
        document.getElementById('status_aktif_paket').checked = true;
        document.getElementById('paketModal').classList.remove('hidden');
    }

    function openEditPaketModal(paket) {
        document.getElementById('paketId').value = paket.id;
        document.getElementById('paketModalTitle').innerText = 'Edit Paket Catering';
        document.getElementById('nm_paket').value = paket.nm_paket;
        document.getElementById('harga_paket').value = paket.harga_paket;
        document.getElementById('jumlah_lauk_pilihan').value = paket.jumlah_lauk_pilihan || 5;
        document.getElementById('deskripsi').value = paket.deskripsi || '';
        document.getElementById('status_aktif_paket').checked = paket.status_aktif == 1;
        document.getElementById('paketModal').classList.remove('hidden');
    }

    function closePaketModal() {
        document.getElementById('paketModal').classList.add('hidden');
    }

    async function savePaket(e) {
        e.preventDefault();
        const paketId = document.getElementById('paketId').value;
        const payload = {
            nm_paket: document.getElementById('nm_paket').value,
            harga_paket: document.getElementById('harga_paket').value,
            jumlah_lauk_pilihan: document.getElementById('jumlah_lauk_pilihan').value,
            deskripsi: document.getElementById('deskripsi').value,
            status_aktif: document.getElementById('status_aktif_paket').checked ? 1 : 0
        };

        const url = paketId ? `/api/penjual/pakets/${paketId}` : '/api/penjual/pakets';
        const method = paketId ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                window.location.reload();
            } else {
                const errData = await res.json();
                alert(errData.message || 'Gagal menyimpan paket.');
            }
        } catch(err) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    async function deletePaket(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus paket ini?')) return;
        try {
            const res = await fetch(`/api/penjual/pakets/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const data = await res.json();
            if (res.ok) {
                window.location.reload();
            } else {
                alert(data.message || 'Paket tidak dapat dihapus.');
            }
        } catch(err) {
            alert('Gagal menghapus paket.');
        }
    }

    // LAUK MODAL ACTIONS
    function openCreateLaukModal() {
        document.getElementById('laukId').value = '';
        document.getElementById('laukModalTitle').innerText = 'Tambah Lauk Baru';
        document.getElementById('nama_lauk').value = '';
        document.getElementById('keterangan_lauk').value = '';
        document.getElementById('status_aktif_lauk').checked = true;
        document.getElementById('laukModal').classList.remove('hidden');
    }

    function openEditLaukModal(lauk) {
        document.getElementById('laukId').value = lauk.id;
        document.getElementById('laukModalTitle').innerText = 'Edit Lauk Pauk';
        document.getElementById('nama_lauk').value = lauk.nama_lauk;
        document.getElementById('keterangan_lauk').value = lauk.keterangan || '';
        document.getElementById('status_aktif_lauk').checked = lauk.status_aktif == 1;
        document.getElementById('laukModal').classList.remove('hidden');
    }

    function closeLaukModal() {
        document.getElementById('laukModal').classList.add('hidden');
    }

    async function saveLauk(e) {
        e.preventDefault();
        const laukId = document.getElementById('laukId').value;
        const payload = {
            nama_lauk: document.getElementById('nama_lauk').value,
            keterangan: document.getElementById('keterangan_lauk').value,
            status_aktif: document.getElementById('status_aktif_lauk').checked ? 1 : 0
        };

        const url = laukId ? `/api/penjual/lauks/${laukId}` : '/api/penjual/lauks';
        const method = laukId ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                window.location.reload();
            } else {
                const errData = await res.json();
                alert(errData.message || 'Gagal menyimpan lauk.');
            }
        } catch(err) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    async function deleteLauk(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus lauk ini?')) return;
        try {
            const res = await fetch(`/api/penjual/lauks/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const data = await res.json();
            if (res.ok) {
                window.location.reload();
            } else {
                alert(data.message || 'Lauk tidak dapat dihapus.');
            }
        } catch(err) {
            alert('Gagal menghapus lauk.');
        }
    }

    // GUBUKAN MODAL ACTIONS
    function openCreateGubukanModal() {
        document.getElementById('gubukanId').value = '';
        document.getElementById('gubukanModalTitle').innerText = 'Tambah Gubukan Baru';
        document.getElementById('nama_gubukan').value = '';
        document.getElementById('harga_gubukan').value = '';
        document.getElementById('kapasitas_orang').value = '';
        document.getElementById('status_aktif_gubukan').checked = true;
        document.getElementById('gubukanModal').classList.remove('hidden');
    }

    function openEditGubukanModal(gubukan) {
        document.getElementById('gubukanId').value = gubukan.id;
        document.getElementById('gubukanModalTitle').innerText = 'Edit Gubukan / Pondokan';
        document.getElementById('nama_gubukan').value = gubukan.nama_gubukan;
        document.getElementById('harga_gubukan').value = Math.round(gubukan.harga_gubukan);
        document.getElementById('kapasitas_orang').value = gubukan.kapasitas_orang;
        document.getElementById('status_aktif_gubukan').checked = gubukan.status_aktif == 1;
        document.getElementById('gubukanModal').classList.remove('hidden');
    }

    function closeGubukanModal() {
        document.getElementById('gubukanModal').classList.add('hidden');
    }

    async function saveGubukan(e) {
        e.preventDefault();
        const gubukanId = document.getElementById('gubukanId').value;
        const payload = {
            nama_gubukan: document.getElementById('nama_gubukan').value,
            harga_gubukan: Number(document.getElementById('harga_gubukan').value),
            kapasitas_orang: Number(document.getElementById('kapasitas_orang').value),
            status_aktif: document.getElementById('status_aktif_gubukan').checked ? 1 : 0
        };

        const url = gubukanId ? `/api/penjual/gubukans/${gubukanId}` : '/api/penjual/gubukans';
        const method = gubukanId ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                window.location.reload();
            } else {
                const errData = await res.json();
                alert(errData.message || 'Gagal menyimpan gubukan.');
            }
        } catch(err) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    async function deleteGubukan(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus gubukan ini?')) return;
        try {
            const res = await fetch(`/api/penjual/gubukans/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            const data = await res.json();
            if (res.ok) {
                window.location.reload();
            } else {
                alert(data.message || 'Gubukan tidak dapat dihapus.');
            }
        } catch(err) {
            alert('Gagal menghapus gubukan.');
        }
    }
</script>
@endsection
