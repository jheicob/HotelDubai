@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <partialcost
         create="{{ Auth::user()->can('partial.cost.create') }}"
         deletet="{{ Auth::user()->can('partial.cost.delete') }}"
         updated="{{ Auth::user()->can('partial.cost.updated') }}"
    />
</div>
@endsection