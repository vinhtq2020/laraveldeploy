<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookView extends Model
{
    //
    protected $fillable = ['book_id','view_number','month','year'];
}
