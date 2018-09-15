<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
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
    		->get('/fashionsavvy/admin/category')
    		->assertStatus(200);
    }

    public function testShow()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$category = factory('App\Category')->create();
    	$this->actingAs($user, 'admin')
    		->get('/fashionsavvy/admin/category/'.$category->id)
    		->assertSee($category->name)
    		->assertStatus(200);
    }

    public function testCreate()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$this->actingAs($user, 'admin')
    		->get('/fashionsavvy/admin/category/create')
    		->assertStatus(200);
    }

    public function testEdit()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$category = factory('App\Category')->create();

    	$this->actingAs($user, 'admin')
    		->get("/fashionsavvy/admin/category/$category->id/edit")
    		->assertSee($category->name)
    		->assertStatus(200);
    }

    public function testUpdate()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$category = factory('App\Category')->create();
    	$data = ['name'=>'test'];

    	$this->actingAs($user, 'admin')
    		->put("/fashionsavvy/admin/category/$category->id", $data)
    		->assertStatus(302);
    }

    public function testDestroy()
    {
    	$user = factory('App\User')->create();
    	factory('App\Role')->create(['user_id'=>$user->id, 'role'=>'admin']);

    	$category = factory('App\Category')->create();
  

    	$this->actingAs($user, 'admin')
    		->delete("/fashionsavvy/admin/category/$category->id")
    		->assertStatus(302);
    }




}
