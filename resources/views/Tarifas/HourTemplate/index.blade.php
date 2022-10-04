@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <hour-template
         create="{{ Auth::user()->can('hour.templates.create') }}"
         deletet="{{ Auth::user()->can('hour.templates.delete') }}"
         updated="{{ Auth::user()->can('hour.templates.updated') }}"
    />
</div>
@endsection
