<?php

namespace App\Services;

use App\Exceptions\KapasitasTerlampauiException;
use App\Models\CapacitySetting;
use App\Models\Paket;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananService
{

    public function store(User $user, array $data): Pesanan
    {
        $this->pastikanKapasitasCukup($data['tgl_acara'], $data['jumlah_pax']);

        return DB::transaction(function () use ($user, $data) {
            $pesanan = Pesanan::create([
                'user_id' => $user->id,
                'gubukan_id' => $data['gubukan_id'] ?? null,
                'tgl_pesan' => now()->toDateString(),
                'tgl_acara' => $data['tgl_acara'],
                'jumlah_pax' => $data['jumlah_pax'],
                'status_pesanan' => 'menunggu_validasi',
                'status_produksi' => 'belum_diproses',
                'catatan' => $data['catatan'] ?? null,
                'total_harga' => 0, // dihitung ulang di bawah, setelah semua item tersimpan
            ]);

            $totalHarga = 0;

            foreach ($data['items'] as $item) {
                $paket = Paket::findOrFail($item['paket_id']);
                $laukIds = $item['lauk_ids'] ?? [];

                if (count($laukIds) !== $paket->jumlah_lauk_pilihan) {
                    throw ValidationException::withMessages([
                        'items' => "Paket \"{$paket->nm_paket}\" harus memilih tepat {$paket->jumlah_lauk_pilihan} lauk.",
                    ]);
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

            if ($pesanan->gubukan_id) {
                $totalHarga += $pesanan->gubukan->harga_gubukan;
            }

            $pesanan->update(['total_harga' => $totalHarga]);

            return $pesanan->fresh(['pesananPaket.paket', 'pesananPaket.lauks.lauk', 'gubukan']);
        });
    }

    protected function pastikanKapasitasCukup(string $tglAcara, int $jumlahPaxBaru): void
    {
        $totalPaxTerpakai = Pesanan::whereDate('tgl_acara', $tglAcara)
            ->whereIn('status_pesanan', ['menunggu_validasi', 'disetujui'])
            ->sum('jumlah_pax');

        $kapasitasMaks = CapacitySetting::whereDate('tanggal', $tglAcara)->value('kapasitas_maks_pax')
            ?? CapacitySetting::whereNull('tanggal')->value('kapasitas_maks_pax');

        if ($kapasitasMaks === null) {
            return;
        }

        $sisaKapasitas = $kapasitasMaks - $totalPaxTerpakai;

        if ($jumlahPaxBaru > $sisaKapasitas) {
            throw new KapasitasTerlampauiException(max($sisaKapasitas, 0));
        }
    }
}