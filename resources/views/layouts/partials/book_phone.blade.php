@if ($model->hasTelephone())
<div class="box_style_4">
    <i class="icon_set_1_icon-90"></i>
    <h4><span>Book</span> by phone</h4>
    <a href="tel://{{ str_replace(' ', '', $model->getTelephone()) }}" class="phone">
        +{{ $model->getTelephone() }}
    </a>
    <small>Monday to Friday 9.00am - 7.30pm</small>
</div>
@endif