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
<table style="">
    <thead>
        <tr>
            <th>Tipo Documento </th>
            <th>Documento</th>
            <th>Nombre </th>
            <th>Apellido </th>
            <th>Telefono</th>
            <th>Correo electrónico</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td>{{ $client->typeDocument->name }}</td>
                <td>{{ $client->document }}</td>
                <td>{{ $client->first_name }}</td>
                <td>{{ $client->last_name }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
