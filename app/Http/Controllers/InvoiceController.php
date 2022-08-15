<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function view_invoice($order_no){
        $order = \App\Order::where('order_no',$order_no)->first();
        if($order->customer->vat == 1){
            $invoice = \App\Invoice::where('order_id',$order_no)->first();            
        }else{
            $invoice = \App\Binvoice::where('order_id',$order_no)->first();            
        }
        return view('invoice.view',compact('order','invoice'));
    }

    public function generate_invoice(Request $r){
        $order = \App\Order::where('order_no',$r->order_no)->first();
        if($order->customer->vat == 1){
            \App\Invoice::generate_invoice($r);
        }else{
            \App\Binvoice::generate_invoice($r);
        }
         return redirect('/view_invoice/'.$r->input('order_no'));
    }

    public function view_list($order_no){
        $order = \App\Order::where('order_no',$order_no)->first();
        return view('invoice.list',compact('order'));        
    }

    public function shipping_charges($order_no){
        $o = \App\Order::where('order_no',$order_no)->first();
        return view('invoice.shipping',compact('o')); 
    }

    public function add_shipping(Request $r){
        if($r->input('order_no') != ''){
            $o = \App\Order::where('order_no',$r->input('order_no'))->first();
            $o->shipment_charges = $r->input('sc');
            $o->tracking_num = $r->input('tracking');
            $o->save();
        }
        return redirect('/view_invoice/'.$r->input('order_no'));
    }
    //

    public function summary($order_no){
    	$order = \App\Order::where('order_no',$order_no)->first();
    	return view('invoice.summary',compact('order'));
    }

    public function edit_invoice_qty($order_no){
    	$order = \App\Order::where('order_no',$order_no)->first();
    	return view('invoice.editqty',compact('order'));
    }

    public function edit_qty($order_no,$item_no){
    	$line = \App\ItemSizeColor::where('item_sc_code',$item_no)->first(); 
    	return view('invoice.editlineqty',compact('line','order_no'));
    }

    public function update_edit_qty(Request $request){
        if($request->input('require_qty') != ''){
            $line = \App\Orderline::where('order_no', $request->input('order_no'))->where('item_no', $request->input('item_no'))->first();
            $item = \App\ItemSizeColor::where('item_sc_code',$request->input('item_no'))->first();
            $item->aqty = $item->aqty + $line->require_qty;
            $item->save();
            $line->require_qty = $request->input('require_qty');
            $line->save();
            $item->aqty = $item->aqty - $line->require_qty;
            $item->save();
            $request->session()->flash('success', 'Category Has Been Updated Successfully');
            return redirect('/edit_invoice_qty/'.$request->input('order_no'));
        }
    }
    
    public function updateBoxes(Request $request){
        try {
            //ALTER TABLE fashi326_fsd.order_line ADD COLUMN carton_num INT(10) NULL
            
            $data = $request->input('fill');
            $cumulative_elo = [];
            $last_box = \DB::select( "SELECT MAX(ol.carton_num) as carton_num FROM orders o INNER JOIN order_line ol ON o.order_no = ol.order_no WHERE o.order_status = 'filled' AND o.order_date > '2017-09-19' AND o.`delivered_date` IS NULL");
            if(sizeof($request->input('ids')) > 0){                
               $cumulative_elo = \App\Orderline::whereIn('entry_id', $request->input('ids') )->get();
               $orderNo = null;
               $filled = 0;
               //foreach ($last_box as $max){
               //    $filled = intval($max->carton_num);
               //    break;
               //}
               foreach($cumulative_elo as $ol){
                   //$ol = \App\Orderline::where('entry_id',$k)->first();
                   $ol->filled_qty = intval($data[$ol->entry_id]['filled_qty']);
                   $ol->carton_num = intval($filled) + intval($data[$ol->entry_id]['carton_num']);
                   //return $ol;//$data[$ol->entry_id]['carton_num'];
                   $orderNo = $ol->order_no;
                   $ol->save();
               }
               
               $o = \App\Order::where('order_no',$orderNo)->first();
               if($o->order_status == 'placed'){
                   $o->order_status = 'filled';
               }
               $o->save();
            }
            return $cumulative_elo;
        } catch (Exception $e) {
            return 'sss';
        }
    }

}

