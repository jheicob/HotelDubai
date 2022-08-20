<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->createBrand($request);

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

    protected function createBrand($request)
    {
        $permission              = new Permission();
        $permission->name        = $request->name;
        $permission->save();
        return $permission->id;
    }
}
