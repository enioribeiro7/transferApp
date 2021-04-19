<?php

use App\Mail\NotificationTransferSentMail;
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



//Test Mail Route
Route::get('/email/notification', function(){

    $user = new \stdClass();
    $user->email = 'enio7.ribeiro@gmail.com';
    $user->from = 'Enio Ribero';
    $user->to = 'Jose Marques';
    $user->amount = '150,00';

    //return new NotificationTransferSentMail($user);

    //\Illuminate\Support\Facades\Mail::send(new NotificationTransferSentMail($user));

});

Route::post('/insert/new/user', 'UserController@insertNewUser')->name('insertNewUser');
