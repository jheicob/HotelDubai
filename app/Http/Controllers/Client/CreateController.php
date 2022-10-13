<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AssignRoomRequest;
use App\Http\Requests\Client\CreateRequest;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;

class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $client = Client::updateOrCreate(
                $request->only('document'),
                $request->except('document')
            );

            DB::commit();
            return ClientResource::make($client);
            // return custom_response_sucessfull('created successfull',201);

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

    public function assigned_room(AssignRoomRequest $request){
        try{
            DB::beginTransaction();

            $client = Client::find($request->client_id);
            $room = Room::find($request->room_id);
            $partial_rate = $room->partialCost->partialRate;
            $partial_rate->append('number_hour');

            $rate = (new RoomService($room))->getRateByConditionals();
            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;
            $request->merge([
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),
                'partial_min' => $partial_rate->name,
                'rate' => $rate,
            ]);

            $client->rooms()->attach($request->room_id,$request->except(['client_id','room_id']));

            $roomStatus = RoomStatus::firstWhere('name','Ocupada');
            $room->update([
                'room_status_id' => $roomStatus->id,
            ]);
            DB::commit();
            return custom_response_sucessfull('created successfull',200);

        }catch(\Exception $e){
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);

        }
    }

    public function extendUse(Request $request){
        try{
            DB::beginTransaction();

            $client = Client::find($request->client);

            $client->load('roomActive');
            $client->roomActive->map(function($room){
                $room->pivot->invoiced = true;
                $room->pivot->save();
            });

            $room = Room::find($request->room_id);

            $partial_rate = $room->partialCost->partialRate;

            $partial_rate->append('number_hour');
            $quantity_total_hours = $request->quantity_partial * $partial_rate->number_hour;
            $request->merge([
                'date_out' => Carbon::parse($request->date_in)->addHours($quantity_total_hours),
                'partial_min' => $partial_rate->name,
                'rate' => $room->partialCost->rate,
            ]);

            $client->rooms()->attach($request->room_id,$request->except(['client_id','room_id']));

            $roomStatus = RoomStatus::firstWhere('name','Ocupada');
            $room->update([
                'room_status_id' => $roomStatus->id,
            ]);
            DB::commit();
            return custom_response_sucessfull('created successfull',200);

        }catch(\Exception $e){
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);

        }
    }

}
