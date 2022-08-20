@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <users 
         create="{{ Auth::user()->can('users.create') }}"
         deletet="{{ Auth::user()->can('users.delete') }}"
         updated="{{ Auth::user()->can('users.updated') }}"
          />
    </div>
@endsection
