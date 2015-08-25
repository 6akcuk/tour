<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class OBXService extends Job implements SelfHandling
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

    protected function queryBook($method, $params)
    {
        $client = new \SoapClient('http://www.au.v3travel.com/CABS.WebServices/BookingService.asmx?WSDL', [
                'exceptions' => true,
                'trace' => true
        ]);

        $params['DistributionChannelRQ'] = [
            'id' => config('tours.obx_account'),
            'key' => config('tours.obx_key')
        ];

        $response = $client->$method($params);

        return $response;
    }

    public function makeBook($params, $shortName = 'Test_ToothnnailLodge') {
        $params['Reservation'] = [
            //'client_id' => $params['product_id'],
            'IndustryCategory' => [
                'type' => $params['type']
            ],
            'Provider' => [
                'short_name' => $shortName
            ],
            'ProductDetails' => [
                'num_adult' => $params['adults'],
                'num_children' => $params['childs'],
                'num_concession' => 0,
                'id' => $params['product_id'],
                'name' => $params['short_name'],
                ''
            ]
        ];
    }

    public function getBookingQuote($params, $shortName = 'Test_ToothnnailLodge')
    {
        $params['ProviderRQ'] = [
            'short_name' => $shortName
        ];

        $start = \Carbon\Carbon::parse($params['check_in']);
        $end = \Carbon\Carbon::parse($params['check_out']);

        $params['Query'] = [
            'IndustryCategoryGroup' => 'Accommodation',
            'SearchCriteria' => [
                'LengthNights' => [
                    'duration' => $end->diffInDays($start)
                ],
                'CommencingSpecific' => [
                    'date' => $start->format('Y-m-d')
                ],
                'ConsumerCandidates' => [
                    'ConsumerCandidate' => [
                        'adults' => 2,
                        'children' => 0
                    ]
                ]
            ]
        ];

        return $this->queryBook('GetBookingQuote', $params);
    }

    protected function querySearch($method, $params)
    {
        $client = new \SoapClient('http://www.au.v3travel.com/CABS.WebServices/SearchService.asmx?WSDL', [
            'exceptions' => true,
            'trace' => true
        ]);

        $params['Channels'] = [
            'DistributionChannelRQ' => [
                'id' => config('tours.obx_account'),
                'key' => config('tours.obx_key')
            ]
        ];

        $response = $client->$method($params);

        return $response;
    }

    public function productAvailability($shortName = 'Test_ToothnNailLodge')
    {
        $params = [
            'Providers' => [
                'ProviderRQ' => [
                    'short_name' => $shortName
                ]
            ],
            'Query' => [
                'IndustryCategory' => 'None',
                'IndustryCategoryGroup' => 'Accommodation',
                'SearchCriteria' => [
                    'LengthNights' => [
                        'minimum' => 1,
                        'maximum' => 1
                    ],
                    'CommencingSpecific' => [
                        'date' => '2015-08-24'
                    ],
                    'Consumers' => [
                        ['adults' => 1, 'childs' => 0]
                    ]
                ]
            ]
        ];

        return $this->querySearch('ProductAvailability', $params);
    }
}
