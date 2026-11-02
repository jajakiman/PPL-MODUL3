<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function adoptions(): HasMany
    {
        return $this->hasMany(Adoption::class);
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->whereDoesntHave('adoptions', fn (Builder $q) => $q->where('status', Adoption::DONE));
    }

    public function isAvailable(): bool
    {
        return $this->adoptions()->where('status', Adoption::DONE)->doesntExist();
    }
}
