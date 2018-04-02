<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

//users
Route::group([

    'prefix' => 'users'

], function () {

	Route::post("/register","UserController@register");
	Route::post("/update/{id}","UserController@update");

});

//category
Route::group([
  	
  	'prefix'=>'category'

], function(){
    
    Route::get("/get","CategoryController@index");
    Route::get("/getCategory/{id}","CategoryController@get");
    Route::post("/addCategory","CategoryController@add");
    Route::delete("/deleteCategory/{id}","CategoryController@delete");
    Route::post("/editCategory/{id}","CategoryController@update");

});

//items
Route::group([

    'prefix' => 'items'

], function () {

	Route::get("/get","ItemsController@get");
	Route::get("/getItems/{id}","ItemsController@getItems");
	Route::post("/addItems/{id}","ItemsController@add");
	Route::delete("/deleteItems/{id}","ItemsController@delete");
	Route::post("/editItems/{id}","ItemsController@update");
    Route::get("/searchI/{s}","ItemsController@searchI");
    Route::get("/searchC/{s}","ItemsController@searchC");
	
});

//items
Route::group([

    'prefix' => 'transaction'

], function () {

    Route::get("/get","TransactionController@index");
    Route::get("/getTrans/{id}","TransactionController@get");
    Route::post("/addItems/{id}","TransactionController@add");
    Route::delete("/deleteItems/{id}","TransactionController@delete");
    Route::post("/editItems/{id}","TransactionController@update");
    
});

//cart
Route::group([

    'prefix' => 'cart'

], function () {

	Route::get("/getCartList","CartController@index");
	Route::post("/addCart/{id}","CartController@add");
	Route::delete("/deleteCart/{id}","CartController@delete");
	Route::post("/editCart/{id}","CartController@update");
	Route::delete("/deletCart","CartController@deleteAll");

});

//histories
Route::group([

    'prefix' => 'history'

], function () {

	Route::post("/addhistory","HistoriesController@add");
	Route::get("/history/{id}","HistoriesController@history");
	Route::get("/solditems/{id}","HistoriesController@solditems");
	Route::delete("/deletehistory/{id}","HistoriesController@delete");

});