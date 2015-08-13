@for ($i = 1; $i <= 5; $i++)
    <i class="@if ($rating > $i || $rating == $i) {{ $class or 'icon-star' }} voted @elseif($rating == $i - 0.5) icon-star-half @else icon-star-empty @endif"></i>
@endfor