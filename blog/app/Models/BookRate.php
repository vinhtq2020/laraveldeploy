<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRate extends Model
{
    //
    protected $fillable =['book_id','vote_number','rate'];
}
