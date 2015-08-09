<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ATLASService extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $params['key'] = config('tours.atlas_key');
        $params['out'] = 'json';
        $query = http_build_query($params);
        $url = 'http://'. config('tours.atlas_host') .'/productsearchservice.svc/'. $service .'?' . $query;

        /*$s = curl_init();

        curl_setopt($s, CURLOPT_URL, 'http://'. config('tours.atdw_host') .'/productsearchservice.svc/'. $service .'?' . $query);
        curl_setopt($s,CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($s,CURLOPT_RETURNTRANSFER, true);

        echo (utf8_decode(curl_exec($s)));*/

        return (json_decode(iconv('utf-16', 'utf-8', file_get_contents($url)), true));
        //echo json_decode(substr(file_get_contents($url), -2), true);

        //dd(mb_convert_encoding(file_get_contents('http://'. config('tours.atdw_host') .'/productsearchservice.svc/'. $service .'?' . $query), 'HTML-ENTITIES', 'UTF-8'));

        //return json_encode(html_entity_decode(file_get_contents('http://'. config('tours.atdw_host') .'/productsearchservice.svc/'. $service .'?' . $query)), true);
    }

    public function accommodations($params = [])
    {
        $params['cats'] = 'ACCOMM';

        return $this->query('products', $params);
    }

    public function topAccommodations()
    {
        return $this->query('products', [
            'cats' => 'ACCOMM',
            'size' => 12,
            'dsc' => 'false',
            'ratings' => '-1,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5',
            'fl' => 'product_id,product_name,product_image,rate_from, product_classifications',
            'order' => 'rating_aaa desc,rnd'
        ]);
    }
}
