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
    'prefix'     => 'roles',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Roles\IndexController::class, 'index'])
            ->name('roles.index')
            ->middleware('permission:roles.index');


        Route::post('create', [App\Http\Controllers\Roles\CreateController::class, 'create'])
            ->name('roles.create')
            ->middleware('permission:roles.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Roles\DeleteController::class, 'destroy'])
            ->name('roles.delete')
            ->middleware('permission:roles.delete');

        Route::put('{id}', [App\Http\Controllers\Roles\UpdatedController::class, 'updated'])
            ->name('roles.updated')
            ->middleware('permission:roles.updated');

        Route::get('getPaginate', [App\Http\Controllers\Roles\IndexController::class, 'getPaginate'])
            ->name('roles.getPaginate')
            ->middleware('permission:roles.getPaginate');
    }
);
