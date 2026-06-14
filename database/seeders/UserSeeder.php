<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────────
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name'     => 'Super Admin',
                'username' => 'superadmin',
                'email'    => null,
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // ── Guru ──────────────────────────────────────────────
        $gurus = [
            ['name' => 'Budi Santoso', 'username' => 'budi.santoso'],
            ['name' => 'Sari Dewi',    'username' => 'sari_dewi'],
        ];

        foreach ($gurus as $guru) {
            User::updateOrCreate(
                ['username' => $guru['username']],
                [
                    'name'     => $guru['name'],
                    'username' => $guru['username'],
                    'email'    => null,
                    'password' => Hash::make('guru123'),
                    'role'     => 'guru',
                ]
            );
        }

        // ── Siswa ─────────────────────────────────────────────
        $siswas = [
            ['name' => 'Andi Pratama', 'username' => 'andi_pratama'],
            ['name' => 'Rina Melati',  'username' => 'rina.melati'],
            ['name' => 'Doni Kusuma',  'username' => 'doni123'],
        ];

        foreach ($siswas as $siswa) {
            User::updateOrCreate(
                ['username' => $siswa['username']],
                [
                    'name'     => $siswa['name'],
                    'username' => $siswa['username'],
                    'email'    => null,
                    'password' => Hash::make('siswa123'),
                    'role'     => 'siswa',
                ]
            );
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->table(
            ['Role', 'Username', 'Password'],
            [
                ['Admin', 'superadmin',   'admin123'],
                ['Guru',  'budi.santoso', 'guru123'],
                ['Guru',  'sari_dewi',    'guru123'],
                ['Siswa', 'andi_pratama', 'siswa123'],
                ['Siswa', 'rina.melati',  'siswa123'],
                ['Siswa', 'doni123',      'siswa123'],
            ]
        );
    }
}