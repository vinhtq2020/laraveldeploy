<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    //
    protected $fillable =['bill_id','book_id','book_name','quatity','unit_price'];
    public function Book(){
        return $this->belongsTo('App\Models\Book');
    }

    public function Image(){
        // return $this->hasManyThrough(
        //     'App\Models\Image',//bang can lay
        //     'App\Models\Book', //bang trung gian
        //     'id', // khoa ngoai bang trung gian
        //     'book_id',// khoa ngoai bang can lay
        //     'id'
        // );
        return $this->hasMany('App\Models\Image','book_id','book_id');
    }
    
    public function Bill(){
        return $this->belongsTo('App\Models\Bill');
    }
    

}
