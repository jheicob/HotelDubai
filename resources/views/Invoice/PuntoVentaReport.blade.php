@extends('Reports.base')
 @section('content')
<table style="">
    <thead>

        <tr>
            <th>Nro</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Impresora</th>
            <th>Inmueble</th>
            <th>Total</th>

            <th>cantidad Divisa</th>
            <th>Neto Divisa</th>
            <th>Cant. Impuesto Divisa (3%)</th>
            <th>Cant. Impuesto Divisa (16%)</th>
            <th>Cantidad Bs</th>
            <th>Neto Bs</th>
            <th>Cant. Impuesto Bs (16%)</th>
            <th>Neto Total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $cont = 1;
            $neto_divisa = 0;
            $neto_bs = 0;
            $sum = [
                'cant_divisa' => 0,
                'neto_divisa' => 0,
                'cant_impuesto_divisa_3' => 0,
                'cant_impuesto_divisa_16' => 0,
                'cant_bs' => 0,
                'cant_impuesto_bs' => 0,
                'neto_bs' => 0,
                'neto_total' => 0,
            ]
        @endphp
        @foreach ($invoices as $invoice)
            <tr>
                <td>
                    {{$cont++}}
                </td>
                <td>
                    {{Carbon\Carbon::parse($invoice->date)->format('d/m/Y')}}
                </td>
                <td align='center'>

                    {{$invoice->client->full_name}}
                </td>
                <td>
                    {{$invoice->fiscalMachine->name}}
                </td>
                <td align='center'>

                    {{$invoice->fiscalMachine->estateType->name}}
                </td>
                <td align='center'>

                    {{$invoice->total}}
                </td>
                <td align='center'>

                    {{$invoice->payments
                        ->where('type','divisa')
                        ->sum('quantity')}}
                </td>
                <td align='center'>

                    {{ $invoice->payments
                        ->where('type','divisa')
                        ->count() > 0
                    ? $neto_divisa = round($invoice->payments
                        ->where('type','divisa')
                        ->sum('quantity') / (1.19),2)
                    : 0
                }}
                </td>
                <td align='center'>
                    {{ $invoice->payments
                            ->where('type','divisa')
                            ->count() > 0
                        ? round($neto_divisa * 0.19,2)
                        : 0
                    }}
                </td>
                <td align='center'>
                    {{ $invoice->payments
                            ->where('type','divisa')
                            ->count() > 0
                        ? round($neto_divisa * 0.03,2)
                        : 0
                    }}
                </td>
                    <td align='center'>
                        {{ $invoice->payments
                                ->where('type','Bs')
                                ->count() > 0
                            ? $invoice->payments
                                ->where('type','Bs')
                                ->sum('quantity')
                            : 0
                        }}</td>
                        <td align='center'>
                            {{ $invoice->payments
                            ->where('type','Bs')
                            ->count() > 0
                        ? $neto_bs = round($invoice->payments
                            ->where('type','Bs')
                            ->sum('quantity') / (1.16),2)
                        : 0
                    }}</td>
                    <td align='center'>
                        {{ $invoice->payments
                            ->where('type','Bs')
                            ->count() > 0
                        ? round($neto_bs * 0.16,2)
                        : 0
                    }}</td>

                     <td align='center'>
                        {{ $invoice->payments
                        ->count() > 0
                    ? $neto_divisa + $neto_bs
                    : 0
                }}</td>
            </tr>
            @php
                $sum['cant_divisa'] += $invoice->payments
                        ->where('type','divisa')
                        ->sum('quantity');
                $sum['neto_divisa'] += $neto_divisa;
                $sum['cant_impuesto_divisa_3'] += round($neto_divisa * 0.19,2);
                $sum['cant_impuesto_divisa_16'] += round($neto_divisa * 0.03,2);
                $sum['cant_bs'] += $invoice->payments
                                ->where('type','Bs')
                                ->sum('quantity');
                $sum['neto_bs'] += $neto_bs;
                $sum['cant_impuesto_bs'] += round($neto_bs * 0.16,2);
                $sum['neto_total'] += $neto_bs + $neto_divisa
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan=""></td>
            <td colspan=""></td>
            <td colspan=""></td>
            <td colspan=""></td>
            <td colspan=""></td>
            <td align="center">{{$invoices->sum('total')}}</td>
            <td align="center">{{$sum['cant_divisa']}}</td>
            <td align="center">{{$sum['neto_divisa']}}</td>
            <td align="center">{{$sum['cant_impuesto_divisa_3']}}</td>
            <td align="center">{{$sum['cant_impuesto_divisa_16']}}</td>
            <td align="center">{{$sum['cant_bs']}}</td>
            <td align="center">{{$sum['neto_bs']}}</td>
            <td align="center">{{$sum['cant_impuesto_bs']}}</td>
            <td align="center">{{$sum['neto_total']}}</td>
        </tr>
    </tfoot>
</table>
{{--
<table align="center" style="width:220px; margin-top:35px">
    <tr>
        <td colspan="2" align="center">
            Totales
        </td>
    </tr>

    @foreach ($estateTypes as $stateType)
    <tr>
        <td align="center">
            {{$stateType->name}}
        </td>
        <td align="center">
            {{$receptions_counts
                ->where('estate_type_id',$stateType->id)
                ->count()}}
        </td>
    </tr>
    @endforeach

</table> --}}

@endsection

<style>
    text-bold :{
        font-weight: bold:
    }
</style>
