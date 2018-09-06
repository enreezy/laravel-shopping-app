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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/shopping', 'CartController', [
	'names' => [
		'index' => 'shopping.index',
		'store' => 'shopping.store',
		'show' => 'shopping.show',
	]
]);

Route::resource('/item', 'ItemController', [
	'names' => [
		'show' => 'item.show'
	]
]);

Route::resource('/checkout', 'ShoppingController',[
	'names' => [
		'index' => 'checkout.index',
	]
]);


