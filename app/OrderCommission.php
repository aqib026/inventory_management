<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderCommission extends Model
{
   protected $table = 'orders_commissions';
   public $primaryKey = 'id';
   public $timestamps = false;     	

   public function order(){
		return $this->belongsTo('App\Order','order_no','order_no');   	
   }
}
