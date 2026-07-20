<?php

namespace App\Http\Resources\Profile;

use App\Models\District;
use App\Models\State;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileInformation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'=> $this->name ?? '',
            'phone'=> $this->phone ?? '',
            'email'=> $this->email ?? '',
            'image' => !empty($this->image_name) ? url('public/profile_images/' . $this->image_name) : '' 

        ];
    }
}
