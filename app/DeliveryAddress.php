<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    //
   protected $table = 'delivery_address';
   public $primaryKey = 'address_id';
   public $timestamps = false;     	

}
