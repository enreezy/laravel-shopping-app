<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
	$now = Carbon::now();
	//$now = new Carbon('first day of feb');
	//$now = Carbon::createFromFormat('Y z', '1886 300');
	//$now = Carbon::now();
	//$oneYearFromNow = $now->addYear();
	//$date = new Carbon('2018-09-10 21:15:00');
	//$year = $now->year;
	$date = Carbon::create(2018, 3, 4, 5, 44, 2);
	dd($date);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/fashionsavvy', 'VisitorController', [
	'names' => [
		'index' => 'visitor.index',
		'show' => 'visitor.show',
		'store' => 'visitor.store',
		'update' => 'visitor.update',
		'destroy' => 'visitor.destroy',

	]
]);

Route::get('/fashionsavvy/empty','VisitorController@empty')->name('visitor.empty');

Route::group(['prefix'=>'fashionsavvy'], function(){
	Route::group(['prefix'=>'visitor'], function(){
		Route::get('/checkout', 'VisitorController@checkout')->name('visitor.checkout');
		Route::get('/login', 'VisitorController@login')->name('visitor.login');
	});

	Route::group(['prefix'=>'admin'], function(){
		Route::resource('/adminpanel', 'AdminController', [
			'names' => [
				'index' => 'admin.index'
			]
		]);

		Route::resource('/items', 'ItemController', [
			'names' => [
				'index' => 'item.index',
	            'create' => 'item.create',
	            'store' => 'item.store',
	            'show' => 'item.show',
	            'edit' => 'item.edit',
	            'update' => 'item.update',
	            'destroy' => 'item.destroy',
			]
		]);

		Route::resource('/category', 'CategoryController', [
			'names' => [
				'index' => 'category.index',
	            'create' => 'category.create',
	            'store' => 'category.store',
	            'show' => 'category.show',
	            'edit' => 'category.edit',
	            'update' => 'category.update',
	            'destroy' => 'category.destroy',
			]
		]);

		Route::resource('/orders', 'OrderController', [
			'names' => [
				'index' => 'order.index',
	            'create' => 'order.create',
	            'store' => 'order.store',
	            'show' => 'order.show',
	            'edit' => 'order.edit',
	            'update' => 'order.update',
	            'destroy' => 'order.destroy',
			]
		]);
	});
	
});



Route::group(['prefix'=>'fashionsavvy'], function(){
	Route::group(['prefix'=>'customer'], function(){
		
		Route::resource('/checkout', 'ShoppingController',[
			'names' => [
				'index' => 'checkout.index',
				'store' => 'checkout.store'
			]
		]);

		Route::resource('/shopping', 'CartController', [
			'names' => [
				'index' => 'shopping.index',
				'store' => 'shopping.store',
				'show' => 'shopping.show',
			]
		]);

		Route::resource('/chat', 'MessageController', [
			'names'=>[
				'index' => 'message.index',
				'store' => 'message.store',
				'show' => 'message.show',
			]
		]);

		Route::resource('/topic', 'TopicController', [
			'names'=>[
				'index' => 'topic.index',
				'show' => 'topic.show'
			]
		]);

		Route::get('/shopping/empty','CartController@empty')->name('shopping.empty');
	});
});






