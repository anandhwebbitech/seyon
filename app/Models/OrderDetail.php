<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function giftWrap()
    {
        return $this->belongsTo(GiftWrap::class, 'gift_wrap_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function colorData()
    {
        return $this->belongsTo(ColorProduct::class, 'color_id', 'id');
    }
}
