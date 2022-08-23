<?php

use Illuminate\Support\Facades\Route;

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
//Route::get('dd','ProductsController@index');

Route::group(['middleware'=>'auth',  'as'=>'admin.'], function() {
    Route::get('/dashboard',function (){
        return view('dashboard.index');
    })->name('dashboard');
    Route::resource('products','ProductsController');
    Route::get('shop','ProductsController@shop')->name('shop');
    Route::get('rate','ProductsController@rate')->name('rate');
    Route::post('store/cart','ProductsController@cart')->name('cart');
    Route::get('delete/cart/{user_id}/{product_id}','ProductsController@delete_cart')->name('delete.cart');

    Route::get('cart/{id}','ProductsController@all_cart')->name('all.cart');
    Route::get('payment/{product_id}/{user_id}','ProductsController@payment')->name('payment');
    Route::get('callback/{product_id}/{user_id}','ProductsController@callback')->name('callback');






});

require __DIR__.'/auth.php';
