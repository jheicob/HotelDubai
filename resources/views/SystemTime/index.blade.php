@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <systemtime
         create="{{ Auth::user()->can('system.time.create') }}"
         deletet="{{ Auth::user()->can('system.time.delete') }}"
         updated="{{ Auth::user()->can('system.time.updated') }}"
    />
</div>
@endsection