<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class book extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','author_id','book_cost'];

}
