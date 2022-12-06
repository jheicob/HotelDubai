@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <create-invoice
        :fiscal_machine_id="'{{session('fiscal_machines')}}'"
    ></create-invoice>
    </div>
@endsection
