<?php

namespace App\Http\Controllers\Configuracion\RoomStatus;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomStatusResource;
use App\Models\RoomStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function index()
    {
        return view('RoomStatus.index');
    }

    private function isCamarero()
    {
        $role = Auth::user()->roles->first();

        return $role->name == 'Camarero';
    }

    private function isMantenimiento()
    {
        $role = Auth::user()->roles->first();

        return $role->name == 'Mantenimiento';
    }
    public function get()
    {
        try {
            $permissions = RoomStatus::withTrashed()
                ->when(self::isCamarero() || self::isMantenimiento(), function (Builder $query) {
                    return $query->where('name', '<>', 'Ocupada');
                })
                // ->when(self::isMantenimiento(), function (Builder $query) {
                //     return $query->where('name', 'Disponible')
                //         ->orWhere('name', 'Mantenimiento');
                // })
                ->get();

            return RoomStatusResource::collection($permissions);
        } catch (ValidationException $ex) {
            return response()->json(
                [
                    'data' => [
                        'title'  => $ex->getMessage(),
                        'errors' => collect($ex->errors())->flatten()
                    ]
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $ex) {
            return response()->json(
                [
                    'data' => [
                        'code'        => $ex->getCode(),
                        'title'       => __('errors.server.title'),
                        'description' => __('errors.server.description'),
                    ]
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
