<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2sSrl extends Model
{
   protected $table = 'b2s_srl';
   public $primaryKey = 'entry_id';
   public $timestamps = false;     

  public function info()
  {
    return $this->belongsTo('App\B2sSr','return_id','return_id');
  }

}
