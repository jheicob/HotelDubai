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
    'prefix'     => 'configuracion',
    'middleware'  => 'auth'
    ], function () {

        Route::group(
            [
            'prefix'     => 'room-type',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Configuracion\RoomType\IndexController::class, 'index'])
                    ->name('room.type.index')
                    ->middleware('permission:room.type.index');

                Route::post('create', [App\Http\Controllers\Configuracion\RoomType\CreateController::class, 'create'])
                    ->name('room.type.create')
                    ->middleware('permission:room.type.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\RoomType\DeleteController::class, 'destroy'])
                    ->name('room.type.delete')
                    ->middleware('permission:room.type.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\RoomType\UpdatedController::class, 'updated'])
                    ->name('room.type.updated')
                    ->middleware('permission:room.type.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\RoomType\IndexController::class, 'get'])
                    ->name('room.type.get')
                    ->middleware('permission:room.type.getPaginate');
            }
        );
    }
);
