<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function get()
    {
        try {
            if(isAdmin()){
                $permissions = Permission::withTrashed()->get();
            }else{
                $permissions = Permission::all();
            }
            return PermissionResource::collection($permissions);
        } catch (ValidationException $ex) {
            return response()->json([
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $ex) {
            return response()->json([
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => __('errors.server.description'),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPaginate(Request $request)
    {
        try {
            $permissions = Permission::get();

            return PermissionResource::collection($permissions)->paginate($request->pag);
        } catch (ValidationException $ex) {
            return response()->json([
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $ex) {
            return response()->json([
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => __('errors.server.description'),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
