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

    public function getEmbedUrlAttribute()
    {
        if (!$this->url) return '';
        
        $cleanUrl = strtok($this->url, '?');
        return rtrim($cleanUrl, '/') . '/embed';
    }
}
