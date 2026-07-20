<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public function subCategories(){
        return $this->hasMany(ProductSubCategory::class,'category_id','id');
    }
}
