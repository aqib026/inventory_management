<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
   public $primaryKey = 'customer_id';
   public $timestamps = false;     	

   public function address_list(){
   		return $this->hasMany('App\DeliveryAddress','customer_id','customer_id');
   }

   public function pending(){
      return $this->hasMany('App\Receipt','customer_id','customer_id')->where('status','pending');
   }

   public function voucher_list(){
      if($this->vat == 1){
         return \App\VoucherDetail::where('account_code',$this->acc_code)->get();
      }else{
         return \App\BvoucherDetail::where('account_code',$this->acc_code)->get();
      }      
   }

    public function total_sale(){
      if($this->vat == 1){
        return \App\VoucherDetail::where('account_code',$this->acc_code)->select(\DB::raw('sum(dr) as sale'))->first();
      }else{
        return \App\BvoucherDetail::where('account_code',$this->acc_code)->select(\DB::raw('sum(dr) as sale'))->first();         }
    }

    public function total_payment(){
      if($this->vat == 1){
        return \App\VoucherDetail::where('account_code',$this->acc_code)->select(\DB::raw('sum(cr) as payment'))->first();
      }else{
        return \App\BvoucherDetail::where('account_code',$this->acc_code)->select(\DB::raw('sum(cr) as payment'))->first();         
         } 
    }

    public function all_invoices(){
      if($this->vat == 1){
        return \App\Invoice::where('customer_id',$this->customer_id)->orderBy('invoice_id','asc')->get();
      }else{
        return \App\Binvoice::where('customer_id',$this->customer_id)->orderBy('invoice_id','asc')->get();         
         } 
    }

    public function get_invoice($id){
      if($this->vat == 1){
        return \App\Invoice::where('customer_id',$this->customer_id)->where('order_id',$id)->first(['vat']);
      }else{
        return \App\Binvoice::where('customer_id',$this->customer_id)->where('order_id',$id)->first(['vat']);         
         } 
    }

    public function unpayment_invoices(){
      if($this->vat == 1){
        return \App\Invoice::where('customer_id',$this->customer_id)->where('paid',0)->get();
      }else{
        return \App\Binvoice::where('customer_id',$this->customer_id)->where('paid',0)->get();         
         } 
    }

    public function balance(){
       $balance = $this->total_sale()->sale - $this->total_payment()->payment;
       return round($balance,2);
    }

   public function account_detail(){
      if($this->vat == 1){
         return \App\Account::where('acc_code',$this->acc_code)->first();
      }else{
         return \App\Baccount::where('acc_code',$this->acc_code)->first();
      }
   }

   public function account(){
   		return $this->hasOne('App\Account','acc_code','acc_code');
   }

   public function baccount(){
   		return $this->hasOne('App\Baccount','acc_code','acc_code');
   }

}
