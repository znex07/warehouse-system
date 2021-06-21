@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card py-5 text-center">
        @if (sizeof($cargo) > 0)
        <h1> Details for {{$cargo_code }} <label class="text-danger">{{$cargo[0]}}</label></h1>
        <img src="{{ asset('/img/in-transit.png') }}" class="img-thumbnail rounded mx-auto d-block" style="height: 150px; width:150px">
        @else
        <h1 class="text-danger">no record found</h1>
        <img src="{{ asset('/img/norecordfound.png') }}" class="img-thumbnail rounded mx-auto d-block" style="height: 150px; width:180px">
        @endif
    </div>
</div>
@endsection
