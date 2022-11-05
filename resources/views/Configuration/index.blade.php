@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <configuration  
            updated="{{ Auth::user()->can('configuration.upsert') == '1' }}" />
    </div>
@endsection
