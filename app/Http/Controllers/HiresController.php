<?php

namespace App\Http\Controllers;

use App\Jobs\ATLASService;
use App\Jobs\TourService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HiresController extends Controller
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

        $order = [];
        if ($request->input('sort_name')) {
            $order[] = 'product_name '. ($request->input('sort_name') == 'desc' ? 'desc' : 'asc');
        }

        $exp = ['ESC_TXA_DEFAULT', 'ESC_TXA_MULTI'];
        $params['att'] = implode('|', $exp);

        $params['size'] = 10;
        $params['pge'] = $request->input('page') ?: 1;
        $params['fl'] = 'product_id,product_name,product_description,product_image,rate_from,starRating,geo';
        $params['facets'] = 'cla'; // Additionally retrieve number of results in all types
        if (sizeof($order)) $params['order'] = implode(', ', $order);

        $hires = $ATLASService->hires($params);

        unset($params['cla']);
        $total = $ATLASService->hires(array_merge([
                'dsc' => 'false',
                'fl' => 'product_id',
        ], $params));

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $hires['products'],
                $hires['numberOfResults'],
                $params['size'],
                $params['pge'],
                [
                        'path' => route('hires.index'),
                        'query' => $request->all()
                ]
        );

        //dd($hires);

        return view('hires.list', compact('hires', 'total', 'paginator'));
    }

    public function show(ATLASService $ATLASService, TourService $tourService, $id)
    {
        $model = $ATLASService->getProduct($id);

        $tourService->set($model);
        $services = $tourService->getServices();

        $coord = $tourService->getCoordinates();

        $nearest = $ATLASService->hires([
                'fl' => 'product_id,product_name,product_description,product_image,geo',
                'latlong' => $coord['lat'] .','. $coord['long'],
                'dist' => 50,
                'size' => 20
        ]);

        //dd($model);

        return view('hires.show', ['model' => $tourService, 'nearest' => $nearest]);
    }
}
