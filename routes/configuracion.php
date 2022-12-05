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

Route::get('configuration/EstateType', [App\Http\Controllers\Configuracion\EstateType\IndexController::class, 'getPublic'])
->name('estate.type.get');
Route::get('configuration/fiscal-machines', [App\Http\Controllers\FiscalMachines\IndexController::class, 'getPublic'])
    ->name('FiscalMachines.index');
Route::group(
    [
        'prefix'     => 'configuracion',
        'middleware'  => 'auth'
    ],
    function () {

        Route::group(
            [
                'prefix'     => 'room-type',
                'middleware'  => 'auth'
            ],
            function () {

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
            ],
            function () {

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
            ],
            function () {

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
            ],
            function () {

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

        Route::group(
            [
                'prefix'     => 'room-status',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Configuracion\RoomStatus\IndexController::class, 'index'])
                    ->name('room.status.index')
                    ->middleware('permission:room.status.index');

                Route::post('create', [App\Http\Controllers\Configuracion\RoomStatus\CreateController::class, 'create'])
                    ->name('room.status.create')
                    ->middleware('permission:room.status.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\RoomStatus\DeleteController::class, 'destroy'])
                    ->name('room.status.delete')
                    ->middleware('permission:room.status.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\RoomStatus\UpdatedController::class, 'updated'])
                    ->name('room.status.updated')
                    ->middleware('permission:room.status.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\RoomStatus\IndexController::class, 'get'])
                    ->name('room.status.get')
                    ->middleware('permission:room.status.getPaginate');
            }
        );

        Route::group(
            [
                'prefix'     => 'day-week',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Configuracion\DayWeek\IndexController::class, 'index'])
                    ->name('day.week.index')
                    ->middleware('permission:day.week.index');

                Route::post('create', [App\Http\Controllers\Configuracion\DayWeek\CreateController::class, 'create'])
                    ->name('day.week.create')
                    ->middleware('permission:day.week.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\DayWeek\DeleteController::class, 'destroy'])
                    ->name('day.week.delete')
                    ->middleware('permission:day.week.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\DayWeek\UpdatedController::class, 'updated'])
                    ->name('day.week.updated')
                    ->middleware('permission:day.week.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\DayWeek\IndexController::class, 'get'])
                    ->name('day.week.get')
                    ->middleware('permission:day.week.getPaginate');
            }
        );

        Route::group(
            [
                'prefix'     => 'system-time',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Configuracion\SystemTime\IndexController::class, 'index'])
                    ->name('system.time.index')
                    ->middleware('permission:system.time.index');

                Route::post('create', [App\Http\Controllers\Configuracion\SystemTime\CreateController::class, 'create'])
                    ->name('system.time.create')
                    ->middleware('permission:system.time.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\SystemTime\DeleteController::class, 'destroy'])
                    ->name('system.time.delete')
                    ->middleware('permission:system.time.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\SystemTime\UpdatedController::class, 'updated'])
                    ->name('system.time.updated')
                    ->middleware('permission:system.time.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\SystemTime\IndexController::class, 'get'])
                    ->name('system.time.get')
                    ->middleware('permission:system.time.getPaginate');
            }
        );

        Route::group(
            [
                'prefix'     => 'shift-system',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\Configuracion\ShiftSystem\IndexController::class, 'index'])
                    ->name('shift.system.index')
                    ->middleware('permission:shift.system.index');

                Route::post('create', [App\Http\Controllers\Configuracion\ShiftSystem\CreateController::class, 'create'])
                    ->name('shift.system.create')
                    ->middleware('permission:shift.system.create');

                Route::delete('delete/{id}', [App\Http\Controllers\Configuracion\ShiftSystem\DeleteController::class, 'destroy'])
                    ->name('shift.system.delete')
                    ->middleware('permission:shift.system.delete');

                Route::put('{id}', [App\Http\Controllers\Configuracion\ShiftSystem\UpdatedController::class, 'updated'])
                    ->name('shift.system.updated')
                    ->middleware('permission:shift.system.updated');

                Route::get('get', [App\Http\Controllers\Configuracion\ShiftSystem\IndexController::class, 'get'])
                    ->name('shift.system.get')
                    ->middleware('permission:shift.system.getPaginate');
            }
        );


        /** routes para ExtraGuest **/

        Route::group(
            [
                'prefix'     => 'ExtraGuest',
                'middleware'  => 'auth'
            ],
            function () {

                Route::get('', [App\Http\Controllers\ExtraGuest\IndexController::class, 'index'])
                    ->name('ExtraGuest.index')
                    ->middleware('permission:extra-guest.index');

                Route::post('create', [App\Http\Controllers\ExtraGuest\CreateController::class, 'create'])
                    ->name('ExtraGuest.create')
                    ->middleware('permission:extra-guest.create');

                Route::delete('delete/{id}', [App\Http\Controllers\ExtraGuest\DeleteController::class, 'destroy'])
                    ->name('ExtraGuest.delete')
                    ->middleware('permission:extra-guest.delete');

                Route::put('{extraguest}', [App\Http\Controllers\ExtraGuest\UpdateController::class, 'updated'])
                    ->name('ExtraGuest.updated')
                    ->middleware('permission:extra-guest.updated');

                Route::get('get', [App\Http\Controllers\ExtraGuest\IndexController::class, 'get'])
                    ->name('ExtraGuest.get')
                    ->middleware('permission:extra-guest.getPaginate');
            }
        );


/** routes para FiscalMachines **/

Route::group(
    [
    'prefix'     => 'FiscalMachines',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\FiscalMachines\IndexController::class, 'index'])
            ->name('FiscalMachines.index')
            ->middleware('permission:FiscalMachines.index');

        Route::post('create', [App\Http\Controllers\FiscalMachines\CreateController::class, 'create'])
            ->name('FiscalMachines.create')
            ->middleware('permission:FiscalMachines.create');

        Route::delete('delete/{id}', [App\Http\Controllers\FiscalMachines\DeleteController::class, 'destroy'])
            ->name('FiscalMachines.delete')
            ->middleware('permission:FiscalMachines.delete');

        Route::put('{FiscalMachines}', [App\Http\Controllers\FiscalMachines\UpdateController::class, 'updated'])
            ->name('FiscalMachines.updated')
            ->middleware('permission:FiscalMachines.updated');

        Route::get('get', [App\Http\Controllers\FiscalMachines\IndexController::class, 'get'])
            ->name('FiscalMachines.get')
            ->middleware('permission:FiscalMachines.getPaginate');
    }
);


/** routes para ProductCategory **/
Route::group(
    [
    'prefix'     => 'ProductCategory',
    'middleware'  => 'auth'
    ], function () {

        Route::get('', [App\Http\Controllers\ProductCategory\IndexController::class, 'index'])
            ->name('ProductCategory.index')
            ->middleware('permission:ProductCategory.index');

        Route::post('create', [App\Http\Controllers\ProductCategory\CreateController::class, 'create'])
            ->name('ProductCategory.create')
            ->middleware('permission:ProductCategory.create');

        Route::delete('delete/{ProductCategory}', [App\Http\Controllers\ProductCategory\DeleteController::class, 'destroy'])
            ->name('ProductCategory.delete')
            ->middleware('permission:ProductCategory.delete');

        Route::put('{ProductCategory}', [App\Http\Controllers\ProductCategory\UpdateController::class, 'updated'])
            ->name('ProductCategory.updated')
            ->middleware('permission:ProductCategory.updated');

        Route::get('get', [App\Http\Controllers\ProductCategory\IndexController::class, 'get'])
            ->name('ProductCategory.get')
            ->middleware('permission:ProductCategory.getPaginate');
    }
);

        Route::get('', [App\Http\Controllers\Configuracion\ConfigurationController::class, 'view'])
            ->name('configuration.index')
            ->middleware('permission:configuration.index');
        Route::get('get', [App\Http\Controllers\Configuracion\ConfigurationController::class, 'index'])
            ->name('configuration.getPaginate')
            ->middleware('permission:configuration.getPaginate');
        Route::post('', [App\Http\Controllers\Configuracion\ConfigurationController::class, 'upSert'])
            ->name('configuration.upsert')
            ->middleware('permission:configuration.upsert');
    }
);
