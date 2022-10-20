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

/** routes para PaymentType **/

            Route::group(
            [
            'prefix'     => 'PaymentType',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\PaymentType\IndexController::class, 'index'])
                    ->name('PaymentType.index')
                    ->middleware('permission:PaymentType.index');

                Route::post('create', [App\Http\Controllers\PaymentType\CreateController::class, 'create'])
                    ->name('PaymentType.create')
                    ->middleware('permission:PaymentType.create');

                Route::delete('delete/{PaymentType}', [App\Http\Controllers\PaymentType\DeleteController::class, 'destroy'])
                    ->name('PaymentType.delete')
                    ->middleware('permission:PaymentType.delete');

                Route::put('{PaymentType}', [App\Http\Controllers\PaymentType\UpdateController::class, 'updated'])
                    ->name('PaymentType.updated')
                    ->middleware('permission:PaymentType.updated');

                Route::get('get', [App\Http\Controllers\PaymentType\IndexController::class, 'get'])
                    ->name('PaymentType.get')
                    ->middleware('permission:PaymentType.getPaginate');
            }
        );

