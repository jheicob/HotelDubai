@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <datetemplate
         create="{{    Auth::user()->can('date.templates.create') }}"
         deletet="{{  Auth::user()->can('date.templates.delete') }}"
         updated="{{  Auth::user()->can('date.templates.updated') }}"
    />
</div>
@endsection
