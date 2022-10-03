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

        Route::group(
            [
            'prefix'     => 'partial-templates',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Tarifas\PartialTemplate\IndexController::class, 'index'])
                    ->name('partial.templates.index')
                    ->middleware('permission:partial.templates.index');

                Route::post('create', [App\Http\Controllers\Tarifas\PartialTemplate\CreateController::class, 'create'])
                    ->name('partial.templates.create')
                    ->middleware('permission:partial.templates.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Tarifas\PartialTemplate\DeleteController::class, 'destroy'])
                    ->name('partial.templates.delete')
                    ->middleware('permission:partial.templates.delete');

                Route::put('{id}', [App\Http\Controllers\Tarifas\PartialTemplate\UpdatedController::class, 'updated'])
                    ->name('partial.templates.updated')
                    ->middleware('permission:partial.templates.updated');

                Route::get('get', [App\Http\Controllers\Tarifas\PartialTemplate\IndexController::class, 'get'])
                    ->name('partial.templates.get')
                    ->middleware('permission:partial.templates.getPaginate');
            }
        );

        Route::group(
            [
            'prefix'     => 'date-templates',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Tarifas\DateTemplate\IndexController::class, 'index'])
                    ->name('date.templates.index')
                    ->middleware('permission:date.templates.index');

                Route::post('create', [App\Http\Controllers\Tarifas\DateTemplate\CreateController::class, 'create'])
                    ->name('date.templates.create')
                    ->middleware('permission:date.templates.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Tarifas\DateTemplate\DeleteController::class, 'destroy'])
                    ->name('date.templates.delete')
                    ->middleware('permission:date.templates.delete');

                Route::put('{id}', [App\Http\Controllers\Tarifas\DateTemplate\UpdatedController::class, 'updated'])
                    ->name('date.templates.updated')
                    ->middleware('permission:date.templates.updated');

                Route::get('get', [App\Http\Controllers\Tarifas\DateTemplate\IndexController::class, 'get'])
                    ->name('date.templates.get')
                    ->middleware('permission:date.templates.getPaginate');
            }
        );

    }
);
