<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public $primaryKey = 'order_no';
    public $timestamps = false;      

     /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['order_no'];

    //delivery_add_id

    public function del_address(){
        return $this->hasOne('App\DeliveryAddress','address_id','delivery_add_id');        
    }

    public function customer()
    {
        return $this->hasOne('App\Customer','customer_id','customer_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function commission(){
        return $this->hasMany('App\OrderCommission','order_no','order_no');
    }

    public function line(){
        return $this->hasMany('App\Orderline','order_no','order_no')->orderBy('design_code')->orderBy('color')->orderBy('size');
    }

    public function groupline()
    {
        return $this->hasMany('App\Orderline','order_no','order_no')->groupBy('item_no');
        //return \App\Orderline::where('design_code',$this->design_code)->groupBy('item_no')->get(); 
    }   


    public function address(){
        return $this->hasOne('App\DeliveryAddress','delivery_add_id','address_id');
    }

    public function countByDesign(){
        return Orderline::where('order_no',$this->order_no)->select(\DB::raw('sum(require_qty) as total,sum(filled_qty) as fqty,design_code,charged_price'))->groupBy('design_code')->get();
    }

	public function filledBoxNumbers(){
        return  Orderline::where('order_no',$this->order_no)->select(\DB::raw('DISTINCT carton_num AS box '))->orderBy('box')->get();
    }
    
    public function invoice(){
        if($this->customer->vat == 1){
            return Invoice::where('order_id',$this->order_no)->first();
        }else{
            return Binvoice::where('order_id',$this->order_no)->first();
        }
    }

    public function cancelOrder(){
        foreach($this->line as $ol){
            $qty = $ol->filled_qty;
            if($qty == 0) $qty = $ol->require_qty;
            ItemSizeColor::updateAqty($ol->item_no,$qty,'add');
        }
    }
    public function orderReplace(){

        /* Repost Missing Items */      

            $lines = \App\Orderline::where('order_no',$this->order_no)->whereRaw('require_qty != filled_qty')->get();
            if($lines->count()){
                $new_o = new \App\Order;
                $new_o = $this->replicate();
                $new_o->order_date    =  date('Y-m-d');
                $new_o->order_status  =  'placed';
                $new_o->order_ref     =  $this->order_no;

                $new_o->tracking_num     =  '';
                $new_o->po_num           =  '';
                $new_o->shipment_charges =  0.00;
                                               
                $new_o->order_channel = 'old_hawavee_order';            
                if($new_o->save()){

                    foreach($lines as $line){
                        $l = new \App\Orderline;
                        $l = $line->replicate();
                        $l->order_no    = $new_o->order_no;
                        $l->require_qty = ($line->require_qty - $line->filled_qty);
                        $l->filled_qty  = 0;
                        $l->save();
                    }
                }                
            return $new_o->order_no;
            return 1;
            }
            return 0;
        /* Repost Missing Items */      

    }

    public function orderCommission(){
        /*  Commission Calculations */   
            $dcs = \App\Orderline::where('order_no',$this->order_no)->select(\DB::raw('sum(filled_qty) as qty,design_code,charged_price'))->groupBy('design_code')->get();   
            $c = \App\Customer::find($this->customer_id);
            foreach($dcs as $dc){
                $oc = \App\OrderCommission::where('order_no',$this->order_no)->where('design_code',$dc->design_code)->first();
                $item = \App\Item::where('design_code',$dc->design_code)->first();
                if($c->vat == 0)
                    $i_price = $item->b2s_p;
                else
                    $i_price = $item->gfl_p;

                if($oc != null){
                    $comm = ($dc->qty * $dc->charged_price ) - ($dc->qty * $i_price);
                    $oc->filled_qty   = $dc->qty;
                    $oc->commission   = $comm;
                    $oc->save();
                }
            }
        /*  Commission Calculations */     

    }

}
