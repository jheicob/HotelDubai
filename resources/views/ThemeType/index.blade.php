@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <themetype
         create="{{ Auth::user()->can('theme.type.create') }}"
         deletet="{{ Auth::user()->can('theme.type.delete') }}"
         updated="{{ Auth::user()->can('theme.type.updated') }}"
    />
</div>
@endsection