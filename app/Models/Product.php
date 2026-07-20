<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }
    public function isWishlist()
    {
        return $this->hasOne(Wishlist::class, 'product_id', 'id')
                    ->where('user_id', auth()->id());
    }
    public function shopByAges()
    {
        return $this->belongsToMany(ShopByAge::class, 'product_shop_by_age', 'product_id', 'shop_by_age_id');
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product')
                    ->withPivot('id','qty','variant_name')
                    ->withTimestamps();
    }
    public function productVariants()
    {
        return $this->hasMany(\App\Models\ColorProduct::class, 'product_id') ;  
    }
    public function cart()
    {
        return $this->hasOne(Cart::class)->where('user_id', auth()->id());
    }
    public function reviews(){
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
    public function proImages(){
        return $this->hasmany(Upload::class, 'product_id','id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
    
}
