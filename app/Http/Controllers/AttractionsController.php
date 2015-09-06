<?php

namespace App\Http\Controllers;

use App\Jobs\ATLASService;
use App\Jobs\AttractionService;
use App\Jobs\TourService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AttractionsController extends Controller
{
    public function index(Request $request, ATLASService $ATLASService)
    {
        $params = [];

        if ($request->input('terms')) $params['term'] = $request->input('terms');
        if ($request->input('type')) $params['cla'] = $request->input('type');
        if ($request->input('state')) $params['st'] = $request->input('state');
        if ($request->input('region')) $params['rg'] = $request->input('region');
        if ($request->input('city')) $params['ct'] = $request->input('city');

        if ($request->input('rating')) {
            $params['ratings'] = implode(',', $request->input('rating'));
        }
        if ($request->input('rateRange')) {
            $rates = [];
            foreach ($request->input('rateRange') as $rate) {
                $rates = array_merge($rates, explode('-', $rate));
            }

            $params['minRate'] = min($rates);
            $params['maxRate'] = max($rates);
        }

        //$exp = ['ESC_TXA_DEFAULT', 'ESC_TXA_MULTI'];
        $exp = [];

        if ($request->input('filter')) {
            foreach ($request->input('filter') as $fl) {
                $exp[] = 'EXPERIENCE'. strtoupper(str_replace('_', '', $fl));
            }
        }

        $params['att'] = implode('|', $exp);

        $order = [];
        if ($request->input('sort_name')) {
            $order[] = 'product_name '. ($request->input('sort_name') == 'desc' ? 'desc' : 'asc');
        }

        $params['size'] = 10;
        $params['pge'] = $request->input('page') ?: 1;
        $params['fl'] = 'product_id,product_name,product_description,product_image,rate_from,starRating,geo';
        $params['facets'] = 'cla'; // Additionally retrieve number of results in all types
        if (sizeof($order)) $params['order'] = implode(', ', $order);

        $attractions = $ATLASService->attractions($params);

        unset($params['cla']);
        $total = $ATLASService->attractions(array_merge([
                'dsc' => 'false',
                'fl' => 'product_id',
        ], $params));

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $attractions['products'],
                $attractions['numberOfResults'],
                $params['size'],
                $params['pge'],
                [
                        'path' => route('attractions.index'),
                        'query' => $request->all()
                ]
        );

        //dd($attractions);

        return view('attractions.list', compact('attractions', 'total', 'paginator'));
    }

    public function show(ATLASService $ATLASService, AttractionService $attractionService, $id)
    {
        $model = $ATLASService->getProduct($id);

        $attractionService->set($model);
        $services = $attractionService->getServices();

        $coord = $attractionService->getCoordinates();

        $nearest = $ATLASService->attractions([
                'fl' => 'product_id,product_name,product_description,product_image,geo',
                'latlong' => $coord['lat'] .','. $coord['long'],
                'dist' => 50,
                'size' => 20
        ]);

        //dd($model);

        return view('attractions.show', ['model' => $attractionService, 'nearest' => $nearest]);
    }
}
