<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GflSr extends Model
{
   protected $table = 'gfl_sr';
   public $primaryKey = 'return_id';
   public $timestamps = false;     

    public function line(){
        return $this->hasMany('App\GflSrl','return_id','return_id');
    }

}
