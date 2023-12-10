<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'image_url', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function getPersonWithRole($personId)
    {
        return self::with('role')->find($personId);
    }
}
