<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $casts = [
		'attributes'=>'array'
	];

    protected $fillable = [
    	'name', 'price', 'quantity', 'img_src', 'attributes','category', 'description'
    ];
}
