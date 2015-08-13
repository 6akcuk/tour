<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class ProductService extends Job implements SelfHandling
{
    protected $model;

    protected $services;

    protected $images;

    /**
     * @var ATLASService
     */
    private $ATLASService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ATLASService $ATLASService, $model = null)
    {
        $this->ATLASService = $ATLASService;
        $this->model = $model;
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

    public function set($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Get product id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->model['productId'];
    }

    /**
     * Get product name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->model['productName'];
    }

    /**
     * Get product description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->model['productDescription'];
    }

    /**
     * Get product normal address.
     *
     * @return string
     */
    public function getAddress()
    {
        $address = $this->model['addresses'][0];
        return $address['addressLine1'] .', '. $address['cityName'] .', '. $address['areaName'];
    }

    public function getCoordinates()
    {
        $address = $this->model['addresses'][0];
        return [
                'lat' => $address['geocodeGdaLatitude'],
                'long' => $address['geocodeGdaLongitude']
        ];
    }

    /**
     * Get product rate from.
     *
     * @return int
     */
    public function getRateFrom()
    {
        return (int)$this->model['rateFrom'];
    }

    public function getRating()
    {
        return $this->model['attributes'][array_search('RATING AAA', array_column($this->model['attributes'], 'attributeTypeId'))]['attributeId'];
    }

    /**
     * Get product images.
     *
     * @return mixed
     */
    public function getImages()
    {
        if (!$this->images) {
            foreach ($this->model['multimedia'] as $mm) {
                $size = $mm['attributeIdSizeOrientation'];

                $this->images[$mm['altText']][$size] = $mm['serverPath'];

                if ($size == 'LARGELAND' || $size == 'LARGEPORT') $this->images[$mm['altText']]['source'] = $mm['serverPath'];
                else if (!isset($this->images[$mm['altText']]['source']) && ($size == 'LANDSCAPE' || $size == 'PORTRAIT'))
                    $this->images[$mm['altText']]['source'] = $mm['serverPath'];

                if (in_array($size, ['LARGELAND', 'LARGEPORT']))
                    $this->images[$mm['altText']]['large'] = $mm['serverPath'];

                if (in_array($size, ['LANDSCAPE', 'PORTRAIT']))
                    $this->images[$mm['altText']]['medium'] = $mm['serverPath'];
            }
        }

        //dd($this->images);

        return $this->images;
    }

    /**
     * Get product parallax image.
     *
     * @return null|string
     */
    public function getParallaxImage()
    {
        $images = $this->getImages();

        foreach ($images as $image) {
            if (isset($image['XLARGELAND']))
                return $image['XLARGELAND'];
        }

        return null;
    }

    /**
     * Get product telephone number.
     *
     * @return string
     */
    public function getTelephone()
    {
        if (in_array('CAPHENQUIR', array_column($this->model['communication'], 'attributeIdCommunication')))
            $com = $this->model['communication'][array_search('CAPHENQUIR', array_column($this->model['communication'], 'attributeIdCommunication'))];
        else
            $com = $this->model['communication'][array_search('CAMBENQUIR', array_column($this->model['communication'], 'attributeIdCommunication'))];

        return $com['communicationIsdCode'] . ' ' . (isset($com['communicationAreaCode']) ? $com['communicationAreaCode'] .' ' : '') . $com['communicationDetail'];
    }

    /**
     * Search data in attributes list.
     *
     * @param $id
     * @return array
     */
    protected function searchInAttributes($id)
    {
        $attributes = array();

        foreach ($this->model['attributes'] as $attr) {
            if ($attr['attributeTypeId'] == $id)
                $attributes[] = array(
                        'id' => $attr['attributeId'],
                        'name' => $attr['attributeIdDescription']
                );
        }

        return $attributes;
    }

    /**
     * Check specific attribute id availability.
     *
     * @param $needle
     * @return mixed
     */
    public function hasAttribute($needle)
    {
        return array_search($needle, array_column($this->model['attributes'], 'attributeId'));
    }

    /**
     * Get available entity facilities of product.
     *
     * @return array
     */
    public function getEntityFacilities()
    {
        return $this->searchInAttributes('ENTITY FAC');
    }

    /**
     * Get available service facilities of product.
     *
     * @return array
     */
    public function getServiceFacilities()
    {
        return $this->searchInAttributes('SVC FAC');
    }

    public function getServices()
    {
        if (!$this->services) {
            foreach ($this->model['services'] as $service) {
                $this->services[$service['serviceId']] = $this->ATLASService->getService($this->model['productId'], $service['serviceId']);
                //dd($services[$service['serviceId']]);
            }
        }

        //dd($this->services);

        return $this->services;
    }
}