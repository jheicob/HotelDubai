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

        Route::group(
            [
            'prefix'     => 'theme-type',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Configuracion\ThemeType\IndexController::class, 'index'])
                    ->name('theme.type.index')
                    ->middleware('permission:theme.type.index');

                Route::post('create', [App\Http\Controllers\Configuracion\ThemeType\CreateController::class, 'create'])
                    ->name('theme.type.create')
                    ->middleware('permission:theme.type.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\ThemeType\DeleteController::class, 'destroy'])
                    ->name('theme.type.delete')
                    ->middleware('permission:theme.type.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\ThemeType\UpdatedController::class, 'updated'])
                    ->name('theme.type.updated')
                    ->middleware('permission:theme.type.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\ThemeType\IndexController::class, 'get'])
                    ->name('theme.type.get')
                    ->middleware('permission:theme.type.getPaginate');
            }
        );

        Route::group(
            [
            'prefix'     => 'estate-type',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Configuracion\EstateType\IndexController::class, 'index'])
                    ->name('estate.type.index')
                    ->middleware('permission:estate.type.index');

                Route::post('create', [App\Http\Controllers\Configuracion\EstateType\CreateController::class, 'create'])
                    ->name('estate.type.create')
                    ->middleware('permission:estate.type.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\EstateType\DeleteController::class, 'destroy'])
                    ->name('estate.type.delete')
                    ->middleware('permission:estate.type.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\EstateType\UpdatedController::class, 'updated'])
                    ->name('estate.type.updated')
                    ->middleware('permission:estate.type.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\EstateType\IndexController::class, 'get'])
                    ->name('estate.type.get')
                    ->middleware('permission:estate.type.getPaginate');
            }
        );

        Route::group(
            [
            'prefix'     => 'partial-rates',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Configuracion\PartialRates\IndexController::class, 'index'])
                    ->name('partial.rates.index')
                    ->middleware('permission:partial.rates.index');

                Route::post('create', [App\Http\Controllers\Configuracion\PartialRates\CreateController::class, 'create'])
                    ->name('partial.rates.create')
                    ->middleware('permission:partial.rates.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\PartialRates\DeleteController::class, 'destroy'])
                    ->name('partial.rates.delete')
                    ->middleware('permission:partial.rates.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\PartialRates\UpdatedController::class, 'updated'])
                    ->name('partial.rates.updated')
                    ->middleware('permission:partial.rates.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\PartialRates\IndexController::class, 'get'])
                    ->name('partial.rates.get')
                    ->middleware('permission:partial.rates.getPaginate');
            }
        );
    }
);
