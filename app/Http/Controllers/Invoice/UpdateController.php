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
        $nombre_archivo = 'Reporte-PuntoVenta';
        return self::generateExcelOrPdf($html,$nombre_archivo,$request->type);
        $pdf->WriteHTML($html);
        $nombre_archivo = 'Reporte-Habitaciones';
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }


    private function  generateExcelOrPdf($html,$name,$type){
        if($type == 'pdf'){
            $pdf = new Mpdf(['tempDir'=>storage_path('tempdir')]);
            $pdf->WriteHTML($html);
            header('Content-Type: application/pdf');
            header("Content-Disposition: inline; filename='$name.pdf'");
            return $pdf->Output("$name.pdf", 'I');
        }
        if($type == 'excel'){
            // $xsl = new Html();
            // $spreadsheet = $xsl->loadFromString($html);
            // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=$name.xls");
            return $html;

        }

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
        // return $data;
        return self::setDataGraph($data);
    }

    private function setDataGraph($data):array
    {
        $names = [];
        $values = [];
        $payments = [];

        foreach($data as $item){
            $names[]    = $item->name;
            $values[]   = $item->receptions_count;
            $payments[] = $item->pago_divisa + $item->pago_bs;
        }

        // falta hacer un filtro para que tome solo los invoiced = 1
        return [
            'names' => $names,
            'values' => $values,
            'payments' => $payments
        ];
    }

    private function getEstateTypeData($request){
        $EstateType = EstateType::Select('id','name')
                ->when($request->date_start && $request->date_end, function ( $q) use ($request){
                        $q->whereHas('receptions',function($q) use ($request){
                            $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                                ->where('invoiced',1);
                        });
                })
                ->when($request->estate_type_id, function ( $q,$estate_type_id){
                    $q->where('id',$estate_type_id);
                })
                ->withCount('receptions')
                ->get()
                ;
        $EstateType->transform(function($item){
            $invoices = Invoice::With('payments')
                ->whereHas('reception',function( $q) use ($item){
                    $q->whereHas('room', function( $q) use ($item){
                        $q->where('estate_type_id',$item->id);
                    });
                })
                ->get();

            $invoices->transform(function($invoice){
                $pago =[
                    'divisa' => $invoice->payments->where('type','divisa')->sum('quantity'),
                    'bs' => $invoice->payments->where('type','Bs')->sum('quantity'),
                ];
                $invoice['pago_divisa'] = $pago['divisa'];
                $invoice['pago_bs'] = $pago['bs'];
                return $invoice;
            });

            $pago_divisa = $invoices->sum('pago_divisa');
            $pago_bs = $invoices->sum('pago_bs');

            $item->pago_divisa = $pago_divisa;
            $item->pago_bs = $pago_bs;
            return $item;

        });

        return $EstateType;
    }

    private function getRoomTypeData($request){
        $roomTypes = RoomType::select('id','name')
        ->when($request->date_start && $request->date_end, function ( $q) use ($request){
                $q->where('receptions',function( $q) use ($request){
                    $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                        ->where('invoiced',1);
                });
        })
        ->when($request->estate_type_id, function ( $q,$estate_type_id){
            $q->whereHas('rooms',function( $q) use ($estate_type_id){
                $q->where('estate_type_id',$estate_type_id);
            });
        })
        ->with('rooms.receptions.invoice')
        ->get();

        $roomTypes->transform(function($roomType){
            $count_receptions = 0;
            $receptions_keys = collect();
            foreach($roomType->rooms as $room){
                $count_receptions += $room->receptions->count();
                // dd($room->receptions->keys());
                foreach($room->receptions as $reception){

                    if($reception){
                        $receptions_keys[] = $reception->id;
                    }
                }
            }
            $invoices = Invoice::With('payments')
            ->whereHas('reception',function( $q) use ($roomType,$receptions_keys){
                // $q->whereHas('room', function(Builder $q) use ($roomType,$receptions_keys){
                    $q->whereIn('id', $receptions_keys->toArray());
                // });
            })
            ->get();

            $invoices->transform(function($invoice){
                $pago =[
                    'divisa' => $invoice->payments->where('type','divisa')->sum('quantity'),
                    'bs' => $invoice->payments->where('type','Bs')->sum('quantity'),
                ];
                $invoice['pago_divisa'] = $pago['divisa'];
                $invoice['pago_bs'] = $pago['bs'];
                return $invoice;
            });

            $pago_divisa = $invoices->sum('pago_divisa');
            $pago_bs = $invoices->sum('pago_bs');

            $roomType->pago_divisa = $pago_divisa;
            $roomType->pago_bs = $pago_bs;
            $roomType->receptions_count = $count_receptions;

            return $roomType
            ;

        });
        return $roomTypes;
    }

    private function getRoomData($request){
        $rooms = Room::select('name','id')
                ->when($request->date_start && $request->date_end, function ( $q) use ($request){
                    $q->whereHas('receptions',function( $q) use ($request){
                        $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end])
                            ->where('invoiced',1);
                    });
                })
                ->when($request->estate_type_id, function ( $q,$estate_type_id){
                    $q->where('estate_type_id',$estate_type_id);
                })
                ->withCount('receptions')
                ->get();

        dd($rooms);
        $rooms->transform(function($item){
            $invoices = Invoice::With('payments')
                ->whereHas('reception',function( $q) use ($item){
                    $q->whereHas('room', function( $q) use ($item){
                        $q->where('id',$item->id);
                    });
                })
                ->get();

            $invoices->transform(function($invoice){
                $pago =[
                    'divisa' => $invoice->payments->where('type','divisa')->sum('quantity'),
                    'bs' => $invoice->payments->where('type','Bs')->sum('quantity'),
                ];
                $invoice['pago_divisa'] = $pago['divisa'];
                $invoice['pago_bs'] = $pago['bs'];
                return $invoice;
            });

            $pago_divisa = $invoices->sum('pago_divisa');
            $pago_bs = $invoices->sum('pago_bs');

            $item->pago_divisa = $pago_divisa;
            $item->pago_bs = $pago_bs;
            return $item;
        });
        return $rooms;
    }

}
