<?php

namespace App\Http\Resources;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressInformation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $addessDetails = $this->all();
        $result = [];
    
        foreach ($addessDetails as $addressDetail) {
            $result[] = [
                'id' => $addressDetail->id,
                'user_id' => $addressDetail->user_id,
                'address_type' => $addressDetail->address_type,
                'shipping_name' => $addressDetail->shipping_name,
                'shipping_email' => $addressDetail->shipping_email,
                'shipping_phone' => $addressDetail->shipping_phone,
                'shipping_address' => $addressDetail->shipping_address,
                'country' => Country::where('id', $addressDetail->country)->first()->name ?? '',
                'country_id' => $addressDetail->country,
                'state' => State::where('id', $addressDetail->state)->first()->name ?? '',
                'state_id' => $addressDetail->state,
                'city' => City::where('id', $addressDetail->city)->first()->name ?? '',
                'city_id' =>$addressDetail->city,
                'pincode' => $addressDetail->pincode,
                'landmark' => $addressDetail->landmark,
                'created_at' => $addressDetail->created_at,
                'updated_at' => $addressDetail->updated_at,
            ];
        }
    
        return $result;
    }
}
