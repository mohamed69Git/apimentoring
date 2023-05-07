<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formation extends Model
{
    use HasFactory;
    /**
     * Get all of the assets for the Formation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Assets::class);
    }
}
