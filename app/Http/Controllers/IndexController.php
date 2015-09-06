<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Jobs\ATLASService;
use App\Jobs\OBXService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{

    public function welcome(ATLASService $ATLASService)
    {
        $accommodations = $ATLASService->topAccommodations();

        return view('welcome', compact('accommodations'));
    }

    public function tours(ATLASService $ATLASService)
    {
        $tours = $ATLASService->topTours();

        return response()->json([
            'view' => view('top_list', compact('tours'))->render(),
            'numberOfResults' => $tours['numberOfResults']
        ]);
    }

    public function attractions(ATLASService $ATLASService)
    {
        $attractions = $ATLASService->topAttractions();

        return response()->json([
            'view' => view('top_list', compact('attractions'))->render(),
            'numberOfResults' => $attractions['numberOfResults']
        ]);
    }

    public function events(ATLASService $ATLASService)
    {
        $events = $ATLASService->topEvents();

        return response()->json([
            'view' => view('top_list', compact('events'))->render(),
            'numberOfResults' => $events['numberOfResults']
        ]);
    }

    public function hires(ATLASService $ATLASService)
    {
        $hires = $ATLASService->topHires();

        return response()->json([
            'view' => view('top_list', compact('hires'))->render(),
            'numberOfResults' => $hires['numberOfResults']
        ]);
    }

    public function check(OBXService $OBXService)
    {
        dd($OBXService->providerOptIn());
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendMessage(ContactRequest $request)
    {
        Mail::send('emails.message', [
            'request' => $request,
            'url' => ''
        ], function ($m) use ($request) {
            $m->from($request->email, $request->firstname .' '. $request->lastname);
            $m->to(config('tours.contact_email'), config('tours.contact_name'))->subject('Received message from Backpackers.com.au');
        });

        flash()->success('Message sended.');

        return redirect('/contact-us');
    }
}
