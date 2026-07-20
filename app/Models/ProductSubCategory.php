<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use HasFactory;


    public function submenus()
    {
        return $this->hasMany(ProductSubmenu::class, 'subcategory_id');
    }
}
