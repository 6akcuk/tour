@extends('layouts.email')

@section('content')
    <!-- Start Space -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
        <tbody>
        <tr>
            <td height="26">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <!-- End Space -->

    <table width="550" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-bottom: 1px solid #ddd">
        <tbody>
        <tr>
            <td height="26">
                <table width="160" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                    <tr>
                        <td>
                            <h2>Invoice</h2>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Start Social -->
                <table align="right" cellspacing="0" cellpadding="0" border="0" class="content-width-menu">
                    <tbody>
                    <tr>
                        <td>
                            <h2>Order # {{ $order->id }} - {{ $order->reservation_id }}</h2>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <table width="550" cellspacing="0" cellpadding="0" border="0" class="full-width">
        <tbody>
        <tr>
            <td colspan="2" height="20"></td>
        </tr>
        <tr>
            <td height="26">
                <table width="160" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Billed To:</strong><br>
                            {!! nl2br($order->billing_address) !!}
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Start Social -->
                <table align="right" cellspacing="0" cellpadding="0" border="0" class="content-width-menu">
                    <tbody>
                    <tr>
                        <td align="right">
                            <strong>Request:</strong><br>
                            {{ $order->type == 'Accommodation' ? 'Nights' : 'Days' }}: {{ $order->length }}<br>
                            Adults: {{ $order->adults }}<br>
                            Childs: {{ $order->childs }}<br>
                            Check-in: {{ $order->check_in->formatLocalized('%d %b %Y at %H:%M') }}<br>
                            Check-out: {{ $order->check_out->formatLocalized('%d %b %Y at %H:%M') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" height="20"></td>
        </tr>
        <tr>
            <td height="26">
                <table width="160" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Payment Method:</strong><br>
                            {{ $order->payment_type }} ending **** {{ $order->card }}<br>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!-- Start Social -->
                <table align="right" cellspacing="0" cellpadding="0" border="0" class="content-width-menu">
                    <tbody>
                    <tr>
                        <td align="right">
                            <strong>Order Date:</strong><br>
                            {{ $order->created_at->formatLocalized('%B %d, %Y') }}<br><br>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" height="20"></td>
        </tr>
        </tbody>
    </table>

    <table width="550" cellspacing="0" cellpadding="0" border="0" class="full-width">
        <tbody>
        <tr>
            <td height="36" bgcolor="#f5f5f5" valign="center" align="center">
                <table width="520" cellspacing="0" cellpadding="0" border="0" class="full-width">
                    <tbody>
                    <tr>
                        <td>
                            <h2>Order Summary</h2>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="center" align="center">
                <table width="520" class="full-width">
                    <thead>
                    <tr>
                        <td height="26" style="border-bottom: 1px solid #ddd"><strong>Item</strong></td>
                        <td align="center" style="border-bottom: 1px solid #ddd"><strong>Price</strong></td>
                        <td align="center" style="border-bottom: 1px solid #ddd"><strong>Quantity</strong></td>
                        <td align="right" style="border-bottom: 1px solid #ddd"><strong>Totals</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                    <tr>
                        <td height="26" style="border-bottom: 1px solid #ddd">{{ $order->product_name }}</td>
                        <td align="center" style="border-bottom: 1px solid #ddd">AUD ${{ round($order->price, 2) }}</td>
                        <td align="center" style="border-bottom: 1px solid #ddd">1</td>
                        <td align="right" style="border-bottom: 1px solid #ddd">AUD ${{ round($order->price, 2) }}</td>
                    </tr>
                    @foreach ($order->extras as $extra)
                        <tr>
                            <td height="26" style="border-bottom: 1px solid #ddd">{{ $extra->name }}</td>
                            <td align="center" style="border-bottom: 1px solid #ddd">AUD ${{ round($extra->price, 2) }}</td>
                            <td align="center" style="border-bottom: 1px solid #ddd">{{ $extra->quantity }}</td>
                            <td align="right" style="border-bottom: 1px solid #ddd">AUD ${{ round($extra->price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td height="26" style="border-top: 2px solid grey"></td>
                        <td style="border-top: 2px solid grey"></td>
                        <td align="center" style="border-top: 2px solid grey"><strong>Subtotal</strong></td>
                        <td align="right" style="border-top: 2px solid grey">AUD ${{ round($order->price, 2) }}</td>
                    </tr>
                    <tr>
                        <td height="26"></td>
                        <td></td>
                        <td align="center"><strong>Extras</strong></td>
                        <td align="right">AUD ${{ round($order->extra_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td height="26"></td>
                        <td></td>
                        <td align="center"><strong>Total</strong></td>
                        <td align="right">AUD ${{ round($order->total_price, 2) }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Start footer ============ -->
    <table width="600" bgcolor="#464646" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
        <tbody>
        <tr>
            <td align="center">
                <!-- Start Space -->
                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                    <tbody>
                    <tr>
                        <td  align="center" valign="middle" style="font-family: Arial, Helvetica, sans-serif;font-size:11px; font-weight:normal; color:#cccccc; padding-top:10px; padding-bottom:10px">
                            <strong>Copyright © {{ date('Y') }} BackPackers.com.au</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- End Space -->
            </td>
        </tr>
        </tbody>
    </table><!-- End footer =========== -->
@endsection