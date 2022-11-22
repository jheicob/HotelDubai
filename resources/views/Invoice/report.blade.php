@extends('Reports.base')
 @section('content')
<table style="">
    <thead>

        <tr>
            <th>Nro</th>
            <th>Fecha</th>
            <th>Venta Diaria Divisa</th>
            <th>Neto Divisa</th>
            <th>Cant. Impuesto Divisa (3%)</th>
            <th>Cant. Impuesto Divisa (16%)</th>
            <th>Venta Diaria Bs</th>
            <th>Neto Bs</th>
            <th>Cant. Impuesto Bs (16%)</th>
            <th>Neto Total</th>
            <th>Rotacion Cabañas</th>
            <th>Rotacion Edificio</th>
            <th>Rotacion Total</th>
        </tr>
    </thead>
    @php
        $count_rooms = 1;
    @endphp
        @php
            $acum_days = 0;
        @endphp
            @for ($i = 0; $i < $diff_in_days; $i++)
            @php
                $neto_divisa = 0;
                $neto_bs = 0;
            @endphp
                <tr>
                    <td align='center'>{{ $count_rooms++  }}</td>
                    <td align='center'>{{ $init_date->format('d-m-Y') }}</td>
                    <td align='center'>
                        {{ $payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','divisa')
                                ->count() > 0
                            ? $payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','divisa')
                                ->sum('quantity')
                            : 0
                        }}

                    <td align='center'>
                        {{ $payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','divisa')
                                ->count() > 0
                            ? $neto_divisa = round($payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','divisa')
                                ->sum('quantity') / (1.19),2)
                            : 0
                        }}
                    </td>
                </td>
                <td align='center'>
                    {{ $payments
                            ->where('date_invoice',$init_date->format('d-m-Y'))
                            ->where('type','divisa')
                            ->count() > 0
                        ? round($neto_divisa * 0.19,2)
                        : 0
                    }}
                </td>
                <td align='center'>
                    {{ $payments
                            ->where('date_invoice',$init_date->format('d-m-Y'))
                            ->where('type','divisa')
                            ->count() > 0
                        ? round($neto_divisa * 0.03,2)
                        : 0
                    }}
                </td>
                    <td align='center'> {{ $payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','Bs')
                                ->count() > 0
                            ? $payments
                                ->where('date_invoice',$init_date->format('d-m-Y'))
                                ->where('type','Bs')
                                ->sum('quantity')
                            : 0
                        }}</td>
                        <td align='center'> {{ $payments
                            ->where('date_invoice',$init_date->format('d-m-Y'))
                            ->where('type','Bs')
                            ->count() > 0
                        ? $neto_bs = round($payments
                            ->where('date_invoice',$init_date->format('d-m-Y'))
                            ->where('type','Bs')
                            ->sum('quantity') / (1.16),2)
                        : 0
                    }}</td>
                    <td align='center'> {{ $payments
                            ->where('date_invoice',$init_date->format('d-m-Y'))
                            ->where('type','Bs')
                            ->count() > 0
                        ? round($neto_bs * 0.16,2)
                        : 0
                    }}</td>

                     <td align='center'> {{ $payments
                        ->where('date_invoice',$init_date->format('d-m-Y'))
                        ->count() > 0
                    ? $neto_divisa + $neto_bs
                    : 0
                }}</td>
                    <td align='center' width="35px">
                        {{ $receptions_counts
                            ->where('estate_type_id',1)
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count()}}
                            </td>
                            <td align='center' width="35px">
                        {{ $receptions_counts
                            ->where('estate_type_id',2)
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count()}}
                            </td>
                            <td align='center' width="35px">
                        {{ $receptions_counts
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count()}}
                            </td>
                </tr>
                @php
                    $init_date->addDay();
                    // $acum_days+= $receptions_counts
                    //         ->where('room_type_id',$roomType->id)
                    //         ->where('date_out_f',$init_date->format('d-m-Y'))
                    //         ->count();

                @endphp
            @endfor

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
