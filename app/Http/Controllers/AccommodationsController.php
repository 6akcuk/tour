<?php

namespace App\Http\Controllers;

use App\Jobs\AccommodationService;
use App\Jobs\ATLASService;
use Carbon\Carbon;
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
        if ($request->input('from')) {
            $from = Carbon::parse($request->input('from'))->format('Y-m-d');

            $params['start'] = $from;
        }
        if ($request->input('to')) {
            $to = Carbon::parse($request->input('to'))->format('Y-m-d');

            $params['end'] = $to;
        }

        //$fac = ['ESC_TXA_DEFAULT', 'ESC_TXA_MULTI'];
        $fac = [];

        if ($request->input('filter')) {
            foreach ($request->input('filter') as $fl) {
                if (stristr($fl, '|')) {
                    $arr = explode("|", $fl);
                    foreach ($arr as $ar) {
                        $fac[] = 'ENTITYFAC'. strtoupper(str_replace('_', '', $ar));
                    }
                }
                else $fac[] = 'ENTITYFAC'. strtoupper(str_replace('_', '', $fl));
            }
        }

        $params['att'] = implode('|', $fac);

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
        if ($request->input('sort_price')) {
            $order[] = 'rate_from '. ($request->input('sort_price') == 'lower' ? 'asc' : 'desc');
        }
        if ($request->input('sort_rating')) {
            $order[] = 'rating_aaa '. ($request->input('sort_price') == 'lower' ? 'asc' : 'desc');
        }

        $params['size'] = 10;
        $params['pge'] = $request->input('page') ?: 1;
        $params['fl'] = 'product_id,product_name,product_description,product_image,rate_from,starRating,geo';
        $params['facets'] = 'cla'; // Additionally retrieve number of results in all types
        if (sizeof($order)) $params['order'] = implode(', ', $order);

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
                'path' => route('accommodation.index'),
                'query' => $request->all()
            ]
        );

        //dd($accommodations);

        return view('accommodations.list', compact('accommodations', 'total', 'paginator'));
    }

    public function show(ATLASService $ATLASService, AccommodationService $accommodationService, $id)
    {
        $model = $ATLASService->getProduct($id);

        $accommodationService->set($model);
        $services = $accommodationService->getServices();

        $coord = $accommodationService->getCoordinates();

        $nearest = $ATLASService->accommodations([
            'fl' => 'product_id,product_name,product_description,product_image,geo',
            'latlong' => $coord['lat'] .','. $coord['long'],
            'att' => 'ESC_TXA_MULTI|ESC_TXA_DEFAULT',
            'dist' => 50,
            'size' => 20
        ]);

        //dd($model);

        return view('accommodations.show', ['model' => $accommodationService, 'nearest' => $nearest]);
    }
}
