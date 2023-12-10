<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'person_id'];

    public function person(){
        return $this->belongsTo(Persons::class, 'person_id');
    }
    public static function getProductWithPerson($personId)
    {
        return self::with('persons')->find($personId);
    }
}
