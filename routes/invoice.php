<?php

use Illuminate\Support\Facades\Route;


/** routes para Invoice **/

Route::group(
    [
        'prefix'     => 'invoice',
        'middleware'  => 'auth'
    ],
    function () {

        Route::get('printFiscal/{invoice}', [App\Http\Controllers\Invoice\CreateController::class, 'printFiscal'])
            ->name('invoice.printFiscal')
            ->middleware('permission:invoice.printFiscal');

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

        Route::get('report-X', [App\Http\Controllers\Invoice\CreateController::class, 'reportX'])
            ->name('invoice.report.x')
            ->middleware('permission:invoice.getPaginate');
 
        Route::get('report-Z', [App\Http\Controllers\Invoice\CreateController::class, 'reportZ'])
            ->name('invoice.report.z')
            ->middleware('permission:invoice.getPaginate');
/** routes para Product **/ 

            Route::group(
            [
            'prefix'     => 'Product',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Product\IndexController::class, 'index'])
                    ->name('Product.index')
                    ->middleware('permission:product.index');

                Route::post('create', [App\Http\Controllers\Product\CreateController::class, 'create'])
                    ->name('Product.create')
                    ->middleware('permission:product.create');

                Route::delete('delete/{product}', [App\Http\Controllers\Product\DeleteController::class, 'destroy'])
                    ->name('Product.delete')
                    ->middleware('permission:product.delete');

                Route::put('{product}', [App\Http\Controllers\Product\UpdateController::class, 'updated'])
                    ->name('Product.updated')
                    ->middleware('permission:product.updated');

                Route::get('get', [App\Http\Controllers\Product\IndexController::class, 'get'])
                    ->name('Product.get')
                    ->middleware('permission:product.getPaginate');
            }
        );
 
    }
);

