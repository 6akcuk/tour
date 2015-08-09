@for ($i = 1; $i <= 5; $i++)
    <i class="@if (($rating > $i && $rating >= $i + 1) || $rating == $i) icon-star voted @elseif($rating > $i) icon-star-half @else icon-star-empty @endif"></i>
@endfor