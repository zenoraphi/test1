<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Rekayasa Perangkat Lunak',
            'Teknik Komputer Jaringan',
            'Desain Komunikasi Visual',
            'Akuntansi',
            'Manajemen Perkantoran Layanan Bisnis',
            'Pemasaran',
            'Kuliner',
            'Usaha Layanan Wisata',
        ];

        foreach ($data as $nama) {
            Jurusan::create([
                'jurusan' => $nama
            ]);
        }
    }
}
