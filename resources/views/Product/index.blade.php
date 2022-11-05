@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <product create="{{ Auth::user()->can('product.create') }}" deletet="{{ Auth::user()->can('product.delete') }}"
            updated="{{ Auth::user()->can('product.updated') }}" />
    </div>
@endsection
