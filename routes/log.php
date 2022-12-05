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
    'prefix'     => 'logs',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Logs\IndexController::class, 'index'])
            ->name('logs.index')
            ->middleware('permission:logs.index');

        Route::get('getPaginate', [App\Http\Controllers\Logs\IndexController::class, 'getPaginate'])
            ->middleware('permission:logs.index');

    }
);
