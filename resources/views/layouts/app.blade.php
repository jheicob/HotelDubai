<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- Page level plugin CSS-->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin/sb-admin.css') }}" rel="stylesheet">
    <style>
        .ml-r-14 {
            margin-left: 14.5rem
        }

        .ml-r-6 {
            margin-left: 6rem
        }

        .custom-menu-item{
            display: none
        }

    </style>

    @yield('css')
</head>

<body id="page-top">

    <div id="app">
        <main>
            <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
                <a class="navbar-brand mr-1" href="{{ route('room.index') }}">
                    <img src="/img/Logo.png" alt="Logo" width="24" height="24"
                        class="d-inline-block align-text-top">
                    Hotel Dubai
                </a>
                <div class="mx-3"></div>

                <!-- Navbar Search -->

                <!-- Navbar -->
                <ul class="navbar-nav ml-auto ml-md-0">
                    {{-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <span class="badge badge-danger">9+</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li> --}}
                    {{-- <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger">7</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    --}}
                    @can('users.index')
                        <li class="nav-item" onmouseover="showElement('user')" onmouseout="hideElement('user')">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users"></i>
                                <span id='user-text' name="icon-user" class="custom-menu-item">
                                    Usuarios
                                </span>
                            </a>
                        </li>
                    @endcan

                    @can('room.index')
                    <li class="nav-item" onmouseover="showElement('room')" onmouseout="hideElement('room')">
                            <a class="nav-link" href="{{ route('room.index') }}">
                                <i class="fas fa-tags"></i>
                                <span id='room-text' name="icon-room" class="custom-menu-item">
                                    Habitaciones</span>
                            </a>
                        </li>
                    @endcan
                    @can('room.index')
                    <li class="nav-item" onmouseover="showElement('reservation')" onmouseout="hideElement('reservation')">
                            <a class="nav-link" href="{{ route('room.calendar-reservation') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span id='reservation-text' name="icon-reservation" class="custom-menu-item">
                                    Reservación</span>
                            </a>
                        </li>
                    @endcan
                    @can('invoice.index')
                    <li class="nav-item" onmouseover="showElement('invoice')" onmouseout="hideElement('invoice')">
                            <a class="nav-link" href="{{ route('invoice.index') }}">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span id='invoice-text' name="icon-invoice" class="custom-menu-item">
                                    Facturas</span>
                            </a>
                        </li>
                    @endcan
                    @can('product.index')
                    <li class="nav-item dropdown" onmouseover="showElement('inventory')" onmouseout="hideElement('inventory')">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-boxes"></i>
                            <span id='inventory-text' name="icon-inventory" class="custom-menu-item">
                                Inventario</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            @can('configuration.index')
                                <a class="dropdown-item text-dark"
                                    href="{{ route('Product.index') }}">Productos</a>
                            @endcan
                            @can('configuration.index')
                                <a class="dropdown-item text-dark"
                                    href="{{ route('ProductCategory.index') }}">Categorias</a>
                            @endcan
                        </div>
                    </li>
                @endcan

                    @can('seguridad')
                        <li class="nav-item dropdown" onmouseover="showElement('segurity')" onmouseout="hideElement('segurity')">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-lock"></i>
                                <span id='segurity-text' name="icon-segurity" class="custom-menu-item">
                                    Seguridad</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                                @can('roles.index')
                                    <a class="dropdown-item text-dark" href="{{ route('roles.index') }}">Roles</a>
                                @endcan
                                @can('permissions.index')
                                    <a class="dropdown-item text-dark" href="{{ route('permissions.index') }}">Permisos</a>
                                @endcan
                                @can('logs.index')
                                    <a class="dropdown-item text-dark" href="{{ route('logs.index') }}">Logs</a>
                                @endcan
                            </div>
                        </li>
                    @endcan


                    @can('configuracion')
                        <li class="nav-item dropdown" onmouseover="showElement('config')" onmouseout="hideElement('config')">
                            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cogs"></i>
                                <span id='config-text' name="icon-config" class="custom-menu-item">
                                    Configuracion</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                                @can('configuration.index')
                                    <a class="dropdown-item text-dark"
                                        href="{{ route('configuration.index') }}">Generales</a>
                                @endcan
                                @can('FiscalMachines.index')
                                    <a class="dropdown-item text-dark"
                                        href="{{ route('FiscalMachines.index') }}">Impresoras Fiscales</a>
                                @endcan
                                @can('room.type.index')
                                    <a class="dropdown-item text-dark" href="{{ route('room.type.index') }}">Tipo
                                        Habitacion</a>
                                @endcan
                                {{-- @can('theme.type.index')
                                    <a class="dropdown-item" href="{{ route('theme.type.index') }}">Tipo Tematica</a>
                                @endcan --}}
                                @can('estate.type.index')
                                    <a class="dropdown-item text-dark" href="{{ route('estate.type.index') }}">Tipo
                                        inmueble</a>
                                @endcan
                                @can('partial.rates.index')
                                    <a class="dropdown-item text-dark" href="{{ route('partial.rates.index') }}">Tarifas
                                        Parciales</a>
                                @endcan
                                @can('room.status.index')
                                    <a class="dropdown-item text-dark" href="{{ route('room.status.index') }}">Estado
                                        Habitaciones</a>
                                @endcan
                                @can('day.week.index')
                                    <a class="dropdown-item text-dark" href="{{ route('day.week.index') }}">Dia Semana</a>
                                @endcan
                                @can('system.time.index')
                                    <a class="dropdown-item text-dark" href="{{ route('system.time.index') }}">Horas
                                        Sistema</a>
                                @endcan
                                @can('shift.system.index')
                                    <a class="dropdown-item text-dark" href="{{ route('shift.system.index') }}">Turnos
                                        Sistema</a>
                                @endcan
                                <a class="nav-link dropdown-toggle text-dark" href="#" id="pagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <i class="fas fa-percent"></i> --}}
                                <span>Plantillas</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pagesDropdown">
                                @can('partial.cost.index')
                                    <a class="dropdown-item text-dark" href="{{ route('partial.cost.index') }}">Costo Por
                                        Parciales</a>
                                @endcan
                                @can('extra-guest.index')
                                    <a class="dropdown-item text-dark" href="{{ route('ExtraGuest.index') }}">
                                        Extra Huesped
                                    </a>
                                @endcan
                                @can('range.template.index')
                                    <a class="dropdown-item text-dark" href="{{ route('range.template.index') }}">Plantillas
                                        Por Rango</a>
                                @endcan
                                @can('date.templates.index')
                                    <a class="dropdown-item text-dark" href="{{ route('date.templates.index') }}">Plantillas
                                        Fechas Especiales</a>
                                @endcan
                                @can('day.templates.index')
                                    <a class="dropdown-item text-dark" href="{{ route('day.templates.index') }}">Plantillas
                                        Días</a>
                                @endcan
                                {{-- @can('hour.templates.index')
                                    <a class="dropdown-item text-dark" href="{{ route('hour.templates.index') }}">Plantillas
                                        Horas</a>
                                @endcan --}}

                            </div>
                            </div>
                        </li>
                    @endcan

                    @can('reports')
                        <reports
                            :client_report=" '{{Auth::user()->can('client.report')}}' == 1"
                            :room_type_report=" '{{Auth::user()->can('roomType.report')}}' == 1"
                            :room_report=" '{{Auth::user()->can('room.report')}}' == 1"
                            :reception_report=" '{{Auth::user()->can('reception.report')}}' == 1"
                            :punto_venta=" '{{Auth::user()->can('punto_venta.report')}}' == 1"
                            :punto_venta_graph=" '{{Auth::user()->can('punto_venta.report.graph')}}' == 1"

                        ></reports>
                    @endcan

                    @can('invoice.create')
                    <li class="nav-item" onmouseover="showElement('sale_point')" onmouseout="hideElement('sale_point')">
                        <a class="nav-link" href="{{route('invoice.ventas')}}" >
                            <i class="fas fa-store"></i>
                            <span id='sale_point-text' name="icon-sale_point" class="custom-menu-item">
                                Punto Venta</span>
                        </a>
                    </li>
                    @endcan

                </ul>
                <div class="col"></div>
                <ul class="navbar-nav ml-auto ml-md-0">
                    <room-notification :pusher_key="'{{ env('PUSHER_APP_KEY') }}'"></room-notification>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" style="color:black"
                                href="{{ route('profile.index') }}">Perfil</a>
                            <a class="dropdown-item" style="color:black"
                                href="{{ route('password.index') }}">Contraseña</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" style="color:black" data-toggle="modal"
                                data-target="#logoutModal">Logout</a>
                        </div>
                    </li>
                </ul>

            </nav>
            <div id="wrapper">
                <!-- Sidebar -->

                <div id="content-wrapper" class="">
                    @yield('content')
                    <footer class="sticky-footer w-100">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright © Your Website 2019</span>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </main>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/admin/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('js/admin/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('js/admin/demo/chart-area-demo.js') }}"></script>
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>

    {{-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> --}}
    <script>

const showElement = (element) => {
    $(`#${element}-text`).removeClass('custom-menu-item')
}

const hideElement = (element) => {
    $(`#${element}-text`).addClass('custom-menu-item')
}
        // Enable pusher logging - don't include this in production

        // Pusher.logToConsole = true;

        // var pusher = new Pusher('4d221fa1e35970a97f38', {
        //     cluster: 'sa1'
        // });

        // var channel = pusher.subscribe('notification');
        // channel.bind('notification', function(data) {
        //     let {room_name,status_new} = (JSON.stringify(data));
        //     setNotification(room_name,status_new)
        // });
        // var notification = new Array();

        // function setNotification(room_name,status_new) {
        //     notification.push(`
    //                 <p>La habitación: ${room_name} pasó a estado: ${status_new}</p>
    //             `)
        // }
        // function getN() {
        //     let string = ''
        //     notification.forEach(element => {
        //         string += element
        //     });
        //     return string
        // }

        // async function getNotifications(){
        //     try{
        //          let res = await axios.get('notifications')
        //         notification += await res.data.map(item => {
        //             console.log(item)
        //             setNotification(item.room_name,item.status_new)
        //         })

        //         return notification;
        //     }catch(err){
        //         console.log(err)
        //     }

        // }

        // $(document).ready(async function () {
        //     await getNotifications()
        //     $('#app2').append(getN())
        // });
    </script>

    @yield('scripts')
</body>

</html>
