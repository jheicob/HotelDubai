<?php

use Illuminate\Support\Facades\Route;


/** routes para Room **/

Route::group(
    [
    'prefix'     => 'room',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Room\IndexController::class, 'index'])
            ->name('room.index')
            ->middleware('permission:room.index');

        Route::post('create', [App\Http\Controllers\Room\CreateController::class, 'create'])
            ->name('room.create')
            ->middleware('permission:room.create');

        Route::delete('delete/{room}', [App\Http\Controllers\Room\DeleteController::class, 'destroy'])
            ->name('room.delete')
            ->middleware('permission:room.delete');

        Route::put('{room}', [App\Http\Controllers\Room\UpdateController::class, 'updated'])
            ->name('room.updated')
            ->middleware('permission:room.updated');

        Route::get('get', [App\Http\Controllers\Room\IndexController::class, 'get'])
            ->name('room.get')
            ->middleware('permission:room.getPaginate');
    }
);
