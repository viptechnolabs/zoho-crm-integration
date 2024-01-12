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

Route::prefix('')
    ->controller(ZohoController::class)
    ->group(function () {
        Route::get('generate-code', 'login')->name('login');
        Route::get('tokens', 'tokens')->name('tokens');
        Route::get('refresh', 'refreshToken')->name('refreshToken');
        Route::get('', 'list')->name('list');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('add-data', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
        Route::get('delete/{id}', 'delete')->name('delete');
    });
