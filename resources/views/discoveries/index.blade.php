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
                                <td>
                                    @if($starSystem->black_hole)
                                        <object type="image/svg+xml" data="{{ asset('img/star.svg') }}"
                                                class="star star-{{ strtolower($starSystem->color) }}"
                                        >STAR
                                        </object>
                                    @else
                                        <img src="{{ asset('img/star.svg') }}"
                                             alt="star icon"
                                             class="star star-{{ strtolower($starSystem->color) }}"
                                        />
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
