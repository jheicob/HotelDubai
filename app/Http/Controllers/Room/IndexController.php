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
    public function get()
    {
        try {
            $room = Room::with([
                'roomStatus',
                'partialCost.roomType',
                'partialCost.partialRate',
                'receptionActive.client',
                'receptionActive.details',
            ])->withTrashed()
            ->IsCamarero()
              ->get();

            $room->transform(function($value){
                $rate = (new RoomService($value))->getRateByConditionals();
                $value->append('rate_current');
                $value->rate_current = $rate;
                return $value;
                });
            return RoomResource::collection($room);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
