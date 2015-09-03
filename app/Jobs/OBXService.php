<?php

namespace App\Jobs;

use App\BookingOrder;
use App\BookingOrderExtra;
use App\Jobs\Job;
use Faker\Provider\zh_TW\DateTime;
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

        //echo($client->__getLastRequest());

        return $response;
    }

    public function makeBook($request, $shortName = 'Test_ToothnNailLodge') {
        $start = \Carbon\Carbon::parse($request['check_in']);
        $end = \Carbon\Carbon::parse($request['check_out']);
        $nights = $end->diffInDays($start);
        $selectedNights = isset($request['selectedDates']) && trim($request['selectedDates']) ? sizeof(explode(',', trim($request['selectedDates']))) : 0;

        $quote = $this->getBookingQuote($request, ucfirst($request['type']));
        $extrasPrice = 0;
        $productDetails = [];
        $clientId = "". Uuid::generate(4);

        //dd($quote);

        $bookingOrder = BookingOrder::create([
            'client_id'         => $clientId,
            'type'              => ucfirst($request['type']),
            'firstname'         => $request['firstname_booking'],
            'lastname'          => $request['lastname_booking'],
            'email'             => $request['email_booking'],
            'payment_type'      => $this->cardType($request['card_number']),
            'card'              => preg_replace("/.*(\d{4})$/", "$1", preg_replace("/[^0-9]*/", "", $request['card_number'])),
            'billing_address'   => $request['street_1'] . $request['street_2'] ."\n" .
                                   $request['city_booking'] .", ". $request['state_booking'] ." ". $request['postal_code'] . "\n" .
                                   $request['country'] ."\n",
            'check_in'          => $start->format('Y-m-d'),
            'length'            => $nights,
            'adults'            => $request['adults'],
            'childs'            => $request['childs']
        ]);

        if (isset($quote->ProviderRS->BookingExtraOptions)) {
            foreach ($quote->ProviderRS->BookingExtraOptions->BookingExtraOption as $option) {
                if (isset($request['option'][$option->id])) {
                    $price = 0;

                    $extra = [];

                    if (isset($option->OccupancyCharge)) {
                        $op = $option->OccupancyCharge;

                        if ($op->type == 'Once_Off') {
                            $price += $op->per_adult_price * $request['adults'] +
                                    $op->per_child_price * $request['childs'];
                        } elseif ($op->type == 'Per_Night') {
                            $price += ($op->per_adult_price * $request['adults'] +
                                            $op->per_child_price * $request['childs']) * $nights;
                        } elseif ($op->type == 'Per_Selected_Night') {
                            $price += ($op->per_adult_price * $request['adults'] +
                                            $op->per_child_price * $request['childs']) * $selectedNights;
                        }

                        $extra['OccupancyCharge'] = [
                                'type' => $op->type,
                                'per_adult_price' => $op->per_adult_price,
                                'per_child_price' => $op->per_child_price
                        ];
                    } elseif (isset($option->FlatCharge)) {
                        $op = $option->FlatCharge;

                        if ($op->type == 'Once_Off') {
                            $price += $op->price;
                        } elseif ($op->type == 'Per_Night') {
                            $price += $op->price * $nights;
                        } elseif ($op->type == 'Per_Selected_Night') {
                            $price += $op->price * $selectedNights;
                        }

                        $extra['FlatCharge'] = [
                                'type' => $op->type,
                                'price' => $op->price
                        ];
                    } elseif (isset($option->UnitCharge)) {
                        $op = $option->UnitCharge;
                        $unit = (int) $request['unit'][$option->id];

                        $unit = min($unit, $op->max_unit);
                        $unit = max($unit, 1);

                        if ($op->type == 'Once_Off') {
                            $price += $op->per_unit_price * $unit;
                        } elseif ($op->type == 'Per_Night') {
                            $price += $op->per_unit_price * $nights * $unit;
                        } elseif ($op->type == 'Per_Selected_Night') {
                            $price += $op->per_unit_price * $selectedNights * $unit;
                        }

                        $extra['UnitCharge'] = [
                            'type' => $op->type,
                            'per_unit_price' => $op->per_unit_price,
                            'num_unit' => $unit
                        ];
                    }

                    $extra['name'] = $option->name;
                    $extra['code'] = $option->id;

                    BookingOrderExtra::create([
                        'order_id' => $bookingOrder->id,
                        'name' => $option->name,
                        'charge' => isset($extra['UnitCharge']) ? 'UnitCharge' : (isset($extra['OccupancyCharge']) ? 'OccupancyCharge' : 'FlatCharge'),
                        'type' => $op->type,
                        'quantity' => isset($unit) ? $unit : 1,
                        'price' => $price
                    ]);

                    $extrasPrice += $price;
                    $productDetails['BookingExtras']['BookingExtra'][] = $extra;
                }
            }

            $productDetails['BookingExtras']['total_price'] = $extrasPrice;
        }

        $productPrice = 0;

        $products = is_array($quote->ProviderRS->ProductGroups->ProductGroups->Products->Product)
                        ? $quote->ProviderRS->ProductGroups->ProductGroups->Products->Product
                        : [$quote->ProviderRS->ProductGroups->ProductGroups->Products->Product];

        foreach ($products as $product) {
            if ($product->id == $request['room']) {
                //for ($i = 1; $i <= $quantity; $i++) {
                if (ucfirst($request['type']) == 'Accommodation') {
                    $qt = $product->Quotes->Quote;

                    $productDetails['Product'] = [
                        'num_adult' => $request['adults'],
                        'num_children' => $request['childs'],
                        'num_concession' => 0,
                        'id' => $product->id,
                        'name' => $product->name,
                        'start_date' => $qt->start_date,
                        'finish_date' => $qt->finish_date,
                        'price' => $product->Quotes->Quote->price
                    ];

                    $bookingOrder->update([
                        'product_name' => $request['provider_name'] . ' - ' . $product->name,
                        'price' => $product->Quotes->Quote->price,
                        'extra_price' => $extrasPrice,
                        'total_price' => $product->Quotes->Quote->price + $extrasPrice,
                        'check_in' => \Carbon\Carbon::parse($qt->start_date)->format('Y-m-d H:i:s'),
                        'check_out' => \Carbon\Carbon::parse($qt->finish_date)->format('Y-m-d H:i:s')
                    ]);

                    $productPrice += $qt->price;
                } else {
                    if (isset($request['quote']) && is_array($request['quote'])) {
                        $qt = $product->Quotes->Quote[$request['quote'][$product->id]];
                    } else {
                        $qt = $product->Quotes->Quote;
                    }

                    $days = $qt->days;
                    $price_adults = $qt->price_adults * $days;
                    $price_children = isset($qt->price_children) ? $qt->price_children * $days : 0;

                    $productPrice += $price_adults + $price_children;

                    $productDetails['Product'] = [
                        'num_adult' => $request['adults'],
                        'num_children' => $request['childs'],
                        'num_concession' => 0,
                        'id' => $product->id,
                        'name' => $product->name,
                        'start_date' => $qt->start_date,
                        'finish_date' => $qt->finish_date,
                        'price' => $productPrice,
                        'price_adults' => $price_adults,
                        'price_children' => $price_children
                    ];

                    $bookingOrder->update([
                        'product_name' => $request['provider_name'] . ' - ' . $product->name,
                        'price' => $productPrice,
                        'extra_price' => $extrasPrice,
                        'total_price' => $productPrice + $extrasPrice,
                        'check_in' => \Carbon\Carbon::parse($qt->start_date)->format('Y-m-d H:i:s'),
                        'check_out' => \Carbon\Carbon::parse($qt->finish_date)->format('Y-m-d H:i:s')
                    ]);
                }
                //}
            }
        }

        $params['Reservation'] = [
            'client_id' => $clientId,
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
            /*'Contact' => [
                'Email' => $request['email_booking'],
                'Address' => [
                    'AddressLine' => $request['street_1'] . $request['street_2'],
                    'CityName' => $request['city_booking'],
                    'CountryName' => $request['country'],
                    'PostalCode' => $request['postal_code'],
                    'StateProv' => $request['state_booking']
                ]
            ]*/
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

        $result = $this->queryBook('MakeBooking', ['Reservations' => $params]);

        if (isset($result->Status) && isset($result->Status->Success)) {
            $bookingOrder->update([
                'reservation_id' => $result->Reservations->Reservation->BookingRefNo
            ]);
        } else {
            $bookingOrder->delete();
        }

        //dd ($result);

        return [$result, $bookingOrder];
    }

    public function getBookingQuote($params, $type, $shortName = 'Test_ToothnNailLodge')
    {
        $params['ProviderRQ'] = [
            'short_name' => $shortName
        ];

        if (isset($params['content_id']) && $params['content_id'])
            $params['ProviderRQ']['content_id'] = $params['content_id'];

        $start = \Carbon\Carbon::parse($params['check_in']);
        $end = \Carbon\Carbon::parse($params['check_out']);

        $type = ucfirst(strtolower($type));

        $searchCriteria = [];

        if ($type == 'Accommodation') {
            $searchCriteria['LengthNights'] = [
                'duration' => $end->diffInDays($start)
            ];
        } else {
            $searchCriteria['LengthDays'] = [
                'duration' => $end->diffInDays($start)
            ];
        }

        $searchCriteria['CommencingSpecific'] = [
            'date' => $start->format('Y-m-d')
        ];
        $searchCriteria['ConsumerCandidates'] = [
            'ConsumerCandidate' => [
                'adults' => $params['adults'],
                'children' => $params['childs']
            ]
        ];

        $params['Query'] = [
            'IndustryCategory' => $type,
            'SearchCriteria' => $searchCriteria
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
            'DistributionChannel' => [
                    'id' => config('tours.obx_account'),
                    'key' => config('tours.obx_key')
            ],
            'DistributionChannelRQ' => [
                'id' => config('tours.obx_account'),
                'key' => config('tours.obx_key')
            ]
        ];

        $response = $client->$method($params);

        return $response;
    }

    public function providerOptIn($providers = [])
    {
        $params = [];

        foreach ($providers as $provider) {
            $params['Providers']['Provider'][] = [
                'short_name' => $provider
            ];
        }

        $params['Query'] = [
            'DateRangeQuery' => [
                'status' => 'In',
                'start_date' => substr(\Carbon\Carbon::now()->startOfYear()->format(DATE_ATOM), 0, -6),
                'finish_date' => substr(\Carbon\Carbon::now()->endOfYear()->format(DATE_ATOM), 0, -6)
            ]
        ];

        return $this->querySearch('ProviderOptIn', $params);
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
