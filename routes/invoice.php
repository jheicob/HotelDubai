<?php
use Illuminate\Support\Facades\Route;


/** routes para Invoice **/

Route::group(
    [
    'prefix'     => 'invoice',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\Invoice\IndexController::class, 'index'])
            ->name('invoice.index')
            ->middleware('permission:invoice.index');

        Route::post('create', [App\Http\Controllers\Invoice\CreateController::class, 'create'])
            ->name('invoice.create')
            ->middleware('permission:invoice.create');

        Route::delete('delete/{invoice}', [App\Http\Controllers\Invoice\DeleteController::class, 'destroy'])
            ->name('invoice.delete')
            ->middleware('permission:invoice.delete');

        Route::put('{invoice}', [App\Http\Controllers\Invoice\UpdateController::class, 'updated'])
            ->name('invoice.updated')
            ->middleware('permission:invoice.updated');

        Route::get('get', [App\Http\Controllers\Invoice\IndexController::class, 'get'])
            ->name('invoice.get')
            ->middleware('permission:invoice.getPaginate');
    }
);
