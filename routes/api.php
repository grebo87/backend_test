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

Route::post('/login', 'Api\AuthController@login')->name('login');
Route::post('/register', 'Api\AuthController@register');
Route::post('/logout', 'Api\AuthController@logout');

Route::middleware(['auth:api'])->group(function(){
	Route::resource('employees', 'Api\EmployeeController');
});