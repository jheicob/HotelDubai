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

Route::group(
    [
    'prefix'     => 'profile',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Profile\IndexController::class, 'index'])
            ->name('profile.index');

        Route::get('get', [App\Http\Controllers\Profile\IndexController::class, 'get']);

        Route::put('update', [App\Http\Controllers\Profile\UpdatedController::class, 'updated']);


        Route::group(
            [
            'prefix'     => 'password',
            'middleware'  => 'auth'
            ], function () {

                Route::view('', 'password.index')->name('password.index');

                Route::put('update', [App\Http\Controllers\Profile\PasswordController::class, 'updated']);

            }
        );
    }
);
