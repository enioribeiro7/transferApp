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


//User Routes
Route::get('/get/users', 'UserController@getUsers')->name('getUsers');

//Route::post('/insert/new/user', 'UserController@insertNewUser')->name('insertNewUser');


//Transfer Routes
Route::post('/transfer/action', 'TransferController@transferAction')->name('transferAction');