<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ZohoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

// Contact
Route::prefix('')
    ->controller(ContactController::class)
    ->group(function () {
        Route::get('', 'listContacts')->name('index');
        Route::get('add', 'add')->name('index');
        Route::post('submit', 'addContact')->name('submit');
        Route::get('token', 'token')->name('token');
    });


