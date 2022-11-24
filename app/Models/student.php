<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class student extends Model
{
    use HasFactory,HasApiTokens;
    public $table = 'students';
    public $fillable = [
        'name',
        'email',
        'password',
        'phoneNumber'
    ];   
}
