<?php

namespace App\Http\Controllers;

use App\BookingOrder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function mail($id, $code)
    {
        $order = BookingOrder::with('extras')->findOrFail($id);
        if ($order->reservation_id != $code)
            abort(404, 'Order not found.');

        $url = route('invoice.mail', ['id' => $id, 'code' => $code]);

        return view('emails.invoice', compact('order', 'url'));
    }

    public function show($id, $code)
    {
        $order = BookingOrder::with('extras')->findOrFail($id);
        if ($order->reservation_id != $code)
            abort(404, 'Order not found.');

        return view('invoice.show', compact('order'));
    }
}
