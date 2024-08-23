<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table="feedback";
    protected $fillable = ['user_id','user_name','product_id','feedback','rating'];
}
