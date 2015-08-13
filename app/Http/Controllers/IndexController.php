<?php

namespace App\Http\Controllers;

use App\Jobs\ATLASService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function welcome(ATLASService $ATLASService)
    {
        $accommodations = $ATLASService->topAccommodations();
        $tours = $ATLASService->topTours();
        $attractions = $ATLASService->topAttractions();
        $events = $ATLASService->topEvents();
        $hires = $ATLASService->topHires();

        return view('welcome', compact('accommodations', 'tours', 'attractions', 'events', 'hires'));
    }
}
