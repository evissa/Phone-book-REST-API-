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


// Get access a resource and retrieve data and we don't have to modify or alter the state of this data
Route::get('/contacts', 'App\Http\Controllers\ContactsController@index');
Route::get('/contacts/{contact}', 'App\Http\Controllers\ContactsController@show');

// Post sends data to the server
Route::post('/contacts', 'App\Http\Controllers\ContactsController@store');

// Put replace the state of some data that already exists on the system
Route::put('/contacts/{contact}', 'App\Http\Controllers\ContactsController@update');

// Delete, deletes a resource (relative to the URI we have sent) on the system
Route::delete('/contacts/{contact}', 'App\Http\Controllers\ContactsController@destroy');