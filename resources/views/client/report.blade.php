@extends('Reports.base')
 @section('content')
<table style="">
    @foreach ($clients as $client)
        @foreach ($client->receptionClosed as $reception)
            <tr>
                <td colspan="7" align="center">
                    <span>
                    Hab. {{ $reception->room->name }} - {{ $reception->room->partialCost->roomType->name }}
                </span>
                &nbsp;
                &nbsp;
                &nbsp;
                &nbsp;
                <span style="margin-right:  00px">
                    Entrada: {{\Carbon\Carbon::parse($reception->date_in)->format('d-m-Y') }} . Salida {{ \Carbon\Carbon::parse($reception->date_out)->format('d-m-Y') }}
                </span>
                </td>
            </tr>
            <tr>
                <td><b>Tipo Documento </b></td>
                <td><b>Documento </b></td>
                <td><b>Nombre </b></td>
                <td><b>Apellido </b></td>
                <td><b>Telefono </b></td>
                <td><b>Correo electrónico</b></td>
                <td><b>Tipo Cliente</b></td>
            </tr>
            <tr>
                <td>{{ $client->typeDocument->name }}</td>
                <td>{{ $client->document }}</td>
                <td>{{ $client->first_name }}</td>
                <td>{{ $client->last_name }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->email }}</td>
                <td>Titular</td>
            </tr>
            @if ($reception->companions->count() > 0)
             @foreach ($reception->companions as $companion)
                @php
                    $count_companions++;

                @endphp
                <tr>
                    <td>{{ $companion->client->typeDocument->name }}</td>
                    <td>{{ $companion->client->document }}</td>
                    <td>{{ $companion->client->first_name }}</td>
                    <td>{{ $companion->client->last_name }}</td>
                    <td>{{ $companion->client->phone }}</td>
                    <td>{{ $companion->client->email }}</td>
                    <td>Acompañante</td>
                </tr>
             @endforeach
            @endif
        @endforeach
        <tr style="border: none; height: 45px">
            <td colspan="7" style="border: none; height: 25px"></td>
        </tr>
    @endforeach
</table>

<table align="center" style="width:220px">
    <tr>
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
    </tr>
</table>
@endsection
