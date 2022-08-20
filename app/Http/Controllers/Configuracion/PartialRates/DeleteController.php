<?php

namespace App\Http\Controllers\Configuracion\PartialRates;

use App\Http\Controllers\Controller;
use App\Models\PartialRates;
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

            $PartialRates = PartialRates::where('id', $id)->withTrashed()->first();

            if (!$PartialRates->deleted_at) {
                $PartialRates->delete();
            } else {
                $PartialRates->restore();
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
