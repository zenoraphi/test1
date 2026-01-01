<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;

class AdminJurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'jurusan'  => 'Rekayasa Perangkat Lunak',
                'username' => 'admin_rpl',
                'password' => 'rpl@2025',
            ],
            [
                'jurusan'  => 'Teknik Komputer Jaringan',
                'username' => 'admin_tkj',
                'password' => 'tkj@2025',
            ],
            [
                'jurusan'  => 'Desain Komunikasi Visual',
                'username' => 'admin_dkv',
                'password' => 'dkv@2025',
            ],
            [
                'jurusan'  => 'Akuntansi',
                'username' => 'admin_akl',
                'password' => 'akl@2025',
            ],
            [
                'jurusan'  => 'Manajemen Perkantoran Layanan Bisnis',
                'username' => 'admin_mplb',
                'password' => 'mplb@2025',
            ],
            [
                'jurusan'  => 'Pemasaran',
                'username' => 'admin_pemasaran',
                'password' => 'pemasaran@2025',
            ],
            [
                'jurusan'  => 'Kuliner',
                'username' => 'admin_kuliner',
                'password' => 'kuliner@2025',
            ],
            [
                'jurusan'  => 'Usaha Layanan Wisata',
                'username' => 'admin_ulw',
                'password' => 'ulw@2025',
            ],
        ];

        foreach ($data as $item) {
            $jurusan = Jurusan::where('jurusan', $item['jurusan'])->first();

            if (!$jurusan) {
                continue;
            }

            User::updateOrCreate(
                ['username' => $item['username']],
                [
                    'name'       => 'Admin ' . $item['jurusan'],
                    'password'   => Hash::make($item['password']),
                    'role'       => 'admin_jurusan',
                    'jurusan_id' => $jurusan->id_jurusan,
                ]
            );
        }
    }
}
