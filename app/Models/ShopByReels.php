<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopByReels extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'url',
        'redirect_url',
        'status',
    ];
}
