<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Petugas;
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

        // User::create([
        //     'nisn' => '0044059353',
        //     'id_kelas' => 1,
        //     'id_spp' => 1,
        //     'nis' => 6270,
        //     'nama' => 'charly joezer',
        //     'password' => Hash::make('62700044059353'),
        //     'alamat' => 'BDS',
        //     'no_telp' => '013858817362'
        // ]);
        
        // Petugas::create([
        //     'username' => 'Skarla',
        //     'password' => Hash::make('12345'),
        //     'nama_petugas' => 'admin skarla',
        //     'level' => 'admin'
        // ]);

        Kelas::create([
            'nama_kelas' => 'XII',
            'kompetensi_keahlian' => 'RPL'
        ]);
    }
}
