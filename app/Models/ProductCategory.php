<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = "product_category";
    protected $fillable = ['name', 'image', 'description', 'parent_id', 'slug'];

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }
    public function subcategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
}
