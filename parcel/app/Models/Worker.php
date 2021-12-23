<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worker extends Authenticatable
{
    use HasFactory;

    protected $hidden   = ['password'];

    protected $fillable = ['first', 'last', 'email', 'title', 'password'];

    protected $appends  = ['full_name'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute()
    {
        $first  = $this->attributes['first'] ?? '';
        $last   = $this->attributes['last'] ?? '';

        return $first . ' ' . $last;
    }
}
