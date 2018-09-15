<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
    	'orders' => 'array',
        'attributes' => 'array'
    ];

    protected $fillable = [
    	'user_id', 'orders', 'total', 'firstname', 'lastname', 'email', 'address'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
}
