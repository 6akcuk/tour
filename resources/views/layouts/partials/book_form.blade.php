<div class="box_style_1 expose">
    {!! Form::open(['route' => ['booking.quote', $type, $model->getTXAShortName()]]) !!}
    {!! Form::hidden('id', $model->getId()) !!}
    <h3 class="inner">Check Availability</h3>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label><i class="icon-calendar-7"></i> Check in</label>
                <input name="check_in" class="date-pick form-control" data-date-format="M d, D" type="text">
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label><i class="icon-calendar-7"></i> Check out</label>
                <input name="check_out" class="date-pick form-control" data-date-format="M d, D" type="text">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>Adults</label>
                <div class="numbers-row">
                    <input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>Children</label>
                <div class="numbers-row">
                    <input type="text" value="0" id="children" class="qty2 form-control" name="childs">
                </div>
            </div>
        </div>
    </div>
    <br>

    <button class="btn_full">Check now</button>
    {!! Form::close() !!}
</div><!--/box_style_1 -->