<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    protected $fillable =['user_id','total','status'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function billdetails(){
        return $this->hasMany(BillDetail::class);
    }
}

