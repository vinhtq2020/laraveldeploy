<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $fillable =['author_name','introduction'];

    public function book(){
        return $this->hasMany('App\Models\Book');
    }
}
