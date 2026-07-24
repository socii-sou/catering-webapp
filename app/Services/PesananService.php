<?php

namespace App\Services;

use App\Exceptions\KapasitasTerlampauiException;
use App\Models\CapacitySetting;
use App\Models\Lauk;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananService
{
    /**
     * Membuat pesanan baru beserta detail paket & lauk yang dipilih.
     *
     * Format $data:
     * [
     *   'nama_acara'  => string,
     *   'tipe_acara'  => ?string,
     *   'alamat_pengiriman' => string,
     *   'gubukan_id'  => ?int,
     *   'tgl_acara'   => 'Y-m-d',
     *   'jumlah_pax'  => int,
     *   'catatan'     => ?string,
     *   'items' => [
     *       ['paket_id' => int, 'jml_paket' => int, 'lauk_ids' => [int, ...]],
     *       ...
     *   ],
     * ]
     */
    public function store(User $user, array $data): Pesanan
    {
        $this->pastikanKapasitasCukup($data['tgl_acara'], $data['jumlah_pax']);

        return DB::transaction(function () use ($user, $data) {
            $gubukanId = is_array($data['gubukan_id'] ?? null) 
                ? ($data['gubukan_id'][0] ?? null) 
                : ($data['gubukan_id'] ?? (is_array($data['gubukan_ids'] ?? null) ? ($data['gubukan_ids'][0] ?? null) : null));
            $jumlahPaxGubukan = $gubukanId ? max(100, (int) ($data['jumlah_pax_gubukan'] ?? 100)) : null;

            $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'nama_acara' => $data['nama_acara'] ?? 'Acara Pelanggan',
                'tipe_acara' => $data['tipe_acara'] ?? null,
                'alamat_pengiriman' => $data['alamat_pengiriman'] ?? ($user->alamat ?? ''),
                'gubukan_id' => $gubukanId,
                'tgl_pesan' => now()->toDateString(),
                'tgl_acara' => $data['tgl_acara'],
                'jumlah_pax' => $data['jumlah_pax'],
                'jumlah_pax_gubukan' => $jumlahPaxGubukan,
                'status_pesanan' => 'menunggu_validasi',
                'status_produksi' => 'belum_diproses',
                'catatan' => $data['catatan'] ?? null,
                'biaya_pengiriman' => 0, // flat/gratis untuk MVP
                'total_harga' => 0, // dihitung ulang di bawah, setelah semua item tersimpan
            ]);

            $totalHarga = 0;
            $adaPaketPendukungGubukan = false;

            foreach ($data['items'] as $item) {
                $paket = Paket::with(['kategoriKuota', 'kategoriProduk'])->findOrFail($item['paket_id']);
                $laukIds = $item['lauk_ids'] ?? [];

                $this->validasiPilihanLauk($paket, $laukIds);

                if ($paket->kategoriProduk?->mendukung_gubukan || str_contains(strtolower($paket->nm_paket), 'prasmanan')) {
                    $adaPaketPendukungGubukan = true;
                }

                $pesananPaket = $pesanan->pesananPaket()->create([
                    'paket_id' => $paket->id,
                    'jml_paket' => $item['jml_paket'],
                ]);

                foreach ($laukIds as $laukId) {
                    $pesananPaket->lauks()->create(['lauk_id' => $laukId]);
                }

                $totalHarga += $paket->harga_paket * $item['jml_paket'];
            }

            if ($pesanan->gubukan_id && ! $adaPaketPendukungGubukan) {
                throw ValidationException::withMessages([
                    'gubukan_id' => 'Gubukan hanya bisa dipesan kalau pesanan ini berisi minimal 1 paket dari kategori yang mendukung gubukan (mis. Prasmanan).',
                ]);
            }

            if ($pesanan->gubukan_id) {
                $paxGub = $pesanan->jumlah_pax_gubukan ?? 100;
                $totalHarga += ($pesanan->gubukan->harga_gubukan * $paxGub);
            }

            $pesanan->update(['total_harga' => $totalHarga]);

            return $pesanan->fresh(['pesananPaket.paket', 'pesananPaket.lauks.lauk', 'gubukan']);
        });

        // Kirim Notifikasi Email ke Pelanggan
        try {
            if ($user->email) {
                \Illuminate\Support\Facades\Mail::to($user->email)
                    ->send(new \App\Mail\PesananDibuatMail($pesanan));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email notifikasi pesanan #' . $pesanan->id . ': ' . $e->getMessage());
        }

        return $pesanan;
    }

    /**
     * Validasi pilihan lauk untuk 1 paket, dengan 2 mode:
     *
     * 1. Paket punya baris di paket_kategori_kuota -> WAJIB pilih persis sejumlah
     *    kuota dari MASING-MASING kategori (mis. Prasmanan: 1 Aneka Ayam +
     *    1 Aneka Daging + 1 Aneka Sayur). Lauk di luar kategori yang diatur
     *    tidak boleh dipilih sama sekali untuk paket ini.
     *
     * 2. Paket tidak punya baris kuota kategori sama sekali -> fallback ke
     *    aturan lama: bebas pilih N lauk dari lauk manapun, N = jumlah_lauk_pilihan.
     */
    protected function validasiPilihanLauk(Paket $paket, array $laukIds): void
    {
        if ($paket->kategoriKuota->isEmpty()) {
            if (empty($laukIds)) {
                throw ValidationException::withMessages([
                    'items' => "Paket \"{$paket->nm_paket}\" minimal harus memilih 1 lauk.",
                ]);
            }

            $maxAllowed = str_contains(strtolower($paket->nm_paket), 'prasmanan') 
                ? max(5, $paket->jumlah_lauk_pilihan) 
                : $paket->jumlah_lauk_pilihan;

            if (count($laukIds) > $maxAllowed) {
                throw ValidationException::withMessages([
                    'items' => "Paket \"{$paket->nm_paket}\" maksimal hanya boleh memilih {$maxAllowed} lauk.",
                ]);
            }

            return;
        }

        $laukTerpilih = Lauk::whereIn('id', $laukIds)->get(['id', 'kategori_lauk_id']);
        $jumlahPerKategori = $laukTerpilih->groupBy('kategori_lauk_id')->map->count();

        foreach ($paket->kategoriKuota as $kuota) {
            $terpilih = $jumlahPerKategori->get($kuota->kategori_lauk_id, 0);

            if ($terpilih > $kuota->jumlah_pilihan) {
                $namaKategori = $kuota->kategoriLauk->nama_kategori ?? "kategori #{$kuota->kategori_lauk_id}";

                throw ValidationException::withMessages([
                    'items' => "Paket \"{$paket->nm_paket}\" maksimal hanya boleh memilih {$kuota->jumlah_pilihan} lauk dari kategori \"{$namaKategori}\" (saat ini dipilih {$terpilih}).",
                ]);
            }
        }

        // Pastikan tidak ada lauk "nyasar" dari kategori yang tidak diatur kuotanya.
        $kategoriDiizinkan = $paket->kategoriKuota->pluck('kategori_lauk_id');
        $adaLaukNyasar = $laukTerpilih->contains(fn ($lauk) => ! $kategoriDiizinkan->contains($lauk->kategori_lauk_id));

        if ($adaLaukNyasar) {
            throw ValidationException::withMessages([
                'items' => "Paket \"{$paket->nm_paket}\" hanya boleh berisi lauk dari kategori yang sudah ditentukan.",
            ]);
        }
    }

    /**
     * Validasi over kapasitas: total pax yang sudah ter-booking di tanggal
     * tersebut (status menunggu_validasi/disetujui) + pax pesanan baru,
     * tidak boleh melebihi kapasitas_maks_pax pada tanggal itu (atau default global).
     */
    protected function pastikanKapasitasCukup(string $tglAcara, int $jumlahPaxBaru): void
    {
        $totalPaxTerpakai = Pesanan::whereDate('tgl_acara', $tglAcara)
            ->whereIn('status_pesanan', ['menunggu_validasi', 'disetujui'])
            ->sum('jumlah_pax');

        $kapasitasMaks = CapacitySetting::whereDate('tanggal', $tglAcara)->value('kapasitas_maks_pax')
            ?? CapacitySetting::whereNull('tanggal')->value('kapasitas_maks_pax');

        // Belum ada pengaturan kapasitas sama sekali -> anggap tidak dibatasi.
        if ($kapasitasMaks === null) {
            return;
        }

        $sisaKapasitas = $kapasitasMaks - $totalPaxTerpakai;

        if ($jumlahPaxBaru > $sisaKapasitas) {
            throw new KapasitasTerlampauiException(max($sisaKapasitas, 0));
        }
    }
}