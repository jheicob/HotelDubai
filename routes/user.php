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
    'prefix'     => 'users',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Users\IndexController::class, 'index'])
            ->name('users.index')
            ->middleware('permission:users.index');

        Route::post('create', [App\Http\Controllers\Users\CreateController::class, 'create'])
            ->name('users.create')
            ->middleware('permission:users.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Users\DeleteController::class, 'destroy'])
            ->name('users.delete')
            ->middleware('permission:users.delete');

        Route::put('{id}', [App\Http\Controllers\Users\UpdatedController::class, 'updated'])
            ->name('users.updated')
            ->middleware('permission:users.updated');

        Route::get('getPaginate', [App\Http\Controllers\Users\IndexController::class, 'getPaginate'])
            ->name('users.getPaginate')
            ->middleware('permission:users.getPaginate');
    }
);
