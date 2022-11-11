<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\RepairRequest;
use App\Http\Requests\Room\UpdateRequest;
use App\Models\Repair;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Room $room)
    {
        try {
            DB::beginTransaction();

            $room->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function changeStatus(Request $request, Room $room)
    {
        try {
            DB::beginTransaction();

            $room->update($request->only('room_status_id'));

            DB::commit();

            return custom_response_sucessfull('updated successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function repair(RepairRequest $request)
    {
        try {
            DB::beginTransaction();

            $repair = Repair::where('room_id', $request->room_id)
                ->whereNull('maintenance_date')
                ->first();
            if ($repair == '') {
                $repair = Repair::create([
                    'room_id'     => $request->room_id,
                    'report_user' => Auth::user()->id,
                    'report_date' => Carbon::now(),
                    'description' => $request->description
                ]);
            }

            if ($request->description != '' && $request->observation != '') {
                $request->merge([
                    'maintenance_user' => Auth::user()->id,
                    'maintenance_date' => Carbon::now()
                ]);
                $repair->update($request->all());
                $repair->room->update(['room_status_id' => 2]);
            }
            DB::commit();
            return;
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }
}
