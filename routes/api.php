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
 
/** routes para Client **/ 

            Route::group(
            [
            'prefix'     => 'Client',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\Client\IndexController::class, 'index'])
                    ->name('Client.index')
                    ->middleware('permission:Client.index');

                Route::post('create', [App\Http\Controllers\Client\CreateController::class, 'create'])
                    ->name('Client.create')
                    ->middleware('permission:Client.create');

                Route::delete('delete/{Client}', [App\Http\Controllers\Client\DeleteController::class, 'destroy'])
                    ->name('Client.delete')
                    ->middleware('permission:Client.delete');

                Route::put('{Client}', [App\Http\Controllers\Client\UpdateController::class, 'updated'])
                    ->name('Client.updated')
                    ->middleware('permission:Client.updated');

                Route::get('get', [App\Http\Controllers\Client\IndexController::class, 'get'])
                    ->name('Client.get')
                    ->middleware('permission:Client.getPaginate');
            }
        );
        