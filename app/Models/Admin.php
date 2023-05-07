<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authtenticatable;

class Admin extends Authtenticatable
{
    use HasFactory;
    public function isSupAdmin()
    {
        return $this->role === 'super_admin';
    }
    private $attributes = [
        'role' => 'admin'
    ];
}
