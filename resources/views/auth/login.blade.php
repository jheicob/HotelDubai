<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin/sb-admin.css') }}" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" defer></script>


</head>

<body class="">

    <div class="container" id="app">
        <div class="card card-login mx-auto mt-5" style="
            background-color: transparent;
        ">
            <div class="card-header text-center"
                style="
            font-weight: bold;
    background-color: rgba(255,255,255,0.6);
">Iniciar Sesión
            </div>
            <div class="card-body" style="background-color: rgba(255,255,255,.2);" >
                <form method="POST" action="{{ route('login') }}" >
                    @csrf

                    <login :remember="{{old('remember') ?? false}}"></login>

                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Login') }}
                    </button>
                </form>
                <div class="text-center">
                    <a class="d-block small" style="color:dark" href="{{ route('password.request') }}">Recuperar
                        Contraseña?</a>
                    <img src="img/Logo.png">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

</body>

</html>
