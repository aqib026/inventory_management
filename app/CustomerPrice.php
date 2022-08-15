<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerPrice extends Model
{
    //
   protected $table = 'customer_price';
   public $primaryKey = 'id';
   public $timestamps = false;     
}
