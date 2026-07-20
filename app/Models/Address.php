<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function countryDetail()
    {
        return $this->belongsTo(Country::class, 'country','id');
    }

    public function stateDetail()
    {
        return $this->belongsTo(State::class, 'state','id');
    }

    public function cityDetail()
    {
        return $this->belongsTo(City::class, 'city','id');
    }

    public function shippingPrice()
    {
        return $this->belongsTo(ShippingPrice::class, 'state', 'state_id');
    }
}
