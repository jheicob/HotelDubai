<?php

namespace App\Http\Controllers\Room;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Room\CreateRequest;
use App\Models\EstateType;
use App\Models\Reception;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Mpdf\Mpdf;

class CreateController extends Controller
{

    public function create(CreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $room = Room::create($request->all());

            DB::commit();

            return custom_response_sucessfull('created successfull', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e, __('errors.server.title'), 500);
        }
    }

    public function report(Request $request)
    {
        $pdf = new Mpdf();
        if (!$request->date_start) {
            $request['date_start'] = Reception::min('date_out');
        }
        if (!$request->date_end) {
            $request['date_end'] = Reception::max('date_out');
        }
        // dd($request->all());
        $rooms = Room::with([
            'receptionClosed' => function ($q) {
                $q->orderBy('date_out', 'asc');
            },
            'partialCost.roomType'
        ])
            ->whereHas('receptionClosed', function (Builder $query) use ($request) {
                $query
                    ->when($request->date_start && $request->date_out, function (Builder $q) use ($request) {
                        $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end]);

                    });
            }, '>=', 0)
            ->when($request->room_type_id, function (Builder $query) use ($request) {
                $query->whereHas('partialCost', function (Builder $query) use ($request) {
                    $query->whereIn('room_type_id', $request->room_type_id);
                });
            })
            ->when($request->estate_type_id, function (Builder $query) use ($request) {
                $query->whereHas('partialCost', function (Builder $query) use ($request) {
                    $query->whereIn('estate_type_id', $request->estate_type_id);
                });
            })
            ->withCount([
                'receptionClosed'
            ])
            ->orderBy('estate_type_id', 'asc')
            ->orderByDesc('reception_closed_count')
            ->get();

        $receptionsCounts = Reception::select([
                'room_id',
                'date_out as date_out_f',
                // DB::raw('count(room_id) as count'),
                DB::raw('date_format(date_out, "%d-%m-%Y") as date_out_f')
            ])
            ->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
            // ->groupBy(['room_id', 'date_out_f'])
            ->get();

        // return $receptionsCounts;
        // return $rooms;

        $diff_in_days = Carbon::parse($request->date_start)->diffInDays(Carbon::parse($request->date_end));
        $html = view('Room.report', [
            'rooms' => $rooms,
            'date_start' => $request->date_start,
            'init_date' => Carbon::parse($request->date_start),
            'date_end' => $request->date_end,
            'receptions_counts' => $receptionsCounts,
            'diff_in_days' => $diff_in_days +1
        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Habitaciones';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }

    public function reportRoomType(Request $request){
        $pdf = new Mpdf();
        if (!$request->date_start) {
            $request['date_start'] = Reception::min('date_out');
        }
        if (!$request->date_end) {
            $request['date_end'] = Reception::max('date_out');
        }
        // dd($request->all());
        $roomTypes = RoomType::with([
                    'partialCost.rooms.receptionClosed' => function ($q) {
                        $q->orderBy('date_out', 'asc');
                    },
                    'room.estateType',
                    'partialCost.rooms.estateType'
                ])
                ->addSelect([
                    'cant_receptions' => Reception::select(DB::raw('count(\'room_id\')'))
                                            ->leftjoin('rooms','rooms.id','=','receptions.room_id')
                                            ->join('partial_costs','rooms.partial_cost_id','=','partial_costs.id')
                                            ->whereColumn('partial_costs.room_type_id','room_types.id')
                                            ->whereBetween('receptions.date_out', [$request->date_start, $request->date_end])
                ])
            ->whereHas('partialCost', function (Builder $query) use ($request) {
                $query->whereHas('rooms', function (Builder $query) use ($request) {
                    $query->whereHas('receptionClosed', function (Builder $query) use ($request) {
                        // dd($request->all());
                        $query
                            ->when($request->date_start && $request->date_out, function (Builder $q) use ($request) {
                                $q->whereBetween('date_out', [$request->date_start, $request->date_end]);
                            });
                    });

                });
            })
            ->when($request->room_type_id, function (Builder $query) use ($request) {
                    $query->whereIn('id', $request->room_type_id);
            })
            ->when($request->estate_type_id, function (Builder $query) use ($request) {
                $query->whereHas('rooms', function (Builder $query) use ($request) {
                    $query->whereIn('estate_type_id', $request->estate_type_id);
                });
            })
            // ->join('partial_costs','partial_costs.room_type_id','=','room_types.id')
            // ->join('rooms','rooms.partial_cost_id','=','partial_costs.id')
            // ->leftJoin('receptions','receptions.room_id','=','rooms.id')
            // ->orderBy('rooms.estate_type_id', 'asc')
            // ->orderByDesc('reception_closed_count')
            ->get();

        $receptionsCounts = Reception::select([
                'room_id',
                'partial_costs.room_type_id',
                'rooms.estate_type_id',
                'date_out as date_out_f',
                // DB::raw('count(room_id) as count'),
                DB::raw('date_format(date_out, "%d-%m-%Y") as date_out_f')
            ])
            ->join('rooms', 'rooms.id', '=', 'receptions.room_id')
            ->join('partial_costs', 'partial_costs.id', '=', 'rooms.partial_cost_id')
            ->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
            // ->groupBy(['room_id', 'date_out_f'])
            ->get();

        // return $receptionsCounts;
        // return $roomTypes;

        $diff_in_days = Carbon::parse($request->date_start)->diffInDays(Carbon::parse($request->date_end));
        $html = view('RoomType.report', [
            'roomTypes' => $roomTypes,
            'date_start' => $request->date_start,
            'init_date' => Carbon::parse($request->date_start),
            'date_end' => $request->date_end,
            'estateTypes' => EstateType::all(),
            'receptions_counts' => $receptionsCounts,
            'diff_in_days' => $diff_in_days +1
        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Habitaciones';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
