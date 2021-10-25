<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable =['book_name','book_seo','category_id','content','nxb_id','author_id','republic','year','price','quantity'];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function image(){
        return $this->hasOne('App\Models\Image');
    }

    public function author(){
        return $this->belongsTo('App\Models\Author');
    }

    public function bill_detail(){
        return $this->hasMany(BillDetail::class);
    }

    public function nxb(){
        return $this->belongsTo('App\Models\Nxb');
    }
    public function bookrate(){
        return $this->hasOne('App\Models\BookRate');
    }
}
