@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h1>My Discoveries</h1>
            </div>
            <div class="col-sm-2">
                <a href="{{ route('discoveries.create') }}">Add new</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2">Name</th>
                            <th>Location</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($starSystems as $starSystem)
                            <tr>
                                <td class="star-icon">
                                    @if($starSystem->black_hole)
                                        <svg class="star star-blackhole">
                                            <title>Black hole system</title>
                                            <use xlink:href="{{ asset('img/sprite.svg') }}#star"/>
                                        </svg>
                                    @else
                                        <svg class="star star-{{ strtolower($starSystem->color) }}">
                                            <title>Class {{ $starSystem->class }} star system</title>
                                            <use xlink:href="{{ asset('img/sprite.svg') }}#star"/>
                                        </svg>
                                    @endif
                                </td>
                                <td>
                                    <a class="star-system-name" href="#">
                                        {{ $starSystem->name }}
                                    </a>
                                    <div class="text-muted small">
                                        {{ $starSystem->description }}
                                    </div>
                                </td>
                                <td>
                                    <div class="star-system-location">
                                        {{ $starSystem->coordinates }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $starSystem->gc_distance }} LY
                                    </div>
                                </td>
                                <td>
                                    {{ $starSystem->discoveredOnInTimezone($user->timezone)->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
