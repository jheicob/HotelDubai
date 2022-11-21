<?php

use Illuminate\Support\Facades\Route;


/** routes para Room **/

Route::group(
    [
        'prefix'     => 'room',
        'middleware'  => 'auth'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Room\IndexController::class, 'index'])
            ->name('room.index')
            ->middleware('permission:room.index');

        Route::get('report', [App\Http\Controllers\Room\CreateController::class, 'report'])
            ->name('room.report')
            ->middleware('permission:room.index');

        Route::post('create', [App\Http\Controllers\Room\CreateController::class, 'create'])
            ->name('room.create')
            ->middleware('permission:room.create');

        Route::delete('delete/{room}', [App\Http\Controllers\Room\DeleteController::class, 'destroy'])
            ->name('room.delete')
            ->middleware('permission:room.delete');


        Route::post('{room}/change-status', [App\Http\Controllers\Room\UpdateController::class, 'changeStatus'])
            ->name('room.change.status')
            ->middleware('permission:room.updated');


        Route::get('get', [App\Http\Controllers\Room\IndexController::class, 'get'])
            ->name('room.get')
            ->middleware('permission:room.getPaginate');

        Route::put('repair', [App\Http\Controllers\Room\UpdateController::class, 'repair'])
            ->name('room.repair')
            ->middleware('permission:room.free');

        Route::put('{room}', [App\Http\Controllers\Room\UpdateController::class, 'updated'])
            ->name('room.updated');
    }
);


/** routes para Repair **/

Route::group(
    [
        'prefix'     => 'repair',
        'middleware'  => 'auth'
    ],
    function () {

        Route::get('', [App\Http\Controllers\Repair\IndexController::class, 'index'])
            ->name('repair.index')
            ->middleware('permission:repair.index');

        Route::post('create', [App\Http\Controllers\Repair\CreateController::class, 'create'])
            ->name('repair.create')
            ->middleware('permission:repair.create');

        Route::delete('delete/{repair}', [App\Http\Controllers\Repair\DeleteController::class, 'destroy'])
            ->name('repair.delete')
            ->middleware('permission:repair.delete');

        Route::put('{repair}', [App\Http\Controllers\Repair\UpdateController::class, 'updated'])
            ->name('repair.updated')
            ->middleware('permission:repair.updated');

        Route::get('get', [App\Http\Controllers\Repair\IndexController::class, 'get'])
            ->name('repair.get')
            ->middleware('permission:repair.getPaginate');
    }
);
