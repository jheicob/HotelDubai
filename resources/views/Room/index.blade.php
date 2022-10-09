@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <room
         create={{ Auth::user()->can('room.create') }}
         deletet={{ Auth::user()->can('room.delete') }}
         updated={{ Auth::user()->can('room.updated') }}
    />
</div>
@endsection
