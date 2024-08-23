<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table="blog";
    protected $fillable = ['name','blog_category_id','image','short_description',
                            'description','slug','status','top_blog'];
}
