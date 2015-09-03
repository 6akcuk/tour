<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingOrder extends Model
{
    //
    protected $fillable = [
        'reservation_id',
        'client_id',
        'type',
        'firstname',
        'lastname',
        'email',
        'payment_type',
        'card',
        'billing_address',
        'product_name',
        'check_in',
        'length',
        'adults',
        'childs',
        'price',
        'extra_price',
        'total_price'
    ];

    protected $dates = ['created_at', 'updated_at', 'check_in'];

    public function getName()
    {
        return $this->firstname .' '. $this->lastname;
    }

    public function extras()
    {
        return $this->hasMany('App\BookingOrderExtra', 'order_id');
    }
}
