<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table="productdiscount";
    protected $fillable = ['product_id','quantity','To_quantity','discount'];
}
