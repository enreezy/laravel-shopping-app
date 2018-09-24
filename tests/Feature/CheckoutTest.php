<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testIndex()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'customer']);

    	$this->actingAs($user, 'admin')
    		->get('fashionsavvy/customer/checkout')
    		->assertStatus(200);
    }

    public function testStore()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'customer']);

    	\Cart::add(455, 'Sample Item', 100.99, 2, array('size'=>'Large', 'color'=>'Blue', 'max'=>10));
    	\Cart::add(155, 'Sample Item 2', 100.99, 2, array('size'=>'Large', 'color'=>'Blue', 'max'=>10));
    	$orders = \Cart::getContent();
    	$total = \Cart::getTotal();

    	$data = [
            'user_id'=>$user->id,
            'orders'=>$orders,
            'total'=>$total,
            'firstname'=>'test',
            'lastname'=>'test',
            'email'=>$user->email,
            'address'=>'test test'
        ];


    	$this->actingAs($user, 'admin')
    		->post('/fashionsavvy/customer/checkout', $data)
    		->assertStatus(302);
    }
}
