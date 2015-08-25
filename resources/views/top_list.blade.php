@if (isset($tours))
    @foreach ($tours['products'] as $tour)
        @include('tours.partials.grid_element', ['columns' => 3])
    @endforeach
@elseif (isset($attractions))
    @foreach ($attractions['products'] as $attraction)
        @include('attractions.partials.grid_element', ['columns' => 3])
    @endforeach
@elseif (isset($events))
    @foreach ($events['products'] as $event)
        @include('events.partials.grid_element', ['columns' => 3])
    @endforeach
@elseif (isset($hires))
    @foreach ($hires['products'] as $hire)
        @include('hires.partials.grid_element', ['columns' => 3])
    @endforeach
@endif