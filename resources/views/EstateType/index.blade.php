@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <estatetype
         create="{{ Auth::user()->can('estate.type.create') }}"
         deletet="{{ Auth::user()->can('estate.type.delete') }}"
         updated="{{ Auth::user()->can('estate.type.updated') }}"
    />
</div>
@endsection