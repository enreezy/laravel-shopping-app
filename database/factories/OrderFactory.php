<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        "user_id" => 2,
        "orders" => ["1"=>["id"=>"1","name"=>"vel","price"=>"10.5","quantity"=>"1","attributes"=>['size'=>'Large','color'=>'Blue','max'=>'10']]],
        "total" => 10.5,
        "firstname" => "enrik",
        "lastname" => "sabalvaro",
        "email" => "enriksabalvaro7@gmail.com",
        "address" => "test"
    ]; 
});