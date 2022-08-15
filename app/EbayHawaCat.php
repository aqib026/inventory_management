<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayHawaCat extends Model
{
    //
   protected $table = 'ebay_hawavee_cat';
   public $primaryKey = 'id';
   public $timestamps = false;     	

   // public function category()
   // {
   // 		return $this->belongsTo('App\Category');
   // }

}
