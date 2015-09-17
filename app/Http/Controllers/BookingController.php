<?php

namespace App\Http\Controllers;

use App\Jobs\OBXService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function quote($type, $shortName, OBXService $OBXService, Request $request)
    {
        $quote = $OBXService->getBookingQuote($request->all(), $type, $shortName);

        //dd($quote);

        return view('booking.quote', compact('quote', 'shortName', 'type'));
    }

    public function make(Request $request, OBXService $OBXService)
    {
        $result = $OBXService->makeBook($request->all(), $request->short_name);

        // Send email
        $order = $result[1];

        Mail::send('emails.invoice', [
            'order' => $order,
            'url' => route('invoice.mail', ['id' => $order->id, 'code' => $order->reservation_id])
        ], function ($m) use ($order) {
            $m->from('noreply@backpackers.com.au', 'BackPackers.com.au');
            $m->to($order->email, $order->getName())->subject('Your order on Backpackers.com.au #'. $order->id);
        });

        return view('booking.make', compact('result'));
    }
}
