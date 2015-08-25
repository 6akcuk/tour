<?php
$booking = true;
?>

@extends('layouts.main')

@section('breadcrumbs')
    <li>Booking Form</li>
@endsection

@section('content')
    <div class="row">
        {!! Form::open() !!}



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
                            {{ \Carbon\Carbon::parse(Request::input('check_in'))->formatLocalized('%d %B %Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Check out
                        </td>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse(Request::input('check_out'))->formatLocalized('%d %B %Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Rooms
                        </td>
                        <td class="text-right">
                            @foreach (Request::input('quantity') as $id => $q)
                                <?php
                                    if ($q == 0) continue;
                                ?>

                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nights
                        </td>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse(Request::input('check_in'))->diffInDays(\Carbon\Carbon::parse(Request::input('check_in'))) }}
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
                    <tr>
                        <td>
                            Welcome bottle
                        </td>
                        <td class="text-right">
                            $34
                        </td>
                    </tr>
                    <tr class="total">
                        <td>
                            Total cost
                        </td>
                        <td class="text-right">
                            $154
                        </td>
                    </tr>
                    </tbody>
                </table>
                <a class="btn_full" href="confirmation_hotel.html">Book now</a>
                <a class="btn_full_outline" href="single_hotel.html"><i class="icon-right"></i> Modify your search</a>
            </div>
            <div class="box_style_4">
                <i class="icon_set_1_icon-57"></i>
                <h4>Need <span>Help?</span></h4>
                <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                <small>Monday to Friday 9.00am - 7.30pm</small>
            </div>
        </aside>

        {!! Form::close() !!}
    </div><!--End row -->
@endsection

@section('footer_javascript')
    <script src="js/icheck.js"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>


@endsection