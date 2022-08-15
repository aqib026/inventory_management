<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2sSr extends Model
{
   protected $table = 'b2s_sr';
   public $primaryKey = 'return_id';
   public $timestamps = false;     

    public function line(){
        return $this->hasMany('App\B2sSrl','return_id','return_id');
    }
   
}
