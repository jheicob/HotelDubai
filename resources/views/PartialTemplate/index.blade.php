@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <partialtemplate
         create="{{ Auth::user()->can('partial.templates.create') }}"
         deletet="{{ Auth::user()->can('partial.templates.delete') }}"
         updated="{{ Auth::user()->can('partial.templates.updated') }}"
    />
</div>
@endsection