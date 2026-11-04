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
            'role' => User::STAFF,
        ]);

        User::factory()->create([
            'name' => 'Adopter Bandung',
            'email' => 'adopter@meowdopt.test',
        ]);

        Cat::insert([
            ['name' => 'Belang', 'found_at' => 'Dago, Bandung', 'breed' => 'Kampung', 'temper' => 'Manja', 'age' => 8, 'vaccinated' => true, 'image' => 'Belang.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chocho', 'found_at' => 'Buahbatu, Bandung', 'breed' => 'Kampung', 'temper' => 'Mager', 'age' => 12, 'vaccinated' => true, 'image' => 'chocho.jpeg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wolfy', 'found_at' => 'Ciumbuleuit, Bandung', 'breed' => 'Persia', 'temper' => 'Galak', 'age' => 9, 'vaccinated' => true, 'image' => 'Wolfy.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ciko', 'found_at' => 'Dipatiukur, Bandung', 'breed' => 'Anggora', 'temper' => 'Manja', 'age' => 7, 'vaccinated' => true, 'image' => 'ciko.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kimi', 'found_at' => 'Bojongsoang, Bandung', 'breed' => 'Persia', 'temper' => 'Mager', 'age' => 10, 'vaccinated' => true, 'image' => 'Kimi.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lui', 'found_at' => 'Sukajadi, Bandung', 'breed' => 'Oren Barbar', 'temper' => 'Galak', 'age' => 6, 'vaccinated' => false, 'image' => 'Lui.jpeg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
