@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            @include('dashboard.recent-discoveries')
        </div>
    </div>
</div>
@endsection
