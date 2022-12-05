@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <room :create="'{{ Auth::user()->can('room.create') }}' == 1"
            :deletet="'{{ Auth::user()->can('room.delete') }}' == 1"
            :updated="'{{ Auth::user()->can('room.updated') }}' == 1"
            :ocuppy="'{{ Auth::user()->can('room.occuppy') }}' == 1" :free="'{{ Auth::user()->can('room.free') }}' == 1"
            :extend="'{{ Auth::user()->can('room.extend') }}' == 1" :clean="'{{ Auth::user()->can('room.clean') }}' == 1"
            :change_parcial="'{{ Auth::user()->can('room.changeParcial') }}' == 1"
            :repair="'{{ Auth::user()->can('room.repair') }}' == 1"
            :in_repair="'{{ Auth::user()->can('room.in_repair') }}' == 1"
            :role="'{{ Auth::user()->roles->first()->name }}'"
            :estate_type_id="'{{session('estate_type_id')}}'"
            :fiscal_machine_id="'{{session('fiscal_machines')}}'"
            :in_view_rooms="true"
            />
    </div>
@endsection
