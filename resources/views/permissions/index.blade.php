@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">    
    <permissions 
         create="{{ Auth::user()->can('permissions.create') }}"
         deletet="{{ Auth::user()->can('permissions.delete') }}"
         updated="{{ Auth::user()->can('permissions.updated') }}"
    />    
</div>
@endsection