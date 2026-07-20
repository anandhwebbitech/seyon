<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shipping_name' => $this->shipping_name,
            'shipping_email' => $this->shipping_email,
            'shipping_phone' => $this->shipping_phone,
            'shipping_address' => $this->shipping_address,
            'country' => Country::where('id', $this->country)->first()->name ?? '',
            'state' => State::where('id', $this->state)->first()->name ?? '',
            'city' => City::where('id', $this->city)->first()->name ?? '',
            'pincode' => $this->pincode,
            'landmark' => $this->landmark,
        ];
    }
}
