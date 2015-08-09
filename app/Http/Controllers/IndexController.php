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
//dd($accommodations);
        return view('welcome', compact('accommodations'));
    }
}
