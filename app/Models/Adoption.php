<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adoption extends Model
{
    public const HOUSING = ['Rumah Sendiri', 'Kos Ramah Hewan', 'Apartemen'];

    public const EXPERIENCE = ['Pemula', 'Pernah Pelihara', 'Punya Kucing Lain'];

    public const PENDING = 'Diajukan';

    public const DONE = 'Diadopsi';

    protected $fillable = ['user_id', 'cat_id', 'address', 'housing_type', 'experience', 'indoor', 'cost_commitment', 'status'];

    protected $attributes = ['status' => self::PENDING];

    protected function casts(): array
    {
        return ['indoor' => 'boolean', 'cost_commitment' => 'boolean'];
    }

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::PENDING;
    }
}
