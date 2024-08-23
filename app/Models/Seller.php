<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table="seller";
    protected $fillable = ['name','logo','description','slide_image','phone','whatsappLink','map','slug','showData'];
}
