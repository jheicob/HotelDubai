<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\DayTemplate\CreateRequest;
use App\Models\DateTemplate;
use Illuminate\Support\Facades\DB;
use App\Models\DayTemplate;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            foreach($request->room_type_id as $room_type_id){
                foreach($request->day_week_id as $day_week_id){
                    $day_template = DayTemplate::create([
                        'room_type_id' => $room_type_id,
                        'day_week_id'  => $day_week_id,
                        'rate'         => $request->rate,
                        'partial_rate_id' => $request->partial_rate_id,
                        'hour_start'   => $request->hour_start,
                        'hour_end'     => $request->hour_end,
                    ]);
                }
            }
            // $daytemplate = DayTemplate::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch(ValidationException $ex){
            DB::rollBack();
            return response()->json(
                [
                'data' => [
                    'title'  => $ex->getMessage(),
                    'errors' => $ex->getMessage()
                ]
                ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }


}
