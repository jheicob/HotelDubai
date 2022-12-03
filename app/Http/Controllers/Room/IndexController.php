<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\Room\RoomResource;
use App\Services\RoomService\RoomService;
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
                'receptionActive.client.invoiceNoPrint.details',
                'receptionActive.client.invoiceNoPrint.payments',
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
}
