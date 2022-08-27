@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <roomstatus
         create="{{ Auth::user()->can('room.status.create') }}"
         deletet="{{ Auth::user()->can('room.status.delete') }}"
         updated="{{ Auth::user()->can('room.status.updated') }}"
    />
</div>
@endsection