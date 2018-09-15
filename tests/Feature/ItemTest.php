<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
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

    	$this->actingAs($user, 'admin')
    		->get('fashionsavvy/admin/items/')
    		->assertStatus(200);
    }

    public function testShow()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$item = factory('App\Item')->create();

    	$this->actingAs($user, 'admin')
    		->get("fashionsavvy/admin/items/$item->id")
    		->assertSee($item->name)
    		->assertStatus(200);
    }

    public function testCreate()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$this->actingAs($user, 'admin')
    		->get('fashionsavvy/admin/items/create')
    		->assertStatus(200);
    }

    public function testEdit()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$item = factory('App\Item')->create();

    	$this->actingAs($user, 'admin')
    		->get("/fashionsavvy/admin/items/$item->id/edit")
    		->assertSee($item->id)
    		->assertStatus(200);
    }

    public function testUpdate()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$item = factory('App\Item')->create();
    	$data = [
            'name'=>'test',
            'price'=>10,
            'quantity'=>5,
            'img_src'=>'shirt.png',
            'attributes'=>['size'=>'Large', 'color'=>'Red'],
            'category'=>'test',
            'description'=>'test'
        ];

    	$this->actingAs($user, 'admin')
    		->put("/fashionsavvy/admin/items/$item->id", $data)
    		->assertStatus(302);
    }

    public function testDestroy()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$item = factory('App\Item')->create();
  

    	$this->actingAs($user, 'admin')
    		->delete("/fashionsavvy/admin/items/$item->id")
    		->assertStatus(302);
    }
}
