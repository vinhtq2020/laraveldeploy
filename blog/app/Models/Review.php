<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    //
    protected $fillable = ['user_id','book_id','rate','content','like','isReview'];

    public function book(){
        return $this->belongsTo('App\Models\Book');
    }
    public function image(){
        return $this->hasMany('App\Models\Image','book_id','book_id');
    }
}
