<?php
    $booking = true;
?>

@extends('layouts.main')

@section('breadcrumbs')
    <li>Booking Quote</li>
@endsection

@section('content')
    <div class="row">
        @if (isset($quote->ProviderRS) && isset($quote->ProviderRS->id))
            {!! Form::open(['route' => 'booking.make', 'id' => 'book-form', 'onsubmit' => 'return checkForm()']) !!}
            {!! Form::hidden('product_id', $quote->ProviderRS->id) !!}
            {!! Form::hidden('type', $type) !!}
            {!! Form::hidden('short_name', $shortName) !!}
            {!! Form::hidden('provider_name', Request::input('provider_name')) !!}
            {!! Form::hidden('contact_phone', Request::input('contact_phone')) !!}

            {!! Form::hidden('check_in', \Carbon\Carbon::parse(Request::input('check_in'))->format('Y-m-d')) !!}
            {!! Form::hidden('check_out', \Carbon\Carbon::parse(Request::input('check_out'))->format('Y-m-d')) !!}
            {!! Form::hidden('adults', Request::input('adults')) !!}
            {!! Form::hidden('childs', Request::input('childs')) !!}
            {!! Form::hidden('id', Request::input('id')) !!}

            <div id="quote-form" class="col-md-8">
                <div class="alert alert-info" role="alert">
                    @if ($type == 'accommodation')
                    <strong>Rooms available</strong> for the selected dates.
                    <br>PLEASE SELECT YOUR ROOM.
                    @elseif ($type == 'tours')
                    <strong>Tours available</strong> for the selected dates.
                    <br>PLEASE SELECT TOUR.
                    @else
                    <strong>{{ ucfirst($type) }} available</strong> for the selected dates.
                    <br>PLEASE SELECT {{ strtoupper($type) }}
                    @endif
                </div>

                <div class="alert alert-warning" role="alert" style="display: none">
                    @if ($type == 'accommodation')
                    Please select room.
                    @elseif ($type == 'tours')
                    Please select tour.
                    @else
                    Please select one.
                    @endif
                </div>

                <table class="table table-striped cart-list add_bottom_30">
                    <thead>
                    <tr>
                        <th>Choose One</th>
                        <th>
                            @if ($type == 'accommodation')
                            Room Type
                            @elseif ($type == 'tours')
                            Tour
                            @else
                                {{ ucfirst($type) }}
                            @endif
                        </th>
                        <th>
                            @if ($type == 'accommodation')
                            Per night
                            @else
                            Price
                            @endif
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $products = is_array($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product) ? $quote->ProviderRS->ProductGroups->ProductGroups->Products->Product : [$quote->ProviderRS->ProductGroups->ProductGroups->Products->Product];
                    ?>
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <input id="room_{{ $product->id }}" type="radio" name="room" value="{{ $product->id }}" @if (!isset($product->Quotes->Quote)) disabled @endif>
                        </td>
                        <td>
                            <span class="item-cart">
                                <label for="room_{{ $product->id }}">
                                    {{ $product->name }}
                                </label>
                            </span>
                        </td>
                        <td>
                            @if (isset($product->Quotes->Quote))
                                @if (!is_array($product->Quotes->Quote))
                                    <strong>AUD ${{ $type == 'accommodation' ? round($product->Quotes->Quote->price / $product->Quotes->Quote->nights, 2) : $product->Quotes->Quote->price }}</strong>
                                @else
                                    @foreach ($product->Quotes->Quote as $idx => $qt)
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <input type="radio" id="quote_{{ $product->id }}_{{ $idx }}" name="quote[{{ $product->id }}]" value="{{ $idx }}">
                                            </div>
                                            <div class="col-sm-10">
                                                <label for="quote_{{ $product->id }}_{{ $idx }}">
                                                    Start: <span class="start">{{ Carbon\Carbon::parse($qt->start_date)->formatLocalized('%d %b %Y at %H:%M') }}</span><br>
                                                    Finish: <span class="finish">{{ Carbon\Carbon::parse($qt->finish_date)->formatLocalized('%d %b %Y at %H:%M') }}</span><br>
                                                    <strong>AUD ${{ $qt->price }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                Not Available
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                @if ($type == 'accommodation')
                <table class="table table-striped options_cart">
                    <thead>
                    <tr>
                        <th colspan="3">
                            Add options / Services
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="2" class="text-center">- Select room first -</td>
                    </tr>
                    </tbody>
                </table>

                <div id="select-night-info" class="alert alert-info hidden">
                    Please select nights for this option.
                </div>

                <table class="table table-striped cart-list">
                    <thead>
                    <tr>
                        <th>Selected Nights</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="selectedDates">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <small>* Prices for person.</small> <br>
                <small>** Prices for night.</small> <br>
                <small>*** Prices for person and for night.</small> <br>
                <small>**** Prices for person and for selected night.</small> <br>
                <small>***** Prices for selected night.</small>
                @endif
            </div>

            <div id="info-form" class="col-md-8" style="display: none">
                <div class="form_title">
                    <h3><strong>1</strong>Your Details</h3>
                    <p>

                    </p>
                </div>
                <div class="step">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" class="form-control" id="firstname_booking" name="firstname_booking" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" class="form-control" id="lastname_booking" name="lastname_booking" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email_booking" name="email_booking" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Confirm email</label>
                                <input type="email" id="email_booking_2" name="email_booking_2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" id="telephone_booking" name="telephone_booking" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div><!--End step -->

                <div class="form_title">
                    <h3><strong>2</strong>Payment Information</h3>
                    <p>

                    </p>
                </div>
                <div class="step">
                    <div class="form-group">
                        <label>Name on card</label>
                        <input type="text" class="form-control" id="name_card_booking" name="name_card_booking" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Card number</label>
                                <input type="text" id="card_number" name="card_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @foreach ($provider->ECommerceDetails->CreditCardAccepted as $card)
                                @if ($card->type == 'MASTERCARD')
                                    <img class="cards" src="img/payments/Mastercard.png">
                                @elseif ($card->type == 'VISA')
                                    <img class="cards" src="img/payments/Visa.png">
                                @elseif ($card->type == 'AMERICANEXPRESS')
                                    <img class="cards" src="img/payments/Amex.png">
                                @elseif ($card->type == 'DINERS')
                                    <img class="cards" src="img/payments/Diners Club.png">
                                @elseif ($card->type == 'DISCOVER')
                                    <img class="cards" src="img/payments/Discover.png">
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Expiration date</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="MM" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="expire_year" name="expire_year" class="form-control" placeholder="YY" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Security code</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" id="ccv" name="ccv" class="form-control" placeholder="CCV" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <img src="img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>Last 3 digits</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--End row -->

                </div><!--End step -->

                <div class="form_title">
                    <h3><strong>3</strong>Billing Address</h3>
                    <p>

                    </p>
                </div>
                <div class="step">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country" id="country" required>
                                    <option value="" selected>Select your country</option>
                                    <option value="Australia">Australia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Street line 1</label>
                                <input type="text" id="street_1" name="street_1" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Street line 2</label>
                                <input type="text" id="street_2" name="street_2" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" id="city_booking" name="city_booking" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" id="state_booking" name="state_booking" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Postal code</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                    </div><!--End row -->
                </div><!--End step -->

                <div id="policy">
                    <h4>Booking Terms</h4>
                    <div class="form-group">
                        {!! $provider->BookingDetails->BookingTerms !!}
                    </div>
                    <h4>Conditions of Use</h4>
                    <div class="form-group">
                        {!! $provider->BookingDetails->ConditionsOfUse !!}
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="policy_terms" id="policy_terms" required>I accept terms and conditions.</label>
                    </div>
                    <button class="btn_1 green medium">Book now</button>
                </div>
            </div>

            <aside class="col-md-4">
                <div class="box_style_1">
                    <h3 class="inner">- Summary -</h3>
                    <table class="table table_summary">
                        <tbody>
                        <tr>
                            <td>
                                Check in
                            </td>
                            <td id="check_in" class="text-right">
                                {{ Carbon\Carbon::parse(Request::input('check_in'))->formatLocalized('%d %b %Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Check out
                            </td>
                            <td id="check_out" class="text-right">
                                {{ Carbon\Carbon::parse(Request::input('check_out'))->formatLocalized('%d %b %Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if ($type == 'accommodation') Rooms
                                @elseif ($type == 'tours') Tour
                                @else {{ ucfirst($type) }}
                                @endif
                            </td>
                            <td id="rooms" class="text-right"></td>
                        </tr>
                        <tr>
                            <td>
                                Nights
                            </td>
                            <td class="text-right">
                                {{ Carbon\Carbon::parse(Request::input('check_out'))->diffInDays(Carbon\Carbon::parse(Request::input('check_in'))) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Adults
                            </td>
                            <td class="text-right">
                                {{ Request::input('adults') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Children
                            </td>
                            <td class="text-right">
                                {{ Request::input('childs') }}
                            </td>
                        </tr>
                        <tr class="total">
                            <td>
                                Total cost
                            </td>
                            <td class="text-right">
                                $0
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <a id="details-btn" onclick="checkForm()" class="btn_full">Set Details</a>
                    <?php
                        if ($type == 'attraction') $route = 'attractions.show';
                        else $route = "$type.show";
                    ?>
                    <a class="btn_full_outline" href="{{ route($route, Request::input('id')) }}"><i class="icon-right"></i> Modify your search</a>
                </div>

                <div class="box_style_4">
                    <i class="icon_set_1_icon-57"></i>
                    <h4>Need <span>Help?</span></h4>
                    <a href="tel://{{ str_replace(' ', '', Request::input('contact_phone')) }}" class="phone">
                        +{{ Request::input('contact_phone') }}
                    </a>
                    <small>Monday to Friday 9.00am - 7.30pm</small>
                </div>
            </aside><!-- End aside -->
            {!! Form::close() !!}
        @else
            @if (isset($quote->Status->Errors))
            <div class="alert alert-danger">
                {{ $quote->Status->Errors->Error->Message }}
                <br>
                <a href="{{ route($type .'.show', Request::input('id')) }}">Go Back</a>
            </div>
            @elseif (isset($quote->Status->Warnings))
            <div class="alert alert-warning">
                {{ $quote->Status->Warnings->Warning->Message }}
                <br>
                <a href="{{ route($type .'.show', Request::input('id')) }}">Go Back</a>
            </div>
            @else
            <div class="alert alert-info">
                Nothing found. Please, set another parameters.
                <br>
                <a href="{{ route($type .'.show', Request::input('id')) }}">Go Back</a>
            </div>
            @endif
        @endif
    </div>
@endsection

@section('header_css')
    <link href="css/jquery.switch.css" rel="stylesheet">
@endsection

@section('footer_javascript')
    @if (isset($quote->ProviderRS) && isset($quote->ProviderRS->id))
    <script src="js/icheck.js"></script>
    <script>
        $('#policy_terms').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>

    <script src="js/jquery.validate.js"></script>
    <script>
        var adults = {{ (int)Request::input('adults') }};
        var childs = {{ (int)Request::input('childs') }};
        var nights = {{ (int)Carbon\Carbon::parse(Request::input('check_out'))->diffInDays(Carbon\Carbon::parse(Request::input('check_in'))) }};
        var options = {!! isset($quote->ProviderRS->BookingExtraOptions) ? json_encode($quote->ProviderRS->BookingExtraOptions->BookingExtraOption) : '[]' !!};
        var rooms = {!! json_encode(is_array($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product) ? $quote->ProviderRS->ProductGroups->ProductGroups->Products->Product : [$quote->ProviderRS->ProductGroups->ProductGroups->Products->Product]) !!};
        var state = 'quote';

        function mathPrice() {
            var price = 0;
            $('table.table_summary [price]').each(function() {
                price += parseFloat($(this).attr('price'));
            });

            $('table.table_summary .total td.text-right').text('$'+ price.toFixed(2));
        }

        function checkForm() {
            if (state == 'quote') {

                if ($('input[name="room"]:checked').length) {
                    state = 'info';
                    $('#quote-form, #details-btn').hide();
                    $('#info-form').slideDown();
                } else {
                    $('.alert-warning').show();
                }

                return false;
            }
            else if (state == 'info') {
                if (!$('#book-form').valid()) {
                    return false;
                }
            }

            return true;
        }

        function optionChanged(el) {
            var oid = $(el).attr('id').replace(/option_/, '');

            $('#' + oid).remove();

            if (!$(el).is(':checked')) {

            } else {
                var option = null;

                if (options.length) {
                    $.each(options, function (i, _option) {
                        if (_option.id == oid) option = _option;
                    });
                }
                else option = options;

                var price = 0;
                var selectedNights = $('input[name="selectedDates"]').val() != '' ? $('input[name="selectedDates"]').val().split(',').length : 0;

                if (option.OccupancyCharge) {
                    var op = option.OccupancyCharge;

                    if (op.type == 'Once_Off')
                        price += parseFloat(option.OccupancyCharge.per_adult_price) * adults +
                                 parseFloat(option.OccupancyCharge.per_child_price) * childs;
                    else if (op.type == 'Per_Night')
                        price += (parseFloat(option.OccupancyCharge.per_adult_price) * adults +
                                 parseFloat(option.OccupancyCharge.per_child_price) * childs) * nights;
                    else if (op.type == 'Per_Selected_Night') {
                        price += (parseFloat(option.OccupancyCharge.per_adult_price) * adults +
                                parseFloat(option.OccupancyCharge.per_child_price) * childs) * selectedNights;

                        if (parseInt(selectedNights) == 0) $('#select-night-info').removeClass('hidden');
                    }
                }
                else if (option.FlatCharge) {
                    var op = option.FlatCharge;

                    if (op.type == 'Once_Off')
                        price += parseFloat(op.price);
                    else if (op.type == 'Per_Night')
                        price += parseFloat(op.price) * nights;
                    else if (op.type == 'Per_Selected_Night') {
                        price += parseFloat(op.price) * selectedNights;

                        if (parseInt(selectedNights) == 0) $('#select-night-info').removeClass('hidden');
                    }
                }
                else if (option.UnitCharge) {
                    var op = option.UnitCharge;
                    var unit = parseInt($('input[name="unit['+ oid + ']"]').val());

                    if (op.type == 'Once_Off')
                        price += parseFloat(op.per_unit_price) * unit;
                    else if (op.type == 'Per_Night')
                        price += parseFloat(op.per_unit_price) * unit * nights;
                    else if (op.type == 'Per_Selected_Night') {
                        price += parseFloat(op.per_unit_price) * unit * selectedNights;

                        if (parseInt(selectedNights) == 0) $('#select-night-info').removeClass('hidden');
                    }
                }

                $('<tr id="' + oid + '" price="' + price + '"><td>' + option.name + (typeof unit != 'undefined' ? ' x'+ unit : '') + '</td><td class="text-right">$' + price + '</td></tr>')
                        .insertBefore('tr.total');
            }

            mathPrice();
        }

        $(document).ready(function() {
            $('input[name="selectedDates"]').datepicker({
                multidate: true,
                autoclose: false
            }).on('changeDate', function() {
                $('#select-night-info').addClass('hidden');
                $('input[name*="option"]:checked').change();
            });

            $('input[name="room"]').change(function() {
                var pid = $(this).val();

                $('#'+ pid).remove();

                $('input[name="quote['+ pid +']"]').first().prop('checked', true);

                var room = null;
                $.each(rooms, function(i, _room) {
                    if (_room.id == pid) room = _room;
                });

                //$('<div id="'+ pid +'" price="'+ (room.Quotes.Quote.price) +'">1 '+ room.name + '</div>').appendTo($('#rooms'));
                if (room.Quotes.Quote.length) {
                    var idx = $('input[name="quote['+ pid +']"]:checked').val();
                    $('#rooms').attr('price', room.Quotes.Quote[idx].price).text(room.name);
                }
                else {
                    $('#rooms').attr('price', room.Quotes.Quote.price).text(room.name);
                }

                var options_html = [];

                function _option(option) {
                    var priceText = '+$';
                    var selector = '';

                    if (option.OccupancyCharge) {
                        var op = option.OccupancyCharge;

                        priceText += op.per_adult_price;

                        if (op.type == 'Once_Off') {
                            priceText += '*';
                        }
                        else if (op.type == 'Per_Night') {
                            priceText += '***';
                        }
                        else if (op.type == 'Per_Selected_Night') {
                            priceText += '****';
                        }
                    }
                    else if (option.FlatCharge) {
                        var op = option.FlatCharge;

                        priceText += op.price;

                        if (op.type == 'Once_Off') {
                        }
                        else if (op.type == 'Per_Night') {
                            priceText += '**';
                        }
                        else if (op.type == 'Per_Selected_Night') {
                            priceText += '*****';
                        }
                    }
                    else if (option.UnitCharge) {
                        var op = option.UnitCharge;

                        priceText += op.per_unit_price;

                        if (op.type == 'Per_Night') {
                            priceText += '**';
                        }
                        else if (op.type == 'Per_Selected_Night') {
                            priceText += '*****';
                        }

                        selector = '\
                                        <div class="numbers-row numbers-row-small pull-right">\
                                        <input type="text" value="1" max="' + op.max_unit + '" class="qty2 form-control" name="unit[' + option.id + ']">\
                                        </div>\
                                        ';
                    }

                    return ('\
                                    <tr>\
                                        <td>\
                                            ' + option.name + '\
                                            <strong>\
                                            ' + priceText + '\
                                            </strong>\
                                        </td>\
                                        <td>\
                                            <label class="switch-light switch-ios pull-right">\
                                                <input type="checkbox" name="option[' + option.id + ']" id="option_' + option.id + '" onchange="optionChanged(this)" value="1">\
                                                <span>\
                                                <span>No</span>\
                                                <span>Yes</span>\
                                                </span>\
                                                <a></a>\
                                            </label>\
                                            ' + selector + '\
                                        </td>\
                                    </tr>');
                }

                if (room.Quotes.Quote.BookingExtras) {
                    if (room.Quotes.Quote.BookingExtras.BookingExtra.length) {
                        $.each(room.Quotes.Quote.BookingExtras.BookingExtra, function (i, extra) {
                            $.each(options, function (j, option) {
                                if (option.id == extra.booking_extra_option_id) {
                                    options_html.push(_option(option));
                                }
                            });
                        });
                    } else {
                        if (options.id == room.Quotes.Quote.BookingExtras.BookingExtra.booking_extra_option_id) {
                            options_html.push(_option(options));
                        }
                    }
                } else options_html.push('<tr><td class="text-center" colspan="2">No available booking extras found.</td></tr>');

                $('table.options_cart tbody').html(options_html.join(''));

                $(".numbers-row").append('<div class="inc button_inc">+</div><div class="dec button_inc">-</div>');
                $(".numbers-row-small .button_inc").on("click",function() {
                    var $button = $(this);
                    var $input = $button.parent().find("input");
                    var oid = $input.attr('name').replace(/unit\[(\w+)\]/, '$1');
                    var oldValue = $input.val();
                    var newVal = 0;
                    var maxValue = parseInt($input.attr('max'));

                    if($button.text()=="+") {
                        newVal=parseFloat(oldValue)+1;
                        if (parseInt(newVal) > maxValue) {
                            newVal = maxValue;
                        }
                    }
                    else {
                        if(oldValue>1) {
                            newVal = parseFloat(oldValue)-1;
                        }
                        else {
                            newVal = 1;
                        }
                    }

                    $input.val(newVal);

                    optionChanged($('#option_'+ oid));
                });

                mathPrice();
            });

            $('input[name*="quote"]').change(function() {
                var pid = $(this).attr('name').replace(/quote\[(.*)\]/, '$1');

                var room = null;
                $.each(rooms, function(i, _room) {
                    if (_room.id == pid) room = _room;
                });

                var idx = $(this).val();
                $('#rooms').attr('price', room.Quotes.Quote[idx].price);

                $('#check_in').text($(this).parent().next().find('span.start').text());
                $('#check_out').text($(this).parent().next().find('span.finish').text());

                mathPrice();
            });
        });
    </script>
    @endif
@endsection