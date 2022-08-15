<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherDetail extends Model
{
   protected $table = 'voucher_detail';
   public $primaryKey = 'id';
   public $timestamps = false;     	

    public function voucher(){
    	return $this->belongsTo('App\Voucher','voucher_id','voucher_id');
    }


   	public function invoice(){
   		return \App\Invoice::where('order_id',$this->voucher->order->order_no)->first();
   	}

}
