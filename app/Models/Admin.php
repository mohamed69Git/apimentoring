<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authtenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authtenticatable
{
    protected $fillable = ['email', 'password'];
    protected $hidden = ['password'];
    use HasFactory, HasApiTokens;
    public function isSupAdmin()
    {
        return $this->role === 'super_admin';
    }
    protected $attributes = [
        'role' => 'admin'
    ];
}
