<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Models\EstateType;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\PartialCost;
use App\Models\Reception;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Builder;
use Mpdf\Mpdf;

class UpdateController extends Controller
{

    public function updated(UpdateRequest $request, Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $invoice->update($request->all());

            DB::commit();

            return custom_response_sucessfull('updated successfull');

        } catch (\Exception $e) {
            DB::rollBack();
            return custom_response_exception($e,__('errors.server.title'),500);
        }
    }

    public function report(Request $request){

        if(!$request->has('date_start')){
            $date_start = Invoice::whereHas('details',function(Builder $query){
                $query->where('productable_type','like','%Product');
            })->min('date');
        }else{
            $date_start = $request->input('date_start');
        }

        if(!$request->has('date_end')){
            $date_end = Invoice::whereHas('details',function(Builder $query){
                $query->where('productable_type','like','%Product');
            })->max('date');
        }else{
            $date_end = $request->input('date_end');
        }
        // dd($date_end);
        $invoices = Invoice::whereHas('details',function(Builder $query){
            $query->where('productable_type','like','%Product');
        })
        ->when(($request->date_start && $request->date_end),function(Builder $query) use ($request){
            $query->whereBetween(DB::raw('date_format(date, "%d-%m-%Y")'),[$request->date_start && $request->date_end]);
        })
        ->when($request->estate_type_id, function(Builder $q,$estate){
            $q->whereHas('fiscalMachine',function(Builder $q) use ($estate){
                $q->whereIn('estate_type_id',$estate);
            });
        })
        ->orderBy('created_at', 'desc')
        ->with([
            'payments',
            'details',
            'client',
            'fiscalMachine.estateType'
        ])
        ->get();

        $pdf = new Mpdf([
            'orientation' => 'L',
            'tempDir'=>storage_path('tempdir')
        ]);

        // return $invoices;
        $html = view('Invoice.PuntoVentaReport', [
            'invoices' => $invoices,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'title_report' => 'Reporte del Punto de Venta'

        ]);
        // return $html;
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Habitaciones';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }

    public function reportGraph(Request $request) {
        return view('Reports.Grafico');
    }

    public function getDataGraph(Request $request){
        $data = [];
        switch($request->option){
            case 'RoomTypes':
                $data = self::getRoomTypeData($request);
                break;
            case 'Rooms':
                $data = self::getRoomData($request);
                break;
            case 'EstateTypes':
                $data = self::getEstateTypeData($request);
                break;
            default:
                break;
        }
        return $data;
        return self::setDataGraph($data);
    }

    private function setDataGraph($data):array
    {
        $names = [];
        $values = [];
        foreach($data as $item){
            $names[] = $item->name;
            $values[] = $item->receptions_count;
        }

        return [
            'names' => $names,
            'values' => $values
        ];
    }

    private function getEstateTypeData($request){
        $receptions = EstateType::Select('name')
                ->when($request->date_start && $request->date_out, function (Builder $q) use ($request){
                        $q->where('receptions',function(Builder $q) use ($request){
                            $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                                ->where('invoiced',1);
                        });
                })
                ->when($request->estate_type_id, function (Builder $q,$estate_type_id){
                    $q->where('id',$estate_type_id);
                })
                ->withCount('receptions')
                ->get()
                ;
        return $receptions;
    }

    private function getRoomTypeData($request){
        $roomTypes = PartialCost::Select([
            'name' => RoomType::select('name')->whereColumn('partial_costs.room_type_id','room_types.id')
        ])
        ->when($request->date_start && $request->date_out, function (Builder $q) use ($request){
                $q->where('receptions',function(Builder $q) use ($request){
                    $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                        ->where('invoiced',1);
                });
        })
        ->when($request->estate_type_id, function (Builder $q,$estate_type_id){
            $q->whereHas('rooms',function(Builder $q) use ($estate_type_id){
                $q->where('estate_type_id',$estate_type_id);
            });
        })
        ->withCount('receptions')
        // ->withSum('receptions_count')
        ->groupBy('name','receptions_count')
        ->get();
        return $roomTypes;
    }

    private function getRoomData($request){
        $rooms = Room::select('name')
                    ->when($request->date_start && $request->date_out, function (Builder $q) use ($request){
                        $q->where('receptions',function(Builder $q) use ($request){
                            $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                                ->where('invoiced',1);
                        });
                })
                ->when($request->estate_type_id, function (Builder $q,$estate_type_id){
                    $q->where('estate_type_id',$estate_type_id);
                })
                ->withCount('receptions')
                // ->withSum('receptions_count')
                ->groupBy('name','receptions_count')
                ->get();
        return $rooms;
    }

}
