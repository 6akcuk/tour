<?php
    if (!$exclude) $exclude = [];
?>

@foreach (Request::all() as $key => $value)
    <?php if (in_array($key, $exclude)) continue; ?>
    @if (is_array($value))
        @foreach ($value as $value2)
            <input type="hidden" name="{{ $key }}[]" value="{{ $value2 }}">
        @endforeach
    @else
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endif
@endforeach