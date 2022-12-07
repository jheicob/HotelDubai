<?php

namespace App\Http\Controllers\Tarifas\DayTemplate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tarifas\DayTemplate\CreateRequest;
use App\Models\DateTemplate;
use Illuminate\Support\Facades\DB;
use App\Models\DayTemplate;
class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            foreach($request->room_type_id as $room_type_id){
                foreach($request->day_week_id as $day_week_id){
                    self::verifyHoursRange($room_type_id,$day_week_id,$request->hour_start,$request->hour_end);
                    $day_template = DayTemplate::create([
                        'room_type_id' => $room_type_id,
                        'day_week_id'  => $day_week_id,
                        'rate'         => $request->rate,
                        'hour_start'   => $request->hour_start,
                        'hour_end'     => $request->hour_end,
                    ]);
                }
            }
            // $daytemplate = DayTemplate::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

    private function verifyHoursRange(int $room_type_id,int $day_week_id,string $start,string $end):void
    {
        $date_templates = DayTemplate::where([
                        ['room_type_id' , $room_type_id],
                        ['day_week_id'  , $day_week_id],
                        // ['hour_start'   , $start],
                        // ['hour_end'     , $end],
                    ])->get();

        $date_templates->map(function($item) use ($start,$end){
            $item_start = \Carbon\Carbon::now()->setHour($item->hour_start);
            $item_end = \Carbon\Carbon::now()->setHour($item->hour_end);

            $new_start = \Carbon\Carbon::now()->setHour($start);
            $new_end = \Carbon\Carbon::now()->setHour($end);

            if(
                ($item_start>= $new_start && $item_start <= $new_end) ||
                ($item_end>= $new_start && $item_end <= $new_end)
            ){
                throw new \Exception('Ya Existe una plantilla dentro de ese rango de horas');
            }
        });
    }

}
