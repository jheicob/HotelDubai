<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/** routes para Client **/

Route::group(
    [
        'prefix'     => 'client',
        'middleware'  => 'auth'
    ],
    function () {

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

        Route::get('reception-ticket', [App\Http\Controllers\Client\CreateController::class, 'createTicket']);
        Route::post('assigned_room', [App\Http\Controllers\Client\CreateController::class, 'assigned_room'])
            ->name('client.assigned_room')
            ->middleware('permission:client.assigned_room');

        Route::get('{client}/extend-use', [App\Http\Controllers\Client\CreateController::class, 'extendUse'])
            ->name('client.extend.room.use')
            ->middleware('permission:client.assigned_room');

        Route::get('{client}/cancel-use', [App\Http\Controllers\Client\CreateController::class, 'CancelUse'])
            ->name('client.cancel.room.use')
            ->middleware('permission:client.cancel.room');

        Route::post('transfer-room', [App\Http\Controllers\Client\CreateController::class, 'transferRoom'])
            ->name('transfer.room')
            ->middleware('permission:client.assigned_room');

        Route::get('report', [App\Http\Controllers\Client\ReportController::class, 'report'])
            ->name('client.report')
            ->middleware('permission:client.report');
    }
);


/** routes para TypeDocument **/

Route::group(
    [
        'prefix'     => 'type-document',
        'middleware'  => 'auth'
    ],
    function () {

        // Route::get('', [App\Http\Controllers\TypeDocument\IndexController::class, 'index'])
        //     ->name('TypeDocument.index')
        //     ->middleware('permission:TypeDocument.index');

        // Route::post('create', [App\Http\Controllers\TypeDocument\CreateController::class, 'create'])
        //     ->name('TypeDocument.create')
        //     ->middleware('permission:TypeDocument.create');

        // Route::delete('delete/{TypeDocument}', [App\Http\Controllers\TypeDocument\DeleteController::class, 'destroy'])
        //     ->name('TypeDocument.delete')
        //     ->middleware('permission:TypeDocument.delete');

        // Route::put('{TypeDocument}', [App\Http\Controllers\TypeDocument\UpdateController::class, 'updated'])
        //     ->name('TypeDocument.updated')
        //     ->middleware('permission:TypeDocument.updated');

        Route::get('get', [App\Http\Controllers\TypeDocument\IndexController::class, 'get'])
            ->name('TypeDocument.get');
    }
);
