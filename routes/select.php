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


Route::group([
    'prefix'     => 'permissions',
    'middleware'  => 'auth'
], function () {

    Route::get('get', [App\Http\Controllers\Permission\IndexController::class, 'get'])
        ->name('permissions.get');
});

Route::group([
    'prefix'     => 'roles',
    'middleware'  => 'auth'
], function () {

    Route::get('get', [App\Http\Controllers\Roles\IndexController::class, 'get'])
        ->name('roles.get');
});

Route::group([
    'prefix'     => 'users',
    'middleware'  => 'auth'
], function () {

    Route::get('get', [App\Http\Controllers\Users\IndexController::class, 'get'])
        ->name('roles.get');
});

Route::group([
    'prefix'     => 'logs',
    'middleware'  => 'auth'
], function () {

    Route::get('get', [App\Http\Controllers\Logs\IndexController::class, 'get'])
        ->name('logs.get')
        ->middleware('permission:logs.getPaginate');
});
