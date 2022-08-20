@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <roomtype
         create="{{ Auth::user()->can('room.type.create') }}"
         deletet="{{ Auth::user()->can('room.type.delete') }}"
         updated="{{ Auth::user()->can('room.type.updated') }}"
    />
</div>
@endsection