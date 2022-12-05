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
    ],
    function () {

        Route::group(
            [
                'prefix'     => 'partial-cost',
                'middleware'  => 'auth'
            ],
            function () {

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

                Route::post('multiupdate', [App\Http\Controllers\Tarifas\PartialCost\UpdatedController::class, 'multiupdate'])
                    ->name('partial.cost.multiupdate')
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
            ],
            function () {

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
            ],
            function () {

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

        /** routes para HourTemplate **/
        Route::group(
            [
                'prefix'     => 'hour-templates',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Tarifas\HourTemplate\IndexController::class, 'index'])
                    ->name('hour.templates.index')
                    ->middleware('permission:hour.templates.index');

                Route::post('create', [App\Http\Controllers\Tarifas\HourTemplate\CreateController::class, 'create'])
                    ->name('hour.templates.create')
                    ->middleware('permission:hour.templates.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Tarifas\HourTemplate\DeleteController::class, 'destroy'])
                    ->name('hour.templates.delete')
                    ->middleware('permission:hour.templates.delete');

                Route::put('{id}', [App\Http\Controllers\Tarifas\HourTemplate\UpdateController::class, 'updated'])
                    ->name('hour.templates.updated')
                    ->middleware('permission:hour.templates.updated');

                Route::get('get', [App\Http\Controllers\Tarifas\HourTemplate\IndexController::class, 'get'])
                    ->name('hour.templates.get')
                    ->middleware('permission:hour.templates.getPaginate');
            }
        );


        /** routes para DayTemplate **/

        Route::group(
            [
                'prefix'     => 'day-templates',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Tarifas\DayTemplate\IndexController::class, 'index'])
                    ->name('day.templates.index')
                    ->middleware('permission:day.templates.index');

                Route::post('create', [App\Http\Controllers\Tarifas\DayTemplate\CreateController::class, 'create'])
                    ->name('day.templates.create')
                    ->middleware('permission:day.templates.create');

                Route::delete('delete/{daytemplate}', [App\Http\Controllers\Tarifas\DayTemplate\DeleteController::class, 'destroy'])
                    ->name('day.templates.delete')
                    ->middleware('permission:day.templates.delete');

                Route::put('{daytemplate}', [App\Http\Controllers\Tarifas\DayTemplate\UpdateController::class, 'updated'])
                    ->name('day.templates.updated')
                    ->middleware('permission:day.templates.updated');

                Route::get('get', [App\Http\Controllers\Tarifas\DayTemplate\IndexController::class, 'get'])
                    ->name('day.templates.get')
                    ->middleware('permission:day.templates.getPaginate');
            }
        );


        /** routes para RangeTemplate **/

        Route::group(
            [
                'prefix'     => 'RangeTemplate',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\RangeTemplate\IndexController::class, 'index'])
                    ->name('range.template.index')
                    ->middleware('permission:range.template.index');

                Route::post('create', [App\Http\Controllers\RangeTemplate\CreateController::class, 'create'])
                    ->name('range.template.create')
                    ->middleware('permission:range.template.create');

                Route::delete('delete/{id}', [App\Http\Controllers\RangeTemplate\DeleteController::class, 'destroy'])
                    ->name('range.template.delete')
                    ->middleware('permission:range.template.delete');

                Route::put('{rangetemplate}', [App\Http\Controllers\RangeTemplate\UpdateController::class, 'updated'])
                    ->name('range.template.updated')
                    ->middleware('permission:range.template.updated');

                Route::get('get', [App\Http\Controllers\RangeTemplate\IndexController::class, 'get'])
                    ->name('range.template.get')
                    ->middleware('permission:range.template.getPaginate');
            }
        );
    }
);
