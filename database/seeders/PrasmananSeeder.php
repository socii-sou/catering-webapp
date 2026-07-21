<?php

namespace Database\Seeders;

use App\Models\KategoriLauk;
use App\Models\KategoriProduk;
use App\Models\Lauk;
use App\Models\Paket;
use App\Models\PaketKategoriKuota;
use Illuminate\Database\Seeder;

class PrasmananSeeder extends Seeder
{
    /**
     * Contoh: 1 kategori produk (Prasmanan) berisi 2 sub-paket (Standar & Premium),
     * keduanya berbagi 3 kategori lauk yang sama (Aneka Ayam/Daging/Sayur),
     * tapi kuota pilihannya beda-beda per paket.
     */
    public function run(): void
    {
        // 1. Kategori produk
        $kategoriProduk = KategoriProduk::firstOrCreate(
            ['slug' => 'prasmanan'],
            ['nama_kategori' => 'Prasmanan', 'mendukung_gubukan' => true]
        );

        // 2. Kategori lauk (dipakai bersama oleh semua paket Prasmanan)
        $kategoriAyam = KategoriLauk::firstOrCreate(['nama_kategori' => 'Aneka Ayam']);
        $kategoriDaging = KategoriLauk::firstOrCreate(['nama_kategori' => 'Aneka Daging']);
        $kategoriSayur = KategoriLauk::firstOrCreate(['nama_kategori' => 'Aneka Sayur']);

        // 3. Data lauk per kategori
        collect(['Ayam Goreng', 'Ayam Bakar', 'Sate Ayam', 'Ayam Woku'])
            ->each(fn ($nama) => Lauk::firstOrCreate(
                ['nama_lauk' => $nama],
                ['kategori_lauk_id' => $kategoriAyam->id, 'status_aktif' => true]
            ));

        collect(['Rendang Sapi', 'Empal Gepuk', 'Semur Daging', 'Dendeng Balado'])
            ->each(fn ($nama) => Lauk::firstOrCreate(
                ['nama_lauk' => $nama],
                ['kategori_lauk_id' => $kategoriDaging->id, 'status_aktif' => true]
            ));

        collect(['Tumis Buncis', 'Capcay', 'Urap Sayur', 'Sayur Lodeh'])
            ->each(fn ($nama) => Lauk::firstOrCreate(
                ['nama_lauk' => $nama],
                ['kategori_lauk_id' => $kategoriSayur->id, 'status_aktif' => true]
            ));

        // 4. Sub-paket "Standar" -- kuota lebih kecil, harga lebih murah
        $paketStandar = Paket::firstOrCreate(
            ['nm_paket' => 'Prasmanan Standar'],
            [
                'kategori_produk_id' => $kategoriProduk->id,
                'harga_paket' => 50000,
                'jumlah_lauk_pilihan' => 3, // info tampilan, validasi asli dari kuota di bawah
                'deskripsi' => 'Pilihan ideal untuk gathering kantor dengan menu standar lengkap.',
                'status_aktif' => true,
            ]
        );

        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketStandar->id, 'kategori_lauk_id' => $kategoriAyam->id],
            ['jumlah_pilihan' => 1]
        );
        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketStandar->id, 'kategori_lauk_id' => $kategoriDaging->id],
            ['jumlah_pilihan' => 1]
        );
        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketStandar->id, 'kategori_lauk_id' => $kategoriSayur->id],
            ['jumlah_pilihan' => 1]
        );

        // 5. Sub-paket "Premium" -- kuota lebih besar, harga lebih mahal
        $paketPremium = Paket::firstOrCreate(
            ['nm_paket' => 'Prasmanan Premium'],
            [
                'kategori_produk_id' => $kategoriProduk->id,
                'harga_paket' => 85000,
                'jumlah_lauk_pilihan' => 5,
                'deskripsi' => 'Pilihan lengkap untuk perhelatan besar seperti pernikahan atau gathering tahunan.',
                'status_aktif' => true,
            ]
        );

        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketPremium->id, 'kategori_lauk_id' => $kategoriAyam->id],
            ['jumlah_pilihan' => 2]
        );
        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketPremium->id, 'kategori_lauk_id' => $kategoriDaging->id],
            ['jumlah_pilihan' => 2]
        );
        PaketKategoriKuota::firstOrCreate(
            ['paket_id' => $paketPremium->id, 'kategori_lauk_id' => $kategoriSayur->id],
            ['jumlah_pilihan' => 1]
        );
    }
}