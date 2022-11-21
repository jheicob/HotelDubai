@extends('Reports.base')
 @section('content')
<table style="">
    <tr>
        <th>Nro</th>
        <th>Hab.</th>
        <th>Tipo Hab</th>
        <th>Inmueble</th>
        <th>Fecha</th>
        <th>Cant. Rotación</th>
    </tr>
    @php
        $count_rooms = 1;
    @endphp
    @foreach ($rooms as $room)
            @for ($i = 0; $i < $diff_in_days; $i++)
                <tr>
                    <td align='center'>{{$count_rooms++}}</td>
                    <td align='center'>{{ $room->name }}</td>
                    <td align='center'>{{ $room->partialCost->roomType->name}}</td>
                    <td align='center'>{{ $room->estateType->name}}</td>
                    <td align='center'>{{$init_date->format('m-d-Y')}}</td>
                    <td align='center' width="35px">{{ $receptions_counts
                            ->where('room_id',$room->id)
                            ->where('date_out_f',$init_date->format('d-m-Y'))
                            ->count()}}</td>
                </tr>
                @php
                    $init_date->addDay()
                @endphp
            @endfor
            @php
                $init_date = \Carbon\Carbon::parse($date_start)
            @endphp
    @endforeach
</table>

<table align="center" style="width:220px">
    {{-- <tr>
        <td colspan="2" align="center">
            Totales
        </td>
    </tr>

    <tr>
        <td align="center">
            Clientes
        </td>
        <td align="center">

            {{count($clients)}}
        </td>
    </tr>
    <tr>
        <td align="center">

            Cant. Acompañantes
        </td>
        <td align="center">

            {{$count_companions}}
        </td>
    </tr> --}}
</table>
@endsection
