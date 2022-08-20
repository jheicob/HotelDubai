<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\RolResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class IndexController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }
    
    public function get()
    {
        try {
            $role = Role::with('permissions')->get();

            return RolResource::collection($role);
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
            $permissions = Role::with('permissions')->get();

            return RolResource::collection($permissions)->paginate($request->pag);
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
