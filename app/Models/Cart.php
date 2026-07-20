<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'color_id',
        'gift_message'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function giftWrap(){
        return $this->belongsTo(GiftWrap::class,'gift_wrap_id','id');
    }

    public function colorData()
    {
        return $this->belongsTo(ColorProduct::class, 'color_id', 'id');
    }
}
