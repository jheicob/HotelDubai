@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <invoice
        create={{ Auth::user()->can('invoice.create') }}
        deletet={{ Auth::user()->can('invoice.delete') }}
        updated={{ Auth::user()->can('invoice.updated') }}
    />
</div>
@endsection
