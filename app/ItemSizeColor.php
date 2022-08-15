<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemSizeColor extends Model
{
    //

   protected $table = 'item_size_color';
   public $primaryKey = 'item_sc_code';
   public $timestamps = false;     	

    public function info()
    {
        return $this->BelongsTo('App\Item','design_code','design_code');
    } 


   public static function updateAqty($item_no,$qty,$action){
   		$isc = ItemSizeColor::where('item_sc_code',$item_no)->first();
   		if($action == 'add'){
   			$isc->aqty = $isc->aqty + $qty;
   		}elseif($action == 'sub'){
   			$isc->aqty = $isc->aqty - $qty;
   		}
   		$isc->save();
   }

   public static function getqty1($item_code){
      $get_isc = \App\ItemSizeColor::where('item_sc_code',$item_code)->first();
      if($get_isc->count()){

        // Total Design with color purchased  
        $total_purchase_qty = \App\Purchaseorderline::where('design_code',$get_isc->design_code)->where('color',$get_isc->color)->where('size',$get_isc->size)->select(\DB::raw('sum(received_qty) as pqty'))->join('p_orders1', function ($query) { $query->on('p_orders1.p_order_no', 'p_order_line1.p_order_no'); $query->where('order_status', 'received'); })->first();
        $purchase_qty = $total_purchase_qty->pqty;
        $get_isc->no_in_stock = $purchase_qty;

        // Total Design with color sold   DELIVERED
        $total_dsold_qty = \App\Orderline::where('item_no',$get_isc->item_sc_code)->where( function ($query) {
                          $query->where('orders.order_status', 'dispatched')
                                ->Orwhere('orders.order_status', 'delivered');
                      }
        )->select(\DB::raw('sum(filled_qty) as sqty'))->join('orders',function ($query) { 
                    $query->on('orders.order_no', 'order_line.order_no'); 
                })->first();
        $dsold_qty = $total_dsold_qty->sqty;


        // Total Design with color sold  ANY STATUS
        $total_sold_qty = \App\Orderline::where('item_no',$get_isc->item_sc_code)->select(\DB::raw('sum(require_qty) as sqty'))->join('orders',function ($query) { $query->on('orders.order_no', 'order_line.order_no'); $query->where('orders.order_status','!=', 'dispatched'); $query->where('orders.order_status','!=', 'delivered'); $query->where('orders.order_status','!=', 'canceled'); })->first();
        $sold_qty = $total_sold_qty->sqty;

        // Total Design with color Returned  
        $total_gflreturn_qty = \App\GflSrl::where('item_no',$get_isc->item_sc_code)->select(\DB::raw('sum(return_qty) as return_qty'))->join('gfl_sr',function ($query) { $query->on('gfl_sr.return_id', 'gfl_srl.return_id'); $query->where('gfl_sr.status', 'posted');})->first();


        $total_b2sreturn_qty = \App\B2sSrl::where('item_no',$get_isc->item_sc_code)->select(\DB::raw('sum(return_qty) as return_qty'))->join('b2s_sr',function ($query) { $query->on('b2s_sr.return_id', 'b2s_srl.return_id'); $query->where('b2s_sr.status', 'posted');})->first();

        $return_qty = $total_gflreturn_qty->return_qty + $total_b2sreturn_qty->return_qty;

        // Recounting Recounting Recounting
        $total_recounting = \App\Mditems::where('item_no',$get_isc->item_sc_code)->select(\DB::raw('sum(qty) as re_qty'))->join('newmd',function ($query) { $query->on('newmd.record_no', 'mditems.record_no'); $query->where('newmd.status',1);})->first();
        $recounting = $total_recounting->re_qty;

        $available_in_warehouse = $purchase_qty - $dsold_qty + $return_qty + ($recounting);
        $get_isc->available_in_warehouse = $available_in_warehouse;

        $available_for_sale = $purchase_qty - $sold_qty - $dsold_qty + $return_qty + ($recounting);
        $get_isc->aqty = $available_for_sale;
        $get_isc->qty = $available_for_sale;
        //get_isc
        $color_count = \App\ItemSizeColor::select(\DB::raw('sum(aqty) as cqty'))->where('color',$get_isc->color)->where('design_code',$get_isc->design_code)->first();

        $get_isc->color_count = $color_count->cqty;
        $get_isc->save();

        return array($available_in_warehouse,$available_for_sale);

      }else
        return array(0,0);
   }

  public static function get_design_qty($dc){
      $get_dc = \App\Item::where('design_code',$dc)->first();
      if($get_dc != null){

        // Total Design with color purchased  
        $total_purchase_qty = \App\Purchaseorderline::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(received_qty) as pqty'))->join('p_orders1', function ($query) { $query->on('p_orders1.p_order_no', 'p_order_line1.p_order_no'); $query->where('order_status', 'received'); })->first();
        $purchase_qty = $total_purchase_qty->pqty;

        // Total Design with color sold   DELIVERED
        $total_dsold_qty = \App\Orderline::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(filled_qty) as sqty'))->join('orders',function ($query) { $query->on('orders.order_no', 'order_line.order_no'); $query->where('orders.order_status', 'delivered'); })->first();
        $dsold_qty = $total_dsold_qty->sqty;


        // Total Design with color sold  ANY STATUS
        $total_sold_qty = \App\Orderline::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(require_qty) as sqty'))->join('orders',function ($query) { $query->on('orders.order_no', 'order_line.order_no'); $query->where('orders.order_status','!=', 'delivered'); $query->where('orders.order_status','!=', 'canceled'); })->first();
        $sold_qty = $total_sold_qty->sqty;

        // Total Design with color Returned  
        $total_gflreturn_qty = \App\GflSrl::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(return_qty) as return_qty'))->join('gfl_sr',function ($query) { $query->on('gfl_sr.return_id', 'gfl_srl.return_id'); $query->where('gfl_sr.status', 'posted');})->first();


        $total_b2sreturn_qty = \App\B2sSrl::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(return_qty) as return_qty'))->join('b2s_sr',function ($query) { $query->on('b2s_sr.return_id', 'b2s_srl.return_id'); $query->where('b2s_sr.status', 'posted');})->first();

        $return_qty = $total_gflreturn_qty->return_qty + $total_b2sreturn_qty->return_qty;

        // Recounting Recounting Recounting
        $total_recounting = \App\Newmd::where('design_code',$get_dc->design_code)->select(\DB::raw('sum(qty) as re_qty'))->join('mditems',function ($query) { $query->on('newmd.record_no', 'mditems.record_no'); $query->where('newmd.status',1);})->first();

        $recounting = $total_recounting->re_qty;

        $available_in_warehouse = $purchase_qty - $dsold_qty + $return_qty + ($recounting);

        $available_for_sale = $purchase_qty - $dsold_qty - $sold_qty + $return_qty + ($recounting);

        return array($available_in_warehouse,$available_for_sale);

      }else
        return array(0,0);
  }


}
