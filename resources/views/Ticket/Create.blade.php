<style>
    @page {
        margin: 0 5px
    }
    body{
        font-size: 12px;
        text-align: center
    }
    table{
        width: 100%
    }
</style>

<table style="">
    <tr>
        <td colspan="2" align='center'>
            <p><b>{{ $reception->room->name }}</b></p>
            <p><b>{{ $reception->room->partialCost->roomType->name }}</b></p>
        </td>
    </tr>
    <tr>
        <td style="height: 10px">

        </td>
    </tr>
    <tr>
        <td>
            Cajero: 
        </td>
        <td>
            {{ Auth::user()->name }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            ...........................................................
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            Entrada
        </td>
    </tr>
    <tr>

        <td>
            Fecha :
        </td>
        <td>
            {{ \Carbon\Carbon::parse($reception->date_in)->format('d-m-Y') }}
        </td>
    </tr>
    <tr>

        <td>
            Hora :
        </td>
        <td>
            {{ \Carbon\Carbon::parse($reception->date_in)->format('h:i a') }}
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            ...........................................................
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">

            Salida
        </td>
    </tr>
   
    <tr>
        <td>
            Fecha:
        </td>
        <td>
            {{ \Carbon\Carbon::parse($reception->date_out)->format('d-m-Y') }}
        </td>

    </tr>
    <tr>
        <td>
            Hora:
        </td>
        <td>
            {{ \Carbon\Carbon::parse($reception->date_out)->format('h:i a') }}
        </td>

    </tr>
    <tr>
        <td colspan="2">
            ...........................................................
        </td>
    </tr>
    
    <tr>

        <td>
            Total:
        </td>
        <td >
         <b>   {{ $total }}</b>
        </td>
    </tr>

    <tr>

        <td >
           Obs. / <br> Forma de Pago:
        </td>
        <td>
            {{ $ticket->observation }}
        </td>
    </tr>
</table>
