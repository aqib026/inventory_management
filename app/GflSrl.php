<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GflSrl extends Model
{
   protected $table = 'gfl_srl';
   public $primaryKey = 'entry_id';
   public $timestamps = false;     

  public function info()
  {
    return $this->belongsTo('App\GflSr','return_id','return_id');
  }

}
