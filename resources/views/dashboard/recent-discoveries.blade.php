<div class="panel panel-default">
    <div class="panel-heading">Recent Discoveries</div>
    <div class="panel-body">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th colspan="2">Name</th>
                    <th>Location</th>
                    <th>Discoverer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDiscoveries as $starSystem)
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
                            <a href="#">{{ $starSystem->name }}</a>
                            @if($starSystem->description)
                                <div class="text-muted small">
                                    {{ $starSystem->description }}
                                </div>
                            @endif
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
                            @if($starSystem->discovered_on && $starSystem->discovered_by)
                                {{ $starSystem->discoveredOnInTimezone($user->timezone)->format('Y-m-d H:i') }}
                                <div class="text-muted small">
                                    {{ $starSystem->discovered_by->username }}
                                </div>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>


    </div>
</div>
