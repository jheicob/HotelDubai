<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\Room\RoomResource;
use App\Models\Reception;
use App\Services\RoomService\RoomService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        return view('Room.index');
    }
    public function get(Request $request)
    {
        try {
            $room = Room::IsNotAdmin()
                // ->IsCamarero()
                // ->IsMantenimiento()
                ->filter($request)
                ->orderBy('name', 'asc');
            if(isAdmin()){
                $room = $room->withTrashed();
            }
            $room = $room->get();

            $room->transform(function ($value) {
                $rate = (new RoomService($value));
                $value->append('rate_current');
                $value->rate_current = $rate->getRateByConditionals();
                $value->partial_cost_id = $rate->getPartialByConditionals();
                return $value;
            });

            $room->load([
                'roomStatus',
                'estateType',
                'partialCost.roomType',
                'partialCost.partialRate',
                'receptionActive.client',
                'receptionActive.invoice.details',
                'receptionActive.invoice.payments',
                'receptionActive.details',
                'receptionActive.companions.client',
                'receptionActive.companions.extraGuest',
                'inRepair'

            ]);
            return RoomResource::collection($room);
        } catch (\Exception $e) {
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function calendarReservation(){
        return view('Room.calendarReservation');
    }

    public function getReservations(){
        $receptions = Reception::with('room.partialCost.roomType','client')
                                ->where([
                                    ['date_in','<=',Carbon::now()->startOfDay()->format('Y-m-d H:i:s')],
                                    ['date_out','>=',Carbon::now()->endOfDay()->format('Y-m-d H:i:s')]
                                ])
                                ->orWhere('date_in','>=',Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))
                                ->where('reservation',1)
                                ->get();

        $receptions = $receptions->transform(function($reception){
            $hab = "(".$reception->room->name." ".$reception->room->partialCost->roomType->name.")";
            $title= $hab. ' - ' . $reception->client->first_name.' '. $reception->client->last_name;
            $start= Carbon::parse($reception->date_in)->format('Y-m-d\TH:i:s');
            $end= Carbon::parse($reception->date_out)->format('Y-m-d\TH:i:s');

            $reception['title'] = $title;
            $reception['start'] = $start;
            $reception['end'] = $end;

            return $reception;
        });
        return $receptions;
    }
}
