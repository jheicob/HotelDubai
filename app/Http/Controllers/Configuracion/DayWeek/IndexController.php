<?php

namespace App\Http\Controllers\Configuracion\DayWeek;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\DayWeek;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('DayWeek.index');
    }

    public function get()
    {
        try {
            if(isAdmin()){
                $permissions = DayWeek::withTrashed()->get();
            }else{
                $permissions = DayWeek::all();
            }
            return RoomTypeResource::collection($permissions);
        } catch (ValidationException $ex) {
            return response()->json(
                [
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $ex) {
            return response()->json(
                [
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => __('errors.server.description'),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
