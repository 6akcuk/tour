<?php
    $booking = true;
?>

@extends('layouts.main')

@section('breadcrumbs')
    <li>Booking Quote</li>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['route' => 'booking.make', 'id' => 'book-form', 'onsubmit' => 'return checkForm()']) !!}
        {!! Form::hidden('product_id', $quote->ProviderRS->id) !!}
        {!! Form::hidden('type', $type) !!}
        {!! Form::hidden('short_name', $shortName) !!}

        {!! Form::hidden('check_in', \Carbon\Carbon::parse(Request::input('check_in'))->format('Y-m-d')) !!}
        {!! Form::hidden('check_out', \Carbon\Carbon::parse(Request::input('check_out'))->format('Y-m-d')) !!}
        {!! Form::hidden('adults', Request::input('adults')) !!}
        {!! Form::hidden('childs', Request::input('childs')) !!}
        {!! Form::hidden('id', Request::input('id')) !!}

        <div id="quote-form" class="col-md-8">
            <div class="alert alert-info" role="alert">
                <strong>Rooms available</strong> for the selected dates.
                <br>PLEASE SELECT YOUR QUANTITY.
            </div>

            <div class="alert alert-warning" role="alert" style="display: none">
                Select your quantity.
            </div>

            <table class="table table-striped cart-list add_bottom_30">
                <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Quantity</th>
                    <th>Per night</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product as $product)
                <tr>
                    <td>
                        <span class="item-cart">
                            <a href="">
                                {{ $product->name }}
                            </a>
                        </span>
                    </td>
                    <td>
                        <div class="numbers-row">
                            <input type="text" value="0" class="qty2 form-control" name="quantity[{{ $product->id }}]">
                        </div>
                    </td>
                    <td>
                        <strong>AUD ${{ round($product->Quotes->Quote->price / $product->Quotes->Quote->nights, 2) }}</strong>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <table class="table table-striped options_cart">
                <thead>
                <tr>
                    <th colspan="3">
                        Add options / Services
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($quote->ProviderRS->BookingExtraOptions->BookingExtraOption as $option)
                    <tr>
                        <td>
                            {{ $option->name }}
                            <strong>
                                @if (isset($option->OccupancyCharge))
                                    +${{ $option->OccupancyCharge->per_adult_price }}*
                                @elseif (isset($option->FlatCharge))
                                    +${{ $option->FlatCharge->price }}
                                @elseif (isset($option->UnitCharge))
                                    +${{ $option->UnitCharge->per_unit_price }}**
                                @endif
                            </strong>
                        </td>
                        <td>
                            <label class="switch-light switch-ios pull-right">
                                <input type="checkbox" name="option_{{ $option->id }}" id="option_{{ $option->id }}" value="1">
                                <span>
                                <span>No</span>
                                <span>Yes</span>
                                </span>
                                <a></a>
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <small>* Prices for person.</small> <br>
            <small>** Prices for night.</small>
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
                        <img src="img/cards.png" width="207" height="43" alt="Cards" class="cards">
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
                                    <input type="text" id="expire_year" name="expire_year" class="form-control" placeholder="Year" required>
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

                <hr>

                <h4>Or checkout with Paypal</h4>
                <p>
                </p>
                <p>
                    <img src="img/paypal_bt.png" alt="">
                </p>
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
                <h4>Cancellation policy</h4>
                <div class="form-group">
                    <label><input type="checkbox" name="policy_terms" id="policy_terms" required>I accept terms and conditions and general policy.</label>
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
                        <td class="text-right">
                            {{ Carbon\Carbon::parse(Request::input('check_in'))->formatLocalized('%d %B %Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Check out
                        </td>
                        <td class="text-right">
                            {{ Carbon\Carbon::parse(Request::input('check_out'))->formatLocalized('%d %B %Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Rooms
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
                <a class="btn_full_outline" href="{{ route("$type.show", Request::input('id')) }}"><i class="icon-right"></i> Modify your search</a>
            </div>

            <div class="box_style_4">
                <i class="icon_set_1_icon-57"></i>
                <h4>Need <span>Help?</span></h4>
                <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                <small>Monday to Friday 9.00am - 7.30pm</small>
            </div>
        </aside><!-- End aside -->
        {!! Form::close() !!}
    </div>
@endsection

@section('header_css')
    <link href="css/jquery.switch.css" rel="stylesheet">
@endsection

@section('footer_javascript')
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
        var options = {!! json_encode($quote->ProviderRS->BookingExtraOptions->BookingExtraOption) !!};
        var rooms = {!! json_encode($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product) !!};
        var state = 'quote';

        function mathPrice() {
            var price = 0;
            $('table.table_summary [price]').each(function() {
                price += parseFloat($(this).attr('price'));
            });

            $('table.table_summary .total td.text-right').text('$'+ price.toFixed(0));
        }

        function checkForm() {
            if (state == 'quote') {
                var choosed = false;
                $('input.qty2').each(function() {
                    if (parseInt($(this).val()) > 0)
                        choosed = true;
                });

                if (choosed) {
                    state = 'info';
                    $('#quote-form, #details-btn').hide();
                    $('#info-form').slideDown();
                } else {
                    $('input.qty2').first().focus();
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

        $(document).ready(function() {
            $('div.button_inc').on('click', function () {
                var $input = $(this).parent().find('input');
                var pid = $input.attr('name').replace(/quantity\[(.*)\]/, '$1');
                var value = $input.val();

                $('#'+ pid).remove();

                var room = null;
                $.each(rooms, function(i, _room) {
                    if (_room.id == pid) room = _room;
                });

                $('<div id="'+ pid +'" price="'+ (room.Quotes.Quote.price * value) +'">'+ value + ' '+ room.name + '</div>').appendTo($('#rooms'));

                mathPrice();
            });

            $('input[type="checkbox"]').change(function() {
                var oid = $(this).attr('id').replace(/option_/, '');

                if (!$(this).is(':checked')) {
                    $('#' + oid).remove();
                } else {
                    var option = null;
                    $.each(options, function (i, _option) {
                        if (_option.id == oid) option = _option;
                    });

                    var price = 0;

                    if (option.OccupancyCharge) {
                        price += parseFloat(option.OccupancyCharge.per_adult_price) * adults +
                                parseFloat(option.OccupancyCharge.per_child_price) * childs;
                    }
                    else if (option.FlatCharge) {
                        var op = option.FlatCharge;

                        if (op.type == 'Once_Off')
                            price += parseFloat(op.price);
                        else if (op.type == 'Per_Selected_Night' || op.type == 'Per_Night')
                            price += parseFloat(op.price) * nights;
                    }
                    else if (option.UnitCharge) {
                        var op = option.UnitCharge;

                        if (op.type == 'Once_Off')
                            price += parseFloat(op.per_unit_price);
                        else if (op.type == 'Per_Night' || op.type == 'Per_Selected_Night')
                            price += parseFloat(op.per_unit_price) * nights;
                    }

                    $('<tr id="' + oid + '" price="' + price + '"><td>' + option.name + '</td><td class="text-right">$' + price + '</td></tr>')
                            .insertBefore('tr.total');
                }

                mathPrice();
            });
        });
    </script>
@endsection