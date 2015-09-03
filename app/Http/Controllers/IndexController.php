<?php

namespace App\Http\Controllers;

use App\Jobs\ATLASService;
use App\Jobs\OBXService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
}
