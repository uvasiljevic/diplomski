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

Route::get('/', 'App\Http\Controllers\FrontController@index');

Route::get('/contact', 'App\Http\Controllers\FrontController@contact');

Route::get('/cart', 'App\Http\Controllers\FrontController@cart');

Route::get('/login', 'App\Http\Controllers\FrontController@login');
Route::get('/registration', 'App\Http\Controllers\FrontController@registration');
Route::post('/insert-user', 'App\Http\Controllers\UserController@registration');
Route::get('/do-login', 'App\Http\Controllers\UserController@login');
Route::get('/logout', 'App\Http\Controllers\UserController@logout');

Route::get('/products', 'App\Http\Controllers\FrontController@products');
Route::get('/{category}', 'App\Http\Controllers\FrontController@products');
Route::post('/{category}', 'App\Http\Controllers\FrontController@products');
Route::get('/{category}/{product}', 'App\Http\Controllers\FrontController@product');
Route::post('/products', 'App\Http\Controllers\FrontController@products');

Route::post('/{category}/{product}/add-to-cart', 'App\Http\Controllers\CartController@addToCart');
Route::delete('/cart/clear-cart', 'App\Http\Controllers\CartController@clearCart');
Route::post('/cart/update-cart-item', 'App\Http\Controllers\CartController@updateCartItem');
Route::post('/cart/make-order', 'App\Http\Controllers\OrderController@makeOrder');


