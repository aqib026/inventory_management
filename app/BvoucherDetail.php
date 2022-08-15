<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BvoucherDetail extends Model
{
    //
   protected $table = 'b2s_voucher_detail';
   public $primaryKey = 'id';
   public $timestamps = false;     	

    public function voucher(){
    	return $this->belongsTo('App\Bvoucher','voucher_id','voucher_id');
    }


   	public function invoice(){
   		return \App\Invoice::where('Binvoice',$this->voucher->order->order_no)->first();
   	}

}
