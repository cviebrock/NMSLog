@if($starSystem->black_hole)
    <svg class="star star-blackhole">
        <title>Black hole system</title>
        <use xlink:href="#sprite-blackhole"/>
    </svg>
@elseif($starSystem->atlas_interface)
    <svg class="star star-atlas">
        <title>Atlas Interface system</title>
        <use xlink:href="#sprite-atlas"/>
    </svg>
@else
    <svg class="star star-{{ strtolower($starSystem->color) }}">
        <title>Class {{ $starSystem->class }} star system</title>
        <use xlink:href="#sprite-star"/>
    </svg>
@endif
