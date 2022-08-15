<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempOrderLine extends Model
{
   protected $table = 'temp_order_line';
   public $primaryKey = 'entry_id';
   public $timestamps = false;     	
}
