<?php

namespace App\Http\Controllers\Tarifas\PartialTemplate;

use App\Http\Controllers\Controller;
use App\Models\PartialTemplate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->createPartialTemplate($request);

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

    protected function createPartialTemplate($request)
    {
        $PartialTemplate                   = new PartialTemplate();
        $PartialTemplate->room_type_id     = $request->room_type_id;
        $PartialTemplate->day_week_id      = $request->day_week_id;
        $PartialTemplate->system_time_id   = $request->system_time_id;
        $PartialTemplate->shift_system_id  = $request->shift_system_id;
        $PartialTemplate->partial_rates_id = $request->partial_rates_id;
        $PartialTemplate->save();
        return $PartialTemplate->id;
    }
}



