<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware(['jwt.verify'])->group(function (){

    Route::resource('products','ApiProductsController');
    Route::get('shop','ApiProductsController@shop');
    Route::post('store/cart','ApiProductsController@cart');
    Route::delete('delete/cart/{product_id}','ApiProductsController@delete_cart');
    Route::get('cart','ApiProductsController@all_cart');
    Route::get('payment/{product_id}','ApiProductsController@payment')->name('api.payment');
    Route::get('callback/{product_id}','ApiProductsController@callback')->name('api.callback');

});




