@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <range-template create="{{ Auth::user()->can('range.template.create') }}"
            deletet="{{ Auth::user()->can('range.template.delete') }}"
            updated="{{ Auth::user()->can('range.template.updated') }}" />
    </div>
@endsection
