<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payment_order_id' => $this->payment_order_id,
            'payment_method' => $this->payment_method,
            'total_amount' => $this->total_amount,
            'gst' => $this->gst,
            'shipping_cost' => $this->shipping_cost,
            'coupon_discount' => $this->coupon_discount,
            'order_status' => $this->order_status,
            'shipping_status' => $this->shipping_status,
            'created_at' => $this->created_at,
            'order_details' => OrderDetailResource::collection($this->orderDetails),
            'total_product' => $this->orderDetails->count(),
            'shipping_address' => new AddressResource($this->address),
        ];
    }
}
