<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingOrderExtra extends Model
{
    //
    protected $fillable = [
        'order_id',
        'name',
        'charge',
        'type',
        'quantity',
        'price'
    ];
}
