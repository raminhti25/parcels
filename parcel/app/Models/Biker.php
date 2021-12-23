<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biker extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $appends = ['full_name', 'role'];

    public function getFullNameAttribute()
    {
        $first  = $this->attributes['first'] ?? '';
        $last   = $this->attributes['last'] ?? '';

        return $first . ' ' . $last;
    }

    public function getRoleAttribute()
    {
        return 'biker';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
