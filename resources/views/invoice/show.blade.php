@include('layouts.partials.header')

<style>
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
</style>

<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>Invoice</h2><h3 class="pull-right">Order # {{ $order->id }} - {{ $order->reservation_id }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Billed To:</strong><br>
                        {!! nl2br($order->billing_address) !!}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Request:</strong><br>
                        {{ $order->type == 'Accommodation' ? 'Nights' : 'Days' }}: {{ $order->length }}<br>
                        Adults: {{ $order->adults }}<br>
                        Childs: {{ $order->childs }}
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Payment Method:</strong><br>
                        {{ $order->payment_type }} ending **** {{ $order->card }}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong><br>
                        {{ $order->created_at->formatLocalized('%B %d, %Y') }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>Item</strong></td>
                                <td class="text-center"><strong>Price</strong></td>
                                <td class="text-center"><strong>Quantity</strong></td>
                                <td class="text-right"><strong>Totals</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                            <tr>
                                <td>{{ $order->product_name }}</td>
                                <td class="text-center">AUD ${{ round($order->price, 2) }}</td>
                                <td class="text-center">1</td>
                                <td class="text-right">AUD ${{ round($order->price, 2) }}</td>
                            </tr>
                            @foreach ($order->extras as $extra)
                            <tr>
                                <td>{{ $extra->name }}</td>
                                <td class="text-center">AUD ${{ round($extra->price, 2) }}</td>
                                <td class="text-center">1</td>
                                <td class="text-right">AUD ${{ round($extra->price, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                <td class="thick-line text-right">AUD ${{ round($order->price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Extras</strong></td>
                                <td class="no-line text-right">AUD ${{ round($order->extra_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>Total</strong></td>
                                <td class="no-line text-right">AUD ${{ round($order->total_price, 2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.footer')