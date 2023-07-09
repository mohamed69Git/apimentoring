<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CategoryFormation extends Model
{
    use HasFactory;

    public function demandes(): BelongsToMany
    {
        return $this->belongsToMany(Demande::class, "demande_categories");
    }
}
