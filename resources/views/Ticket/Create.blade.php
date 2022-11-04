<html>
    <head>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

        </head>
        <body>    
            <div class="row">
                <div class="col text-center">
                    <h2>{{$reception->room->name}}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    Cajero:
                </div>
                <div class="col">
                    {{Auth::user()->name}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    Fecha y Hora de Entrada:
                </div>
                <div class="col">
                    {{$reception->date_in}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    Fecha y Hora de Salida:
                </div>
                <div class="col">
                    {{$reception->date_out}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    Total:
                </div>
                <div class="col">
                    {{$total}}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    Forma de Pago:
                </div>
                <div class="col">
                    {{$ticket->observation}}
                </div>
            </div>
    </body>

</html>
