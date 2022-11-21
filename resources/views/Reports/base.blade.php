<style>
    body {
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
        width: 100%
    }

    td,
    th {
        border: 1px solid black;
    }
</style>
<img src="img/Logo-Dubai-Suites.png" style="float: left;" width="200px">
<br>
<h2 align="center">Hotel Dubai</h2>
<br>
<h3 align='center'>
    Desde: <span style="font-weight: normal">{{$date_start}}</span> . Hasta: <span style="font-weight: normal">{{$date_end}}</span>
</h3>
@yield('content')
