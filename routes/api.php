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

Route::get('/contacts', 'App\Http\Controllers\ContactsController@index');
Route::get('/contacts/{contact}', 'App\Http\Controllers\ContactsController@show');
Route::post('/contacts', 'App\Http\Controllers\ContactsController@store');
Route::put('/contacts/{contact}', 'App\Http\Controllers\ContactsController@update');
Route::delete('/contacts/{contact}', 'App\Http\Controllers\ContactsController@destroy');

