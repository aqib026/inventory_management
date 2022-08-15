<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
   protected $table = 'temp_orders';
   public $primaryKey = 'order_no';
   public $timestamps = false;     	

    public function line(){
    	return $this->hasMany('App\TempOrderLine','order_no','order_no');
    }

}
