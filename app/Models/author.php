<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class author extends Authenticatable
{
    use HasFactory , Authenticatable , HasApiTokens;

    protected $fillable = ['name','email','password','phoneNumber'];

    public function books()
    {
        return $this->hasMany(book::class);
    }
}
