<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Resources\Room\RoomResource;
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
                'partialCost.partialRate'
                ])->withTrashed()->get();

            return RoomResource::collection($room);
        } catch (\Exception $e) {
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }
}
