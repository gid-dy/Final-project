<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tourpackagecategory extends Model
{
    public function tourcategories(){
        return $this->hasMany('App\Tourpackagecategory','id','id');
    }
}
