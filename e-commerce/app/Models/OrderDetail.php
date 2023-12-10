<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'quantity', 'product_id', 'order_history_id'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public static function getOrderDetailtWithProduct($productId)
    {
        return self::with('product')->find($productId);
    }

    public function order_history(){
        return $this->belongsTo(OrderHistory::class, 'order_history_id');
    }
    public static function getOrderDetailWithOrderHistory($orderHistoryId)
    {
        return self::with('product')->find($orderHistoryId);
    }
}
