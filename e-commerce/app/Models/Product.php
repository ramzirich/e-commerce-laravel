<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'quantity', 'price', 'image_url', 'description', 'person_id', 'category_id'];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public static function getProductWithCategory($categoryId)
    {
        return self::with('category')->find($categoryId);
    }
    public function person(){
        return $this->belongsTo(Persons::class, 'person_id');
    }
    public static function getProductWithPerson($personId)
    {
        return self::with('persons')->find($personId);
    }

}
