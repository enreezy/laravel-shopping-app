<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminImage extends Model
{
    protected $fillable = [
    	'img_src', 'sender_id'
    ];

    public function sender()
    {
    	return $this->belongsTo('App\User','sender_id');
    }
}
