<div id="single_tour_feat">
    <ul>
        @if ($model->hasAttribute('BAR'))
            <li>
                <i class="icon_set_1_icon-20"></i>
                Bar
            </li>
        @endif
        @if ($model->hasAttribute('GYM'))
            <li>
                <i class="icon_set_2_icon-117"></i>
                Gym
            </li>
        @endif
        @if ($model->hasAttribute('TVLOUNGE'))
            <li>
                <i class="icon_set_2_icon-116"></i>
                TV/Lounge
            </li>
        @endif
        @if ($model->hasAttribute('FREEWIFI'))
            <li>
                <i class="icon_set_1_icon-86"></i>
                Free Wifi
            </li>
        @endif
        @if ($model->hasAttribute('PICNIC'))
            <li>
                <i class="icon_set_1_icon-8"></i>
                Picnic
            </li>
        @endif
        @if ($model->hasAttribute('PLAYGROUND'))
            <li>
                <i class="icon_set_1_icon-3"></i>
                Playground
            </li>
        @endif
        @if ($model->hasAttribute('POOL') || $model->hasAttribute('POOLHEATED') || $model->hasAttribute('POOLINDOOR'))
            <li>
                <i class="icon_set_2_icon-110"></i>
                Pool
            </li>
        @endif
        @if ($model->hasAttribute('PETALLOW'))
            <li>
                <i class="icon_set_1_icon-22"></i>
                Pet allowed
            </li>
        @endif
        @if ($model->hasAttribute('DISNOASST'))
            <li>
                <i class="icon_set_1_icon-13"></i>
                Accessibility
            </li>
        @endif
        @if ($model->hasAttribute('CARPARK') || $model->hasAttribute('PARKING'))
            <li>
                <i class="icon_set_1_icon-27"></i>
                Parking
            </li>
        @endif
    </ul>
</div>