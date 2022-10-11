<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/** routes para Client **/

Route::group(
    [
    'prefix'     => 'client',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Client\IndexController::class, 'index'])
            ->name('client.index')
            ->middleware('permission:client.index');

        Route::post('create', [App\Http\Controllers\Client\CreateController::class, 'create'])
            ->name('client.create')
            ->middleware('permission:client.create');

        Route::delete('delete/{client}', [App\Http\Controllers\Client\DeleteController::class, 'destroy'])
            ->name('client.delete')
            ->middleware('permission:client.delete');

        Route::put('{client}', [App\Http\Controllers\Client\UpdateController::class, 'updated'])
            ->name('client.updated')
            ->middleware('permission:client.updated');

        Route::get('get', [App\Http\Controllers\Client\IndexController::class, 'get'])
            ->name('client.get')
            // ->middleware('permission:client.getPaginate')
            ;

        Route::post('assigned_room', [App\Http\Controllers\Client\CreateController::class, 'assigned_room'])
            ->name('client.assigned_room')
            ->middleware('permission:client.assigned_room');
    }
);
