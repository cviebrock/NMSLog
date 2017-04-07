@extends('layouts.app')

@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/threejs/r84/three.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            @include('dashboard.recent-discoveries')
        </div>
    </div>
</div>
@endsection
