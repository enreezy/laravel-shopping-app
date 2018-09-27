<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
    	'sender', 'receiver', 'message', 'topic'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User','sender');
    }
}
