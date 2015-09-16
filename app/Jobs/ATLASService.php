<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ATLASService extends Job implements SelfHandling
{
    /**
     * @var OBXService
     */
    private $OBXService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OBXService $OBXService = null)
    {
        $this->OBXService = $OBXService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }

    protected function query($service, $params = [])
    {
        // Automatically add in FL field TXA_IDENTIFIER
        if ($service == 'products' && isset($params['fl'])) {
            if (!stristr($params['fl'], 'txa_identifier'))
                $params['fl'] .= ',txa_identifier';
        }

        $params['key'] = config('tours.atlas_key');
        $params['out'] = 'json';
        $query = http_build_query($params);
        $url = 'http://'. config('tours.atlas_host') .'/productsearchservice.svc/'. $service .'?' . $query;

        $result = json_decode(iconv('utf-16', 'utf-8', file_get_contents($url)), true);

        if ($service == 'products') {
            //$providers = ['Test_ToothnNailLodge'];
            $providers = [];

            if (isset($result['products']) && sizeof($result['products']) > 0) {

                foreach ($result['products'] as &$product) {
                    $product['optin'] = false;

                    if (sizeof($product['txa_identifier'])) $providers[] = $product['txa_identifier'][0];
                }

                $optins = $this->OBXService->providerOptIn($providers);

                if (isset($optins->Channels)) {
                    if (isset($optins->Channels->Channel->Providers) && isset($optins->Channels->Channel->Providers->Provider)) {
                        if (is_array($optins->Channels->Channel->Providers->Provider)) {
                            foreach ($optins->Channels->Channel->Providers->Provider as $provider) {
                                foreach ($result['products'] as &$product) {
                                    if (!sizeof($product['txa_identifier'])) continue;

                                    if ($product['txa_identifier'][0] == $provider->short_name) $product['optin'] = true;
                                }
                            }
                        } else {
                            foreach ($result['products'] as &$product) {
                                if (!sizeof($product['txa_identifier'])) continue;

                                if ($product['txa_identifier'][0] == $optins->Channels->Channel->Providers->Provider->short_name) $product['optin'] = true;
                            }
                        }
                    } /*else {
                        foreach ($result['products'] as &$product) {
                            if (!sizeof($product['txa_identifier'])) continue;

                            if ($product['txa_identifier'][0] == $optins->Channels->Channel->id) $product['optin'] = true;
                        }
                    }*/
                }
            }
        }
        elseif ($service == 'product') {
            $srv = new ProductService($this, $result);

            $optins = $this->OBXService->providerOptIn([$srv->getTXAShortName()]);

            if (isset($optins->Channels)) {
                $result['optin'] = true;
            } else {
                $result['optin'] = false;
            }
        }

        return $result;
    }

    public function getProduct($id)
    {
        $params['productId'] = $id;
        $params['dg'] = 'PRODUCT_WIDGET,PRODUCT_INTERNET_POINTS';

        return $this->query('product', $params);
    }

    public function getService($product_id, $id)
    {
        $params['productId'] = $product_id;
        $params['serviceId'] = $id;

        return $this->query('productservice', $params);
    }

    public function accommodations($params = [])
    {
        $params['cats'] = 'ACCOMM';

        return $this->query('products', $params);
    }

    public function getTopProducts($category)
    {
        return $this->query('products', [
                'cats' => $category,
                'size' => 6, // was 12
                'dsc' => 'false',
                'ratings' => '-1,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
                'fl' => 'product_id,product_name,product_image,rate_from, product_classifications',
                //'att' => 'ESC_TXA_MULTI|ESC_TXA_DEFAULT',
                'order' => 'rating_aaa desc,rnd'
        ]);
    }

    public function topAccommodations()
    {
        return $this->getTopProducts('ACCOMM');
    }

    public function tours($params = [])
    {
        $params['cats'] = 'TOUR';

        return $this->query('products', $params);
    }

    public function topTours()
    {
        return $this->getTopProducts('TOUR');
    }

    public function attractions($params = [])
    {
        $params['cats'] = 'ATTRACTION';

        return $this->query('products', $params);
    }

    public function topAttractions()
    {
        return $this->getTopProducts('ATTRACTION');
    }

    public function events($params = [])
    {
        $params['cats'] = 'EVENT';

        return $this->query('products', $params);
    }

    public function topEvents()
    {
        return $this->getTopProducts('EVENT');
    }

    public function hires($params = [])
    {
        $params['cats'] = 'HIRE';

        return $this->query('products', $params);
    }

    public function topHires()
    {
        return $this->getTopProducts('HIRE');
    }

}
