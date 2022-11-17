@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <extra-guest create="{{ Auth::user()->can('extra-guest.create') }}"
            deletet="{{ Auth::user()->can('extra-guest.delete') }}"
            updated="{{ Auth::user()->can('extra-guest.updated') }}" />
    </div>
@endsection
