<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
/** routes para HourTemplate **/ 
 

            Route::group(
            [
            'prefix'     => 'HourTemplate',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\HourTemplate\IndexController::class, 'index'])
                    ->name('HourTemplate.index')
                    ->middleware('permission:HourTemplate.index');

                Route::post('create', [App\Http\Controllers\HourTemplate\CreateController::class, 'create'])
                    ->name('HourTemplate.create')
                    ->middleware('permission:HourTemplate.create');

                Route::delete('delete/{id}', [App\Http\Controllers\HourTemplate\DeleteController::class, 'destroy'])
                    ->name('HourTemplate.delete')
                    ->middleware('permission:HourTemplate.delete');

                Route::put('{id}', [App\Http\Controllers\HourTemplate\UpdateController::class, 'updated'])
                    ->name('HourTemplate.updated')
                    ->middleware('permission:HourTemplate.updated');

                Route::get('get', [App\Http\Controllers\HourTemplate\IndexController::class, 'get'])
                    ->name('HourTemplate.get')
                    ->middleware('permission:HourTemplate.getPaginate');
            }
        );
        