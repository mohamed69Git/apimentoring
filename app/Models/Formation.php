<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Formation extends Model
{
    use HasFactory;
    /**
     * Get all of the assets for the Formation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected $fillable = ['label', 'plan', 'level', 'description', 'category_formation_id'];
    public function assets(): HasMany
    {
        return $this->hasMany(Assets::class);
    }
    /**
     * Get the user that owns the Formation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected $with = ['calendar', 'days'];
    /**
     * Get the calendar that owns the Formation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }
    public function days(){
        return $this->belongsToMany(DaysFormation::class, 'formation_has_day_formations');
    }
}
