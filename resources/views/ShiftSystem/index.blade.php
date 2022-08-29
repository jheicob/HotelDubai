@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <shiftsystem
         create="{{ Auth::user()->can('shift.system.create') }}"
         deletet="{{ Auth::user()->can('shift.system.delete') }}"
         updated="{{ Auth::user()->can('shift.system.updated') }}"
    />
</div>
@endsection