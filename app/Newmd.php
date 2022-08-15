<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newmd extends Model
{
   protected $table = 'newmd';
   public $primaryKey = 'record_no';
   public $timestamps = false;     

    public function line(){
        return $this->hasMany('App\Mditems','record_no','record_no');
    }
}
