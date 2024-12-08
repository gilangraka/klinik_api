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
                'jenis_layanan_id' => 1,
                'deskripsi' => 'Layanan Klinik',
                'biaya' => 500
            ],
            [
                'nama' => 'Terapi 1',
                'jenis_layanan_id' => 2,
                'deskripsi' => 'Layanan Klinik',
                'biaya' => 500
            ]
        ];

        foreach ($jenis_layanan as $value) {
            $data = new RefJenisLayanan([$value]);
            $data->save();
        }
        foreach ($layanan as $value) {
            $data = new RefLayanan($value);
            $data->save();
        }
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
