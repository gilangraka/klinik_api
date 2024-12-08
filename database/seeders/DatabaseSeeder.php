<?php

namespace Database\Seeders;

use App\Models\RefJenisLayanan;
use App\Models\RefLayanan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $jenis_layanan = [
            'Pijat',
            'Terapi'
        ];

        $layanan = [
            [
                'nama' => 'Pijat 1',
                'jenis_layanan_id' => 1, // ID ini akan diambil setelah jenis_layanan disimpan
                'deskripsi' => 'Layanan Klinik',
                'biaya' => 500
            ],
            [
                'nama' => 'Terapi 1',
                'jenis_layanan_id' => 2, // ID ini akan diambil setelah jenis_layanan disimpan
                'deskripsi' => 'Layanan Klinik',
                'biaya' => 500
            ]
        ];

        // Menyimpan data jenis layanan terlebih dahulu
        foreach ($jenis_layanan as $value) {
            RefJenisLayanan::create(['nama' => $value]);
        }

        // Menyimpan data layanan dengan mengacu pada jenis layanan yang telah disimpan
        foreach ($layanan as $value) {
            // Mencari ID jenis layanan berdasarkan nama yang sudah disimpan
            $jenisLayanan = RefJenisLayanan::where('nama', $value['jenis_layanan_id'])->first();

            // Mengaitkan dengan ID jenis layanan yang benar
            RefLayanan::create([
                'nama' => $value['nama'],
                'jenis_layanan_id' => $jenisLayanan->id,
                'deskripsi' => $value['deskripsi'],
                'biaya' => $value['biaya']
            ]);
        }
    }
}
