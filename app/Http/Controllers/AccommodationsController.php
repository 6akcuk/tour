<?php

namespace App\Http\Controllers;

use App\Jobs\ATLASService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccommodationsController extends Controller
{
    public function index(Request $request, ATLASService $ATLASService)
    {
        $params = [];

        if ($request->input('terms')) $params['term'] = $request->input('terms');
        if ($request->input('type')) $params['cla'] = $request->input('type');
        if ($request->input('state')) $params['st'] = $request->input('state');
        if ($request->input('region')) $params['rg'] = $request->input('region');
        if ($request->input('city')) $params['ct'] = $request->input('city');

        $params['size'] = 10;
        $params['pge'] = $request->input('page') ?: 1;
        $params['fl'] = 'product_id,product_name,product_description,product_image,rate_from,starRating';
        $params['facets'] = 'cla'; // Additionally retrieve number of results in all types

        $accommodations = $ATLASService->accommodations($params);

        unset($params['cla']);
        $total = $ATLASService->accommodations(array_merge([
            'dsc' => 'false',
            'fl' => 'product_id',
        ], $params));

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $accommodations['products'],
            $accommodations['numberOfResults'],
            $params['size'],
            $params['pge'],
            [
                'path' => route('accommodations.index'),
                'query' => $request->all()
            ]
        );

        //dd($accommodations);

        return view('accommodations.list', compact('accommodations', 'total', 'paginator'));
    }
}
