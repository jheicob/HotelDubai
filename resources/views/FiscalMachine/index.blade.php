@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <fiscal-machine
         create="{{ Auth::user()->can(' FiscalMachines.create') }}"
         deletet="{{ Auth::user()->can('FiscalMachines.delete') }}"
         updated="{{ Auth::user()->can('FiscalMachines.updated') }}"
    ></fiscal-machine>
</div>
@endsection
