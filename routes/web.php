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
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::group(['prefix' => 'product','middleware' => ['permission:Product']],function(){
        Route::get('/','ProductController@index')->name('product');
        Route::get('/add','ProductController@add')->name('product-add');
        Route::post('/add','ProductController@storage')->name('product-save');
        Route::get('/edit/{id}','ProductController@edit')->where('id', '[0-9]+')->name('product-edit');
        Route::post('/remove','ProductController@remove')->name('product-delete');
        Route::get('/restore/{id}','ProductController@restore')->where('id', '[0-9]+')->name('product-restore');
        Route::get('/view/{id}','ProductController@view')->where('id', '[0-9]+')->name('product-view');
    });
    Route::group(['prefix' => 'order','middleware' => ['permission:Order']],function(){
        Route::get('/','OrderController@index')->name('order');
        Route::get('/add','OrderController@add')->name('order-add');
        Route::post('/add','OrderController@storage')->name('order-save');
        Route::get('/edit/{id}','OrderController@edit')->where('id', '[0-9]+')->name('order-edit');
        Route::post('/remove','OrderController@remove')->name('order-delete');
        Route::get('/restore/{id}','OrderController@restore')->where('id', '[0-9]+')->name('order-restore');
        Route::get('/view/{id}','OrderController@view')->where('id', '[0-9]+')->name('order-view');
    });
});
