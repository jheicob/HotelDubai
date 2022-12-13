<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function get()
    {
        try {
            $users = User::with([
                'roles.permissions',
                'fiscalMachine'
            ]);
            if(isAdmin()){
                $users = $users->withTrashed();
            }
            $users = $users->get();

            return UserResource::collection($users);
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

    public function getPaginate(Request $request)
    {
        try {
            $users = User::with(['roles.permissions','fiscalMachine'])
                ->OrderBy('id', 'DESC')
                ->withTrashed()
                ->paginate($request->input('pag'));

            return UserResource::collection($users);
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
