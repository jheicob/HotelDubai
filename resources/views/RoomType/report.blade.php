@extends('Reports.base')
 @section('content')
<table style="">
    <thead>

        <tr>
            <th>Nro</th>
            <th>Tipo Hab</th>
            <th>Inmueble</th>
            <th>Fecha</th>
            <th>Cant. Rotación</th>
        </tr>
    </thead>
    @php
        $count_rooms = 1;
    @endphp
    @foreach ($roomTypes as $roomType)
        @php
            $acum_days = 0;
        @endphp
            @for ($i = 0; $i < $diff_in_days; $i++)
                <tr>
                    <td align='center'>{{$count_rooms++}}</td>
                    <td align='center'>{{ $roomType->name}}</td>
                    <td align='center'>
                        {{ $roomType->room->estateType->name}}
                    </td>
                    <td align='center'>{{$init_date->format('m-d-Y')}}</td>
                    <td align='center' width="35px">
                        {{ $receptions_counts
                            ->where('room_type_id',$roomType->id)
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count()}}
                            </td>
                </tr>
                @php
                    $init_date->addDay();
                    $acum_days+= $receptions_counts
                            ->where('room_type_id',$roomType->id)
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count();

                @endphp
            @endfor
            <tr style="height: 35px">
                <td colspan="4" align="right" class="text-bold">
                   <b> Total de Rotaciones de la hab. {{$roomType->name}}</b>
                </td>
                <td align="center" class="text-bold">
                <b>{{ $acum_days }}</b>
                </td>
            </tr>
            @php
                $init_date = \Carbon\Carbon::parse($date_start)
            @endphp
    @endforeach
</table>

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

</table>

@endsection

<style>
    text-bold :{
        font-weight: bold:
    }
</style>
