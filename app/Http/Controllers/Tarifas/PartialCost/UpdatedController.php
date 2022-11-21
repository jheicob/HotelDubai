<?php

namespace App\Http\Controllers\Tarifas\PartialCost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\PartialCost\MultiupdateRequest;
use App\Models\PartialCost;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UpdatedController extends Controller
{
    public function updated(Request $request,PartialCost $id)
    {
        try {
            DB::beginTransaction();

            $id->update($request->all());

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
                    'description' => __('errors.server.description'),
                ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function multiupdate(MultiupdateRequest $request){
        try{
            DB::beginTransaction();

            $new = [];
            foreach($request->room_types as $room_type){
                foreach($request->partial_rates as $partial_rate){
                    PartialCost::updateOrCreate([
                        'room_type_id' => $room_type,
                        'partial_rates_id' => $partial_rate
                    ],['rate' => $request->rate]);
                }
            }
            DB::commit();
            return Response::HTTP_OK;
        }catch (\Exception $e){
            DB::rollBack();
            return custom_response_exception($e,'Server Error');
        }
    }
}
