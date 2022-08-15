<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;
use Auth;

class Item extends Model
{
    //

    public $timestamps = false;

    public function count()
    {
        $qty = \App\ItemSizeColor::where('design_code',$this->design_code)->select(\DB::raw('sum(aqty) as qty'))->first();
        return $qty->qty;        
    } 

    public function images()
    {
        return $this->hasMany('App\ItemImages','design_code','design_code');
    } 

    public function sizeAndColors()
    {
        return $this->hasMany('App\ItemSizeColor','design_code','design_code')->orderBy('color_count','desc');
    }   

    public function colors()
    {
        return \App\ItemSizeColor::where('design_code',$this->design_code)->groupBy('color')->get(); 
    }   

    public function sizes()
    {
        return \App\ItemSizeColor::where('design_code',$this->design_code)->groupBy('size')->get(); 
    }   

    
    public function cover_image()
    {
        return $this->hasOne('App\ItemImages','design_code','design_code')->where('cover', 1);
    }

    public static function get_cover_image($dc)
    {
        return \App\ItemImages::where('design_code',$dc)->where('cover', 1)->first();
    }


    public static function get_aqty($isc)
    {
        return \App\ItemSizeColor::where('item_sc_code',$isc)->first();
    }

    public function main_category()
    {
    	return $this->belongsTo('App\Category','main_cat_id','cat_id');
    }

    public function sec_category()
    {
    	return $this->belongsTo('App\Category','sec_cat_id','cat_id');
    }

    public function third_category()
    {
    	return $this->belongsTo('App\Category','category_id','cat_id');
    }

    public function child_categories($id)
    {
        return $this->belongsTo('App\Category','category_id','cat_id');
    }

    public function ebayIds()
    {
        return $this->hasMany('App\EbayItemIds');
    }

    public function design_quantity()
    {
        return $this->hasMany('App\EbayItemIds');
    }

    public static function price($item,$customer_id){
        $c = \App\Customer::where('customer_id',$customer_id)->first();

        if(\Entrust::hasRole('dropshipper')){
            if($item->dps_price == 0)
                $price =  $item->dps_price;
            else
                $price =  $item->b2s_p;
        }elseif($c->vat == 1){
            $price =  $item->gfl_p;
        }elseif($c->vat == 0){
            $price =  $item->b2s_p;
        }
        $cp = \App\CustomerPrice::where('customer_id',$customer_id)->where('design_code',$item->design_code)->first();
        if($cp != null)
            $cp = $cp->price;
        else
            $cp = 0;
        if(\Entrust::hasRole('dropshipper') && $cp == 0){
            $cp = $price;
        }
        $min   = $price;
        $price = $price + ($price * 0.15);
        return array('price'=>round($price,2),'cp'=>round($cp,2),'min'=>$min);
    }

    public static function add_temp_order_line($item_id,$qty,$orderid,$c_price){
        $temp_order = TempOrder::where('order_no',$orderid)->first();
        $item       = ItemSizeColor::where('item_sc_code',$item_id)->first();

        $temp_line = TempOrderLine::where('item_no',$item_id)->where('order_no',$orderid)->first();

        if($temp_line == null){
            $insert = new TempOrderLine;
            $insert->order_no       = $orderid;
            $insert->item_no        = $item_id;        
            $insert->design_code    = $item->design_code;
            $insert->size           = $item->size;
            $insert->color          = $item->color;        
            $insert->require_qty    = $qty;
            $insert->charged_price  = $c_price;
            if($insert->save()){
                $item->aqty = $item->aqty - $qty;
                $item->save();  
                self::setCustomerPrice($temp_order->customer_id,$item->design_code,$c_price);
            }
        }else{
            $temp_line->require_qty = $temp_line->require_qty +  $qty;
            if($temp_line->save()){
                $item->aqty = $item->aqty - $qty;
                $item->save(); 
                self::setCustomerPrice($temp_order->customer_id,$item->design_code,$c_price);                                 
            }
        }

    }

    public static function complete_order($r,$orderid){
        $temp_order = TempOrder::where('order_no',$orderid)->where('order_status','pending')->first();
        $c = \App\Customer::find($temp_order->customer_id);
        if($temp_order != null){
            $now = Carbon::now();
            $order = new Order;
            $order->customer_id = $temp_order->customer_id;
            $order->order_date  = date('Y-m-d');
            $order->order_time  = $now->format('g:i A');
            $order->expected_delivery_date = $temp_order->expected_delivery_date;
            if(\Entrust::hasRole('dropshipper')){
                $order->sale_person = 'elam';
            }else{
                $order->sale_person = Auth::User()->username;                
            }
            $order->placed_by   = Auth::User()->username;
            $order->user_id   = Auth::User()->member_id;
            $order->order_status= 'placed';
            if($c->vat == 1)
                $order->vat         = '20.00';
            else
                $order->vat         = '0.00';
            $order->delivery_add_id = $r->cust_add;
            $order->expec_pay_date  = $r->expec_pay_date;
            $order->order_type  = $temp_order->order_type;
            if($c->vat == 1)
                $order->company_id = 3;
            else
                $order->company_id = 1;
            $order->note = $r->note;
            if($order->save()){
              foreach($temp_order->line as $tol){
                $ol = new Orderline;
                $ol->order_no      = $order->order_no;
                $ol->item_no       = $tol->item_no;
                $ol->design_code   = $tol->design_code;
                $ol->size          = $tol->size;
                $ol->color         = $tol->color;
                $ol->require_qty   = $tol->require_qty;
                $ol->charged_price = $tol->charged_price;
                $ol->save();
              }  
            }
            $temp_order->order_status = 'placed';
            $temp_order->save();

        /*  Commission Calculations */   
            $dcs = \App\Orderline::where('order_no',$order->order_no)->select(\DB::raw('sum(require_qty) as qty,design_code,charged_price'))->groupBy('design_code')->get();   
            foreach($dcs as $dc){
                $item = \App\Item::where('design_code',$dc->design_code)->first();
                if($c->vat == 0)
                    $i_price = $item->b2s_p;
                else
                    $i_price = $item->gfl_p;
                $comm = ($dc->qty * $dc->charged_price ) - ($dc->qty * $i_price);
                if($comm > 0){
                    $oc = new \App\OrderCommission;
                    $oc->order_no    = $order->order_no;
                    $oc->design_code = $dc->design_code;
                    $oc->sale_price  = $i_price;
                    $oc->charged_price  = $dc->charged_price;
                    $oc->required_qty   = $dc->qty;
                    $oc->commission     = $comm;
                    $oc->save();
                }
            }
        /*  Commission Calculations */           
        }
    }

    public static function setCustomerPrice($customer_id,$design_code,$c_price){
        $cust_p = CustomerPrice::where('customer_id',$customer_id)->where('design_code',$design_code)->first();
        if(empty($cust_p)){
            $cust_p = new CustomerPrice;
            $cust_p->customer_id  = $customer_id;
            $cust_p->design_code  = $design_code;
            $cust_p->price        = $c_price;
            $cust_p->created_date = date('Y-m-d');
            $cust_p->save();
        }else{
            $cust_p->price        = $c_price;
            $cust_p->created_date = date('Y-m-d');
            $cust_p->save();                
        }
    } 

}

