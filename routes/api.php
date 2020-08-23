<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    //public routs
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');

});

Route::middleware('auth:api')->group(function () {
    Route::get('/{categoryId}/products', 'api\ProductController@indexByCategory');
    Route::get('/products/{id}', 'api\ProductController@show');
    Route::post('/products', 'api\ProductController@store');
    Route::resource('products', 'api\ProductController');
    Route::resource('categories', 'api\CategoryController');
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

});


