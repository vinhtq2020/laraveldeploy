<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReceived extends Model
{
    //
    protected $fillable =['book_id','book_name','quatity','unit_price','amount','create_at'];

    public function book(){
        return $this->belongsTo('App\Models\Book');
    }
}
