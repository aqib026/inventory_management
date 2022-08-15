<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

   protected $table = 'accounts';
   public $primaryKey = 'acc_code';
   public $timestamps = false;
}
