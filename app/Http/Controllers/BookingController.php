<?php

namespace App\Http\Controllers;

use App\Jobs\OBXService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function quote($type, $shortName, OBXService $OBXService, Request $request)
    {
        $quote = $OBXService->getBookingQuote($request->all());

        //dd($quote);

        return view('booking.quote', compact('quote', 'shortName', 'type'));
    }

    public function make(Request $request)
    {
        return view('booking.make');
    }
}
