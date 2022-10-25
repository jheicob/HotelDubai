@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <invoice
        :create="'{{ Auth::user()->can('invoice.create') }}' == 1"
        :deletet="'{{ Auth::user()->can('invoice.delete') }}' == 1"
        :updated="'{{ Auth::user()->can('invoice.updated') }}' == 1"
        :cancel="'{{ Auth::user()->can('invoice.cancel') }}' == 1"
/>
</div>
@endsection
