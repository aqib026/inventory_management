<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTerm extends Model
{
   protected $table = 'payment_terms';
   public $primaryKey = 'term_id';
   public $timestamps = false;     	
}
