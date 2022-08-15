<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binvoice extends Model
{
    //

   protected $table = 'b2s_invoice';
   public $primaryKey = 'invoice_id';
   public $timestamps = false;     	

    public function order(){
    	return $this->belongsTo('App\Order','order_id','order_no');
    }

    public function customer(){
    	return $this->belongsTo('App\Customer','customer_id','customer_id');
    }


    public static function generate_invoice($r){
      $invoice = new \App\Binvoice;
      $invoice->order_id = $r->order_no;
      $invoice->customer_id = $r->customer_id;
      $invoice->amount = ($r->amount + $r->sc);
      $invoice->vat = 0.00;
      $invoice->invoice_date = date('Y-m-d');
      if($invoice->save()){
        $v = new \App\Bvoucher;
        $v->order_id = $r->order_no;
        $v->date     = date('Y-m-d');
        $v->time     = date('h:i a');
        $v->prepaired_by = \Auth::User()->username;
        $v->type     = 'rv';
        if($v->save()){

          $c = \App\Customer::where('customer_id',$r->customer_id)->first();
          $vd = new \App\BvoucherDetail;
          $vd->voucher_id    = $v->voucher_id;
          $vd->account_code  = $c->baccount->acc_code;
          $vd->account_title = $c->baccount->acc_title;
          $vd->account_cat   = $c->baccount->head_title;
          $vd->dr            = ($r->amount+$r->sc);
          $vd->narration     = 'sale against receivable for order ID : '. $r->order_no;
          $vd->save();

          $vd = new \App\BvoucherDetail;
          $vd->voucher_id    = $v->voucher_id;
          $vd->account_code  = '20001';
          $vd->account_title = 'garments_sale';
          $vd->account_cat   = 'SALE';
          $vd->cr            = ($r->amount);
          $vd->narration     = 'sale against receivable for order ID : '. $r->order_no;
          $vd->save();

          if($r->sc != 0){

          $vd = new \App\BvoucherDetail;
          $vd->voucher_id    = $v->voucher_id;
          $vd->account_code  = '20003';
          $vd->account_title = 'shipment_charges';
          $vd->account_cat   = 'shipment_charges';
          $vd->cr            = ($r->sc);
          $vd->narration     = 'shipment charges exlc VAT against sale order : '.$r->order_no .', Invoice No : '.$invoice->invoice_id;
          $vd->save();

          }

        }

      }
    }
	    
}
