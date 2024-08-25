<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'seller_id',
        'quantity',
        'color',
        'product_price',
        'total_product_price',
        'total_price',
        'status',
        'paid',
        'comment',
        'user_required'
    ];

    public static function getLastOrderId()
    {
        $lastOrder = self::orderBy('order_id', 'desc')->first();
        return $lastOrder ? $lastOrder->order_id : 0;
    }

    public static function analyzeOrderData()
    {
        $sellerCount = self::distinct('seller_id')->count('seller_id');
        $userCount = self::distinct('user_id')->count('user_id');
        $productCount = self::distinct('product_id')->count('product_id');
        $orderCount = self::distinct('order_id')->count('order_id');
        $total_price = self::distinct('total_price')->sum('total_price');

         return [
            'total_orders' => $orderCount,
            'total_price' => $total_price,
            'total_sellers' => $sellerCount,
            'total_users' => $userCount,
            'total_products' => $productCount,
        ];
    }

    public static function getProductCounts()
    {
        return self::select('product_id', \DB::raw('count(*) as count'),
        \DB::raw('sum(quantity) as total_quantity'), \DB::raw('sum(total_product_price) as total_product_price'))
            ->groupBy('product_id')
            ->get()
            ->toArray();
    }

    public static function getUserOrderStats()
    {
        return self::select('user_id', \DB::raw('count(distinct order_id) as order_count'),
            \DB::raw('sum(quantity) as total_quantity'), \DB::raw('sum(total_product_price) as total_product_price'))
            ->groupBy('user_id')
            ->get()
            ->toArray();
    }

    public static function getSellerOrderStats()
    {
        return self::select('seller_id', \DB::raw('count(distinct order_id) as order_count'),
            \DB::raw('sum(quantity) as total_quantity'), \DB::raw('sum(total_product_price) as total_product_price'))
            ->groupBy('seller_id')
            ->get()
            ->toArray();
    }
}
