<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shippingpolicy extends Model
{
    use HasFactory;
    protected $table="shippingpolicy";
    protected $fillable = ['content'];
}
