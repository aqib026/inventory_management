<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
   protected $table = 'receipt';
   public $primaryKey = 'receipt_id';
   public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','customer_id');
    }

    public function add($r){
   		$this->customer_id = $r->get('customer_id');
   		$this->date        = date('Y-m-d');
   		$this->time        = date('g:i A');
   		$this->amount      = $r->get('amount');
   		$this->acc_code    = $r->get('acc_code');
   		$this->note        = $r->get('desc');
   		$this->status      = 'pending';
   		$this->st          = $r->get('vat');
   		$this->payment_mode= $r->get('pm');
      if( $r->get('pm') == 'cp'){
        $this->cheque_due_date = date('Y-m-d',strtotime($r->get('cddate')));
      }
   		$this->user        = \Auth::User()->username;
         $this->received_by = \Auth::User()->username;
   		$this->save();
   		return true;   		
	   }

    public function pm_title(){
      if($this->payment_mode == 'cp')
        echo 'Cheque Payment';
      elseif($this->payment_mode == 'c')
        echo 'Cash';
      elseif($this->payment_mode == 'bt')
        echo 'Bank Transfer';
      elseif($this->payment_mode == 'd')
        echo 'Discount';
    }

}
