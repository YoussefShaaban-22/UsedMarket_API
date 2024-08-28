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

    public static function analyzeOrderDataByDay()
    {
        $dailyAnalysis = self::selectRaw('DATE(created_at) as date')
            ->selectRaw('SUM(total_product_price) as total_price')
            ->selectRaw('COUNT(DISTINCT order_id) as order_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $dailyData = $dailyAnalysis->mapWithKeys(function ($item) {
            return [$item->date => [
                'total_price' => $item->total_price,
                'order_count' => $item->order_count,
            ]];
        })->toArray();

        return $dailyData;
    }

    public static function analyzeOrderData()
    {
        $sellerCount = self::distinct('seller_id')->count('seller_id');
        $userCount = self::distinct('user_id')->count('user_id');
        $productCount = self::distinct('product_id')->count('product_id');
        $orderCount = self::distinct('order_id')->count('order_id');
        $total_price = self::sum('total_product_price');

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
        return self::select(
            'product_id',
            \DB::raw('count(*) as count'),
            \DB::raw('sum(quantity) as total_quantity'),
            \DB::raw('sum(total_product_price) as total_product_price')
        )
            ->groupBy('product_id')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }

    public static function getUserOrderStats()
    {
        return self::select(
            'user_id',
            \DB::raw('count(distinct order_id) as order_count'),
            \DB::raw('sum(quantity) as total_quantity'),
            \DB::raw('sum(total_product_price) as total_product_price')
        )
            ->groupBy('user_id')
            ->orderBy('order_count', 'desc')
            ->get()
            ->toArray();
    }

    public static function getSellerOrderStats()
    {
        return self::select(
            'seller_id',
            \DB::raw('count(distinct order_id) as order_count'),
            \DB::raw('count(product_id) as product_count'),
            \DB::raw('sum(quantity) as total_quantity'),
            \DB::raw('sum(total_product_price) as total_product_price')
        )
            ->groupBy('seller_id')
            ->orderBy('order_count', 'desc')
            ->get()
            ->toArray();
    }


    public static function analyzeOrderSellerDataByDay($seller_id)
    {
        $dailyAnalysis = self::where('seller_id', $seller_id)
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('SUM(total_product_price) as total_price')
            ->selectRaw('COUNT(DISTINCT order_id) as order_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        $dailyData = $dailyAnalysis->mapWithKeys(function ($item) {
            return [$item->date => [
                'total_price' => $item->total_price,
                'order_count' => $item->order_count
            ]];
        })->toArray();

        return $dailyData;
    }
    public static function analyzeOrderSellerData($seller_id)
    {
        $sellerCount = self::where('seller_id', $seller_id)->distinct('seller_id')->count('seller_id');
        $userCount = self::where('seller_id', $seller_id)->distinct('user_id')->count('user_id');
        $productCount = self::where('seller_id', $seller_id)->distinct('product_id')->count('product_id');
        $orderCount = self::where('seller_id', $seller_id)->distinct('order_id')->count('order_id');
        $total_price = self::where('seller_id', $seller_id)->sum('total_product_price');

        return [
            'total_orders' => $orderCount,
            'total_price' => $total_price,
            'total_sellers' => $sellerCount,
            'total_users' => $userCount,
            'total_products' => $productCount,
        ];
    }
    public static function getProductSellerCounts($seller_id)
    {
        return self::where('seller_id', $seller_id)
            ->select(
                'product_id',
                \DB::raw('count(*) as count'),
                \DB::raw('sum(quantity) as total_quantity'),
                \DB::raw('sum(total_product_price) as total_product_price')
            )
            ->groupBy('product_id')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
    }
    public static function getUserOrderSellerStats($seller_id)
    {
        return self::where('seller_id', $seller_id)
            ->select(
                'user_id',
                \DB::raw('count(distinct order_id) as order_count'),
                \DB::raw('sum(quantity) as total_quantity'),
                \DB::raw('sum(total_product_price) as total_product_price')
            )
            ->groupBy('user_id')
            ->orderBy('order_count', 'desc')
            ->get()
            ->toArray();
    }
}
