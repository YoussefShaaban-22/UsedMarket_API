<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = [
        'name', 'user_id', 'category_id', 'brand_id', 'seller_id',
        'thumbnail_image', 'image', 'tags', 'short_description', 'description',
        'price', 'quantity', 'status', 'feature_product', 'slug'
    ];
    protected $casts = [
        'image' => 'array',
        'tags' => 'array',
    ];
}
