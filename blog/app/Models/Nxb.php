<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nxb extends Model
{
    //
    protected $fillable = ['nxb_name'];
    public function book(){
        return $this->hasMany('App\Models\Book');
    }
}
