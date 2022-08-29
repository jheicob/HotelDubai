@extends('layouts.app')

@section('content')
<div class="container-fluid" id="app">
    <dayweek
         create="{{ Auth::user()->can('day.week.create') }}"
         deletet="{{ Auth::user()->can('day.week.delete') }}"
         updated="{{ Auth::user()->can('day.week.updated') }}"
    />
</div>
@endsection