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
/*Route::prefix('')
    ->controller(ContactController::class)
    ->group(function () {
        Route::get('', 'listContacts')->name('index');
        Route::get('add', 'add')->name('index');
        Route::post('submit', 'addContact')->name('submit');
        Route::get('token', 'token')->name('token');
    });*/

Route::prefix('')
    ->controller(ZohoController::class)
    ->group(function () {
        Route::get('generate-code', 'login')->name('login');
        Route::get('tokens', 'tokens')->name('tokens');
        Route::get('refresh', 'refreshToken')->name('refreshToken');
        Route::get('list', 'list')->name('list');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('add-data', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
    });


/*Route::get('/generate-code',[ZohoController::class,'login'])->name("login");
Route::get('/tokens',[ZohoController::class,'tokens'])->name("tokens");
Route::get('/refresh',[ZohoController::class,'refreshToken'])->name("refreshToken");
Route::get('/list',[ZohoController::class,'list'])->name("list");
Route::get('/store',[ZohoController::class,'store'])->name("store");*/
