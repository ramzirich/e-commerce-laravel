<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $fillable = ['person_id', 'product_id', 'quantity'];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public static function getShoppingCartWithProduct($productId)
    {
        return self::with('product')->find($productId);
    }
    public function person(){
        return $this->belongsTo(Persons::class, 'person_id');
    }
    public static function getShoppingCartWithPerson($personId)
    {
        return self::with('persons')->find($personId);
    }
}
