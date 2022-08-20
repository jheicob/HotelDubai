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
    'prefix'     => 'permissions',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Permission\IndexController::class, 'index'])
            ->name('permissions.index')
            ->middleware('permission:permissions.index');

        Route::post('create', [App\Http\Controllers\Permission\CreateController::class, 'create'])
            ->name('permissions.create')
            ->middleware('permission:permissions.create');

        Route::delete('delete/{id}', [App\Http\Controllers\Permission\DeleteController::class, 'destroy'])
            ->name('permissions.delete')
            ->middleware('permission:permissions.delete');

        Route::put('{id}', [App\Http\Controllers\Permission\UpdatedController::class, 'updated'])
            ->name('permissions.updated')
            ->middleware('permission:permissions.updated');

        Route::get('getPaginate', [App\Http\Controllers\Permission\IndexController::class, 'getPaginate'])
            ->name('permissions.getPaginate')
            ->middleware('permission:permissions.getPaginate');

    }
);

