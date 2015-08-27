<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Webpatser\Uuid\Uuid;

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

    /**
     * Return credit card type if number is valid
     * @return string
     * @param $number string
     **/
    protected function cardType($number)
    {
        $number=preg_replace('/[^\d]/','',$number);
        if (preg_match('/^3[47][0-9]{13}$/',$number))
        {
            return 'American Express';
        }
        elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
        {
            return 'Diners Club';
        }
        elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
        {
            return 'Discover';
        }
        elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
        {
            return 'JCB';
        }
        elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
        {
            return 'MasterCard';
        }
        elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
        {
            return 'Visa';
        }
        else
        {
            return 'Unknown';
        }
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

    public function makeBook($request, $shortName = 'Test_ToothnNailLodge') {
        $start = \Carbon\Carbon::parse($request['check_in']);
        $end = \Carbon\Carbon::parse($request['check_out']);
        $nights = $end->diffInDays($start);
        $selectedNights = trim($request['selectedDates']) ? sizeof(explode(',', trim($request['selectedDates']))) : 0;

        $quote = $this->getBookingQuote($request);
        $extrasPrice = 0;
        $productDetails = [];

        foreach ($quote->ProviderRS->BookingExtraOptions->BookingExtraOption as $option) {
            if (isset($request['option'][$option->id])) {
                $price = 0;

                $extra = [];

                if (isset($option->OccupancyCharge)) {
                    $op = $option->OccupancyCharge;

                    if ($op->type == 'Once_Off') {
                        $price += $op->per_adult_price * $request['adults'] +
                                $op->per_child_price * $request['childs'];
                    }
                    elseif ($op->type == 'Per_Night') {
                        $price += ($op->per_adult_price * $request['adults'] +
                                $op->per_child_price * $request['childs']) * $nights;
                    }
                    elseif ($op->type == 'Per_Selected_Night') {
                        $price += ($op->per_adult_price * $request['adults'] +
                                        $op->per_child_price * $request['childs']) * $selectedNights;
                    }

                    $extra['OccupancyCharge'] = [
                        'type' => $op->type,
                        'per_adult_price' => $op->per_adult_price,
                        'per_child_price' => $op->per_child_price
                    ];
                }
                elseif (isset($option->FlatCharge)) {
                    $op = $option->FlatCharge;

                    if ($op->type == 'Once_Off') {
                        $price += $op->price;
                    }
                    elseif ($op->type == 'Per_Night') {
                        $price += $op->price * $nights;
                    }
                    elseif ($op->type == 'Per_Selected_Night') {
                        $price += $op->price * $selectedNights;
                    }

                    $extra['FlatCharge'] = [
                            'type' => $op->type,
                            'price' => $op->price
                    ];
                }
                elseif (isset($option->UnitCharge)) {
                    $op = $option->UnitCharge;

                    if ($op->type == 'Once_Off') {
                        $price += $op->per_unit_price;
                    }
                    elseif ($op->type == 'Per_Night') {
                        $price += $op->per_unit_price * $nights;
                    }
                    elseif ($op->type == 'Per_Selected_Night') {
                        $price += $op->per_unit_price * $selectedNights;
                    }

                    $extra['UnitCharge'] = [
                            'type' => $op->type,
                            'per_unit_price' => $op->per_unit_price
                    ];
                }

                $extra['name'] = $option->name;
                $extra['code'] = $option->id;

                $extrasPrice += $price;
                $productDetails['BookingExtras']['BookingExtra'][] = $extra;
            }
        }

        $productDetails['BookingExtras']['total_price'] = $extrasPrice;
        $productPrice = 0;

        //foreach ($request['quantity'] as $product_id => $_p) {
        //    foreach ($_p as $product_name => $quantity) {
                foreach ($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product as $product) {
                    if ($product->id == $request['room']) {
                        //for ($i = 1; $i <= $quantity; $i++) {
                            $productDetails['Product'] = [
                                'num_adult' => $request['adults'],
                                'num_children' => $request['childs'],
                                'num_concession' => 0,
                                'id' => $product->id,
                                'name' => $product->name,
                                'start_date' => $start->format('Y-m-d') .'T14:00:00',
                                'finish_date' => $end->format('Y-m-d') .'T10:00:00',
                                'price' => $product->Quotes->Quote->price
                            ];

                            $productPrice += $product->Quotes->Quote->price;
                        //}
                    }
                }
        //    }
        //}

        $params['Reservation'] = [
            'client_id' => "". Uuid::generate(4),
            'IndustryCategory' => [
                'type' => ucfirst($request['type'])
            ],
            'Provider' => [
                'short_name' => $shortName
            ],
            'ProductDetails' => $productDetails
        ];

        $params['Reservation']['CustomerDetails'] = [
            'PersonName' => [
                'surname' => $request['lastname_booking'],
                'given_name' => $request['firstname_booking']
            ],
            'Contact' => [
                'Email' => $request['email_booking'],
                'Address' => [
                    'AddressLine' => $request['street_1'] . $request['street_2'],
                    'CityName' => $request['city_booking'],
                    'CountryName' => $request['country'],
                    'PostalCode' => $request['postal_code'],
                    'StateProv' => $request['state_booking']
                ]
            ]
        ];

        $params['Reservation']['PaymentDetails'] = [
            'PaymentType' => 'Direct',
            'PaymentAmount' => [
                'customer_paid_provider' => $productPrice + $extrasPrice,
                'customer_paid_distributor' => 0,
                'total' => $productPrice + $extrasPrice
            ],
            'PaymentCard' => [
                'card_holder_name' => $request['name_card_booking'],
                'expire_date' => $request['expire_month'] . $request['expire_year'],
                'security_code' => $request['ccv'],
                'card_number' => $request['card_number'],
                'card_type' => $this->cardType($request['card_number'])
            ]
        ];

        //dd($params);

        return $this->queryBook('MakeBooking', ['Reservations' => $params]);
    }

    public function getBookingQuote($params, $shortName = 'Test_ToothnNailLodge')
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
