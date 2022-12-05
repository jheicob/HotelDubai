@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="app">
        <product-category create="{{ Auth::user()->can('ProductCategoryt.create') }}"
            deletet="{{ Auth::user()->can('ProductCategory.delete') }}"
            updated="{{ Auth::user()->can('ProductCategory.updated') }}" />
    </div>
@endsection
