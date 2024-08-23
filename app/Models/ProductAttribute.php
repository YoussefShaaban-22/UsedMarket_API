<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table="productattribute";
    protected $fillable = ['product_id','attribute_name','attribute_value'];
}
