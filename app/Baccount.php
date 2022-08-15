<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baccount extends Model
{
   protected $table = 'b2s_accounts';
   public $primaryKey = 'acc_code';
   public $timestamps = false;
    //
}
