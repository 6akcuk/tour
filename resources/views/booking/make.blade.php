<?php
$booking = true;

$response = $result[0];
?>

@extends('layouts.main')

@section('breadcrumbs')
    <li>Booking Form</li>
@endsection

@section('content')
    <div class="row">
        @if (isset($response->Status->Errors))
            <div class="alert alert-danger">
                {{ $response->Status->Errors->Error->Message }} <br>
                <a href="javascript:history.back()">Go Back</a>
            </div>
        @else
            <?php
                $order = $result[1];
            ?>

            <div class="col-md-8">

                <div class="form_title">
                    <h3><strong><i class="icon-ok"></i></strong>Thank you!</h3>
                    <p>
                        Text here
                    </p>
                </div>
                <div class="step">
                    <p>
                        Text here
                    </p>
                </div><!--End step -->

                <div class="form_title">
                    <h3><strong><i class="icon-tag-1"></i></strong>Booking summary</h3>
                    <p>
                        Text here
                    </p>
                </div>
                <div class="step">
                    <table class="table confirm">
                        <tbody>
                        <tr>
                            <td>
                                <strong>Name</strong>
                            </td>
                            <td>
                                {{ $order->getName() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Check in</strong>
                            </td>
                            <td>
                                {{ $order->check_in->formatLocalized('%d %B %Y at %H:%M') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Product</strong></td>
                            <td>
                                {{ $order->product_name }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ $order->type == 'Accommodation' ? 'Nights' : 'Days' }}</strong></td>
                            <td>
                                {{ $order->length }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Adults</strong></td>
                            <td>
                                {{ $order->adults }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Childs</strong></td>
                            <td>
                                {{ $order->childs }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Payment type</strong>
                            </td>
                            <td>
                                {{ $order->payment_type }}
                            </td>
                        </tr>
                        <tr >
                            <td>
                                <strong>TOTAL COST</strong>
                            </td>
                            <td >
                                AUD ${{ round($order->total_price, 2) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div><!--End step -->
            </div><!--End col-md-8 -->

            <aside class="col-md-4">
                <div class="box_style_1">
                    <h3 class="inner">Thank you!</h3>
                    <p>
                        Text here
                    </p>
                    <hr>
                    <a class="btn_full_outline" href="{{ route('invoice.show', ['id' => $order->id, 'code' => $order->reservation_id]) }}" target="_blank">
                        View your invoice
                    </a>
                </div>
                <div class="box_style_4">
                    <i class="icon_set_1_icon-89"></i>
                    <h4>Have <span>questions?</span></h4>
                    <a href="tel://{{ str_replace(' ', '', Request::input('contact_phone')) }}" class="phone">
                        +{{ Request::input('contact_phone') }}
                    </a>
                    <small>Monday to Friday 9.00am - 7.30pm</small>
                </div>
            </aside>
        @endif
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