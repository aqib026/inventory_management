<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mditems extends Model
{
   protected $table = 'mditems';
   public $primaryKey = 'id';
   public $timestamps = false;     


  public function info()
  {
    return $this->belongsTo('App\Newmd','record_no','record_no');
  }
   
}
