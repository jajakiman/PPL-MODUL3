<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Staff Shelter',
            'email' => 'staff@meowdopt.test',
            'password' => 'password',
            'role' => User::STAFF,
        ]);

        User::factory()->create([
            'name' => 'Adopter Kampus',
            'email' => 'adopter@meowdopt.test',
            'password' => 'password',
        ]);

        Cat::insert([
            ['name' => 'Mochi', 'found_at' => 'Parkiran Gedung C', 'breed' => 'Persia', 'temper' => 'Manja', 'age' => 8, 'vaccinated' => true, 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oyen', 'found_at' => 'Kantin Utama', 'breed' => 'Oren Barbar', 'temper' => 'Mager', 'age' => 14, 'vaccinated' => true, 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Belang', 'found_at' => 'Depan Perpustakaan', 'breed' => 'Kampung', 'temper' => 'Galak', 'age' => 5, 'vaccinated' => false, 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ciko', 'found_at' => 'Fakultas Ilmu Komputer', 'breed' => 'Anggora', 'temper' => 'Manja', 'age' => 7, 'vaccinated' => true, 'image' => 'ciko.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kimi', 'found_at' => 'Taman Asrama Kampus', 'breed' => 'Persia', 'temper' => 'Mager', 'age' => 10, 'vaccinated' => true, 'image' => 'Kimi.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lui', 'found_at' => 'Selasar Lab PPL', 'breed' => 'Oren Barbar', 'temper' => 'Galak', 'age' => 6, 'vaccinated' => false, 'image' => 'Lui.jpeg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
