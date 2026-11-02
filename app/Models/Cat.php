<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    public const BREEDS = ['Kampung', 'Persia', 'Anggora', 'Oren Barbar'];

    public const TEMPERS = ['Manja', 'Mager', 'Galak'];

    protected $fillable = ['name', 'found_at', 'breed', 'temper', 'age', 'vaccinated'];

    protected function casts(): array
    {
        return ['vaccinated' => 'boolean', 'age' => 'integer'];
    }
}
