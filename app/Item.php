<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
    	'name', 'price', 'quantity', 'img_src', 'attributes','category', 'description'
    ];
}
