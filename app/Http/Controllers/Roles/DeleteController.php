<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function destroy(Role $id)
    {    
        try {
            DB::beginTransaction();

            $id->delete();

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
}
