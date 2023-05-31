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
    protected $fillable = ['label', 'plan', 'length', 'level'];
    public function assets(): HasMany
    {
        return $this->hasMany(Assets::class);
    }

    protected $appends = ['worth_to_watch10_hours'];
    public function getWorthToWatch10HoursAttribute(): bool
    {
        return $this->length > 10;
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function () {
            Log::info("Formation added successfully");
        });
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
    /**
     * Get the calendar that owns the Formation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }
}
