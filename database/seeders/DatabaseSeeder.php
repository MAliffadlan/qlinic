<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.com',
            'nik' => '3307010101000001',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Layanan
        Service::create(['name' => 'Poli Umum', 'code' => 'UMM']);
        Service::create(['name' => 'Poli Gigi', 'code' => 'GIG']);

        // Akun pasien demo (kredensial lokal yang ditampilkan di halaman login)
        User::create(['name' => 'Pasien Demo', 'email' => 'patient01@qlinic.com', 'nik' => '3307010101000004', 'password' => Hash::make('password'), 'role' => 'patient']);

        // NIK referensi (untuk validasi anti-spam)
        User::create(['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'nik' => '3307010101000002', 'password' => Hash::make('password123'), 'role' => 'patient']);
        User::create(['name' => 'Siti Aminah', 'email' => 'siti@example.com', 'nik' => '3307010101000003', 'password' => Hash::make('password123'), 'role' => 'patient']);
    }
}
