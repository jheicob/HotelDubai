<?php

namespace App\Http\Controllers\Configuracion\ThemeType;

use App\Http\Controllers\Controller;
use App\Models\ThemeType;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $ThemeType = ThemeType::where('id', $id)->withTrashed()->first();

            if (!$ThemeType->deleted_at) {
                $ThemeType->delete();
            } else {
                $ThemeType->restore();
            }

            DB::commit();

            return response()->json(Response::HTTP_OK);

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
            DB::rollBack();
            return response()->json(
                [
                'data' => [
                    'code'        => $ex->getCode(),
                    'title'       => __('errors.server.title'),
                    'description' => $ex->getMessage(),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
