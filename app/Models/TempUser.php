<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable; 

class TempUser extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'verification_code',
        'user_unique_id',
    ];
}
