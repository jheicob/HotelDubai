@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">    
    <roles
         create="{{ Auth::user()->can('roles.create') }}"
         deletet="{{ Auth::user()->can('roles.delete') }}"
         updated="{{ Auth::user()->can('roles.updated') }}"
     />     
</div>
@endsection