<?php

use App\Http\Controllers\NotificationController;
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
 
/** routes para ExtraGuest **/ 

            Route::group(
            [
            'prefix'     => 'ExtraGuest',
            'middleware'  => 'auth'
            ], function () {

                Route::get('', [App\Http\Controllers\ExtraGuest\IndexController::class, 'index'])
                    ->name('ExtraGuest.index')
                    ->middleware('permission:ExtraGuest.index');

                Route::post('create', [App\Http\Controllers\ExtraGuest\CreateController::class, 'create'])
                    ->name('ExtraGuest.create')
                    ->middleware('permission:ExtraGuest.create');

                Route::delete('delete/{ExtraGuest}', [App\Http\Controllers\ExtraGuest\DeleteController::class, 'destroy'])
                    ->name('ExtraGuest.delete')
                    ->middleware('permission:ExtraGuest.delete');

                Route::put('{ExtraGuest}', [App\Http\Controllers\ExtraGuest\UpdateController::class, 'updated'])
                    ->name('ExtraGuest.updated')
                    ->middleware('permission:ExtraGuest.updated');

                Route::get('get', [App\Http\Controllers\ExtraGuest\IndexController::class, 'get'])
                    ->name('ExtraGuest.get')
                    ->middleware('permission:ExtraGuest.getPaginate');
            }
        );
        