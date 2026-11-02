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
        ]);

        Cat::insert([
            ['name' => 'Mochi', 'found_at' => 'Parkiran Gedung C', 'breed' => 'Persia', 'temper' => 'Manja', 'age' => 8, 'vaccinated' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Oyen', 'found_at' => 'Kantin Utama', 'breed' => 'Oren Barbar', 'temper' => 'Mager', 'age' => 14, 'vaccinated' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Belang', 'found_at' => 'Depan Perpustakaan', 'breed' => 'Kampung', 'temper' => 'Galak', 'age' => 5, 'vaccinated' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
