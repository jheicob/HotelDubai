<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Reception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
Use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $pdf = new Mpdf(['tempDir'=>storage_path('tempdir')]);
        if(!$request->date_start){
            $request['date_start'] = Reception::min('date_out');
        }
        if(!$request->date_end){
            $request['date_end'] = Reception::max('date_out');
        }
        // dd($request->all());
        $clients = Client::with([
                        'typeDocument',
                        'receptionClosed.room.partialCost.roomType',
                        'receptionClosed.companions.client'
                        ])
                    ->whereHas('receptionClosed',function(Builder $query) use ($request){
                        $query->when($request->date_start && $request->date_out,function(Builder $q) use ($request){
                            $q->whereBetween(DB::raw('date_format(date_out, "%d-%m-%Y")'), [$request->date_start, $request->date_end]);

                            // $q->whereBetween('created_at', [$request->date_start, $request->date_end]);
                        })
                        ->when($request->room_type_id,function(Builder $query) use ($request){
                                $query->whereHas('room',function(Builder $query) use ($request){
                                    $query->whereHas('partialCost',function(Builder $query) use ($request){
                                        $query->whereIn('room_type_id',$request->room_type_id);
                                });
                            });
                        })
                        ->when($request->room_id,function(Builder $query) use ($request){
                            $query->whereIn('room_id',$request->room_id);
                        })
                        ->when($request->client_id,function(Builder $query) use ($request){
                            $query->whereIn('client_id',$request->client_id);
                        })
                        ;

                    })
                    ->get();


        $html = view('client.report', [
            'clients' => $clients,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'count_companions' => 0,
            'title_report' => 'Reporte de Clientes'
        ]);  // return $html;
        $nombre_archivo = 'Reporte-Clientes';

        return self::generateExcelOrPdf($html,$nombre_archivo,$request->type);
        $pdf->WriteHTML($html);
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
}
