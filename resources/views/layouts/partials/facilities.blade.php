<div class="row">
    <div class="col-md-6 col-sm-6">
        <ul class="list_ok">
            @for ($i = 0; $i < sizeof($facilities) / 2; $i++)
                <li>{{ $facilities[$i]['name'] }}</li>
            @endfor
        </ul>
    </div>
    <div class="col-md-6 col-sm-6">
        <ul class="list_ok">
            @for ($i = sizeof($facilities) / 2; $i < sizeof($facilities); $i++)
                <li>{{ $facilities[$i]['name'] }}</li>
            @endfor
        </ul>
    </div>
</div>