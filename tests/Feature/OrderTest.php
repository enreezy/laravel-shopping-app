<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
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

    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);
    	$order = factory('App\Order')->create();

    	$this->actingAs($user, 'admin')
    		->get('fashionsavvy/admin/orders')
    		->assertSee($order->id)
    		->assertStatus(200);
    }

    public function testShow()
    {
    	$user = factory('App\User')->create();

    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);
    	$order = factory('App\Order')->create();

    	$this->actingAs($user, 'admin')
    		->get("fashionsavvy/admin/orders/$order->id")
    		->assertSee($order->id)
    		->assertStatus(200);
    }
}
