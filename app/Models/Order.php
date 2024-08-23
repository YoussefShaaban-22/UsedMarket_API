<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table="order";
    protected $fillable = ['order_id','user_id','product_id','seller_id','quantity','color','product_price'
                            ,'total_product_price','total_price','status','paid','comment','user_required'];

    public static function getLastOrderId()
    {
        $lastOrder = self::orderBy('order_id', 'desc')->first();
        return $lastOrder ? $lastOrder->order_id : 0;
    }
}
