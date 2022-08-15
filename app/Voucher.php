<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{


   protected $table = 'voucher';
   public $primaryKey = 'voucher_id';
   public $timestamps = false;     	

    public function detail(){
    	return $this->hasMany('App\VoucherDetail','voucher_id','voucher_id');
    }

    public function order(){
    	return $this->belongsTo('App\Order','order_id','order_no');
    }

    public static  function generate_voucher($receipt_id){
      $r = \App\Receipt::find($receipt_id);      
      if($r == null){        
        return 'Receipt not found';  
      }
      $narration = 'Payment received by : '.$r->received_by.' on '.date('Y-m-d');
      if($r->payment_mode == 'd'){
        $narration = 'Discount given by : '.$r->received_by.' on '.date('Y-m-d');
      }

      $c = \App\Customer::where('customer_id',$r->customer_id)->first();
      $v = \App\Voucher::where('receipt_id',$receipt_id)->first(); 
      if($v != null){        
        return 'Transaction has already been posted';  
      }
      $v = new \App\Voucher;
      $v->date = date('Y-m-d'); 
      $v->time = date('h:i a');
      $v->prepaired_by = \Auth::User()->username;
      $v->description  = $r->note;
      $v->type         = 'rv';
      $v->receipt_id   = $r->receipt_id;
      if($v->save()){
        if($r->payment_mode == 'd'){
          $vd = new \App\VoucherDetail;
          $vd->voucher_id   = $v->voucher_id;
          $vd->account_code = 40000; 
          $vd->account_title = 'sale_discount'; 
          $vd->account_cat = 'discounts';
          $vd->dr = $r->amount;
          $vd->narration  = $narration;
          $vd->save();
        }else{
          $vd = new \App\VoucherDetail;
          $vd->voucher_id   = $v->voucher_id;
          $vd->account_code = 30001; 
          $vd->account_title = 'BANK'; 
          $vd->account_cat = 'CURRENT_ASSET';
          $vd->dr = $r->amount;
          $vd->narration  = $narration;
          $vd->save();          
        }
          $vd = new \App\VoucherDetail;
          $vd->voucher_id   = $v->voucher_id;
          $vd->account_code = $c->account_detail()->acc_code; 
          $vd->account_title = $c->account_detail()->acc_title; 
          $vd->account_cat = $c->account_detail()->head_title;
          $vd->cr = $r->amount;
          $vd->narration  = $narration;
          $vd->save();
      }
      return 'done';

    }

}
