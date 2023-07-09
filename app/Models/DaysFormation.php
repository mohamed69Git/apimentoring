<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaysFormation extends Model
{
    use HasFactory;
    public function formations(){
        return $this->belongsToMany(Formation::class, 'formation_has_day_formations');
    }
}
