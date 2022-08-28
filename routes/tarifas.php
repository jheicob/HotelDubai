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
    'prefix'     => 'tarifas',
    'middleware'  => 'auth'
    ], function () {

        Route::group(
            [
            'prefix'     => 'partial-cost',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Tarifas\PartialCost\IndexController::class, 'index'])
                    ->name('partial.cost.index')
                    ->middleware('permission:partial.cost.index');

                Route::post('create', [App\Http\Controllers\Tarifas\PartialCost\CreateController::class, 'create'])
                    ->name('partial.cost.create')
                    ->middleware('permission:partial.cost.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Tarifas\PartialCost\DeleteController::class, 'destroy'])
                    ->name('partial.cost.delete')
                    ->middleware('permission:partial.cost.delete');

                Route::put('{id}', [App\Http\Controllers\Tarifas\PartialCost\UpdatedController::class, 'updated'])
                    ->name('partial.cost.updated')
                    ->middleware('permission:partial.cost.updated');

                Route::get('get', [App\Http\Controllers\Tarifas\PartialCost\IndexController::class, 'get'])
                    ->name('partial.cost.get')
                    ->middleware('permission:partial.cost.getPaginate');
            }
        );

    }
);
