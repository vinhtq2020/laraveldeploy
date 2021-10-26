<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookUserView extends Model
{
    protected $fillable = ['book_id','user_id'];
    public function book(){
        return $this->belongsTo('App\Models\Book');
    }
    public function image(){
        return $this->belongsTo('App\Models\Image','book_id','book_id');
    }
}
