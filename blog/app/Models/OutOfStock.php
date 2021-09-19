<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutOfStock extends Model
{
    //
    protected $fillable = ['book_id','book_name','quatity'];

}
