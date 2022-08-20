<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->createRol($request);

            DB::commit();

            return response()->json(Response::HTTP_OK);

        } catch (ValidationException $ex) {
            return response()->json([
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => collect($ex->errors())->flatten()
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => __('errors.server.description'),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function createRol($request)
    {
        $role              = new Role();
        $role->name        = $request->name;
        $role->save();
        return $role->id;
    }
}
