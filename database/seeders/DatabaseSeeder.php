<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Anak;
use App\Models\Bantuan;
use App\Models\DetailAnak;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        $kriteria = [
            ['name' => 'Berat Badan Menurut Umur', 'jenis' => 'benefit', 'bobot' => 25],
            ['name' => 'Tinggi Badan Menurut Umur', 'jenis' => 'benefit', 'bobot' => 30],
            ['name' => 'Berat Badan Menurut Tinggi Badan', 'jenis' => 'benefit', 'bobot' => 25],
            ['name' => 'indeks Massa Tubuh menurut Umur', 'jenis' => 'benefit', 'bobot' => 20],
        ];

        foreach ($kriteria as $item) {
            Kriteria::create($item);
        }

        $subKriteria = [
            ['name' => 'Gizi Buruk', 'bobot' => 1, 'id_kriteria' => 1],
            ['name' => 'Gizi Kurang', 'bobot' => 2, 'id_kriteria' => 1],
            ['name' => 'Gizi Baik', 'bobot' => 3, 'id_kriteria' => 1],
            ['name' => 'Gizi Lebih', 'bobot' => 4, 'id_kriteria' => 1],

            ['name' => 'Sangat Pendek', 'bobot' => 1, 'id_kriteria' => 2],
            ['name' => 'Pendek', 'bobot' => 2, 'id_kriteria' => 2],
            ['name' => 'Normal', 'bobot' => 3, 'id_kriteria' => 2],
            ['name' => 'Tinggi', 'bobot' => 4, 'id_kriteria' => 2],

            ['name' => 'Sangat Kurus', 'bobot' => 1, 'id_kriteria' => 3],
            ['name' => 'Kurus', 'bobot' => 2, 'id_kriteria' => 3],
            ['name' => 'Normal', 'bobot' => 3, 'id_kriteria' => 3],
            ['name' => 'Gemuk', 'bobot' => 4, 'id_kriteria' => 3],

            ['name' => 'Sangat Kurus', 'bobot' => 1, 'id_kriteria' => 4],
            ['name' => 'Kurus', 'bobot' => 2, 'id_kriteria' => 4],
            ['name' => 'Normal', 'bobot' => 3, 'id_kriteria' => 4],
            ['name' => 'Gemuk', 'bobot' => 4, 'id_kriteria' => 4],
        ];

        foreach ($subKriteria as $item) {
            SubKriteria::create($item);
        }

        $bantuan = [
            ['name' => 'Beras'],
            ['name' => 'Telur'],
            ['name' => 'Daging'],
            ['name' => 'Susu'],
            ['name' => 'Sayur'],
            ['name' => 'Buah'],
            ['name' => 'Minyak'],
            ['name' => 'Gula'],
            ['name' => 'Garam'],
            ['name' => 'Dana'],
        ];

        foreach ($bantuan as $item) {
            Bantuan::create($item);
        }
    }
}
