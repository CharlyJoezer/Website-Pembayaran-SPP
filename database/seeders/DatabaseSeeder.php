<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'nisn' => '0044059353',
            'id_kelas' => 1,
            'id_spp' => 1,
            'nis' => 6270,
            'nama' => 'charly joezer',
            'password' => Hash::make('62700044059353'),
            'alamat' => 'BDS',
            'no_telp' => '013858817362'
        ]);
        User::create([
            'nisn' => '0351452353',
            'id_kelas' => 2,
            'id_spp' => 1,
            'nis' => 6275,
            'nama' => 'Reza',
            'password' => Hash::make('62750351452353'),
            'alamat' => 'Gunung 4',
            'no_telp' => '081383252332'
        ]);
        User::create([
            'nisn' => '56789',
            'id_kelas' => 1,
            'id_spp' => 1,
            'nis' => 1234,
            'nama' => 'Windah',
            'password' => Hash::make('123456789'),
            'alamat' => 'Manggar Outside',
            'no_telp' => '089681357356'
        ]);
        
        // ADMIN
        Petugas::create([
            'username' => 'AdminSkarla',
            'password' => Hash::make('12345678'),
            'nama_petugas' => 'Admin skarla',
            'level' => 'admin'
        ]);
        Petugas::create([
            'username' => 'PetugasSkarla',
            'password' => Hash::make('12345678'),
            'nama_petugas' => 'Petugas Skarla',
            'level' => 'petugas'
        ]);

        Kelas::create([
            'nama_kelas' => 'XII',
            'kompetensi_keahlian' => 'RPL'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII',
            'kompetensi_keahlian' => 'TKJ'
        ]);
        Kelas::create([
            'nama_kelas' => 'XII',
            'kompetensi_keahlian' => 'MM'
        ]);

        Spp::create([
            'tahun' => 2023,
            'nominal' => "250000"
        ]);
        Spp::create([
            'tahun' => 2024,
            'nominal' => "250000"
        ]);
        Spp::create([
            'tahun' => 2024,
            'nominal' => "250000"
        ]);
    }
}
