@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <partialrates
         create="{{ Auth::user()->can('partial.rates.create') }}"
         deletet="{{ Auth::user()->can('partial.rates.delete') }}"
         updated="{{ Auth::user()->can('partial.rates.updated') }}"
    />
</div>
@endsection