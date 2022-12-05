<?php

namespace App\Http\Controllers\Configuracion\EstateType;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use App\Models\EstateType;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('EstateType.index');
    }

    public function getPublic(){
        try {
                $permissions = EstateType::all();
            return RoomTypeResource::collection($permissions);
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

    public function get()
    {
        try {
            $role = \Illuminate\Support\Facades\Auth::user()->roles->first();

            if($role->name != 'Admin'){
                $rol = \App\Models\Role::find($role->id);

                $permissions = $rol->estateTypes;
            }else{

            $permissions = EstateType::withTrashed()->get();
            }

            return RoomTypeResource::collection($permissions);
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
