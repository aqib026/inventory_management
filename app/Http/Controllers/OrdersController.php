<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bigcommerce\Api\Client as Bigcommerce;
use Illuminate\Support\Facades\Input;
use \App\Order;
use Auth;

class OrdersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $bigcommerce;

    public function __construct(/*Bigcommerce $bigcommerce*/)
    {
        $this->middleware('auth');
        //$this->bigcommerce = $bigcommerce;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function hawavee(Request $request)
    {  
        $orders = \App\Order::select('orders.*')->orderBy('order_no', 'desc');
        $orders = $orders->where( function($query){
            $query->where('order_channel',null);
            $query->orWhere('order_channel','old_hawavee_order');
        });
            $orders = $orders->join('customers', function($query){
                $query->on('orders.customer_id','customers.customer_id');
            });
                
                if(\Entrust::hasRole('dropshipper')){
                    $orders = $orders->where('customer_id',Auth::user()->assign_customer);
                }elseif(\Auth::User()->username == 'elam'){
                    $orders = $orders->where('sale_person','elam')->orWhere('sale_person','shahzadmn');
                }else{
                    $orders = $orders->where('sale_person','!=','elam')->where('sale_person','!=','shahzadmn');
                }
                $search = '';
                $type = 'all';
                $filter_by = '';
                $filter_status = '';
                if( $request->input('search') && $request->input('filter_by') ){
                    $search = $request->input('search');
                    $filter_by = $request->input('filter_by');
                    if($filter_by == 'customer_id')
                        $orders = $orders->where('orders.customer_id','like','%'.$search.'%');
                        else
                            $orders = $orders->where($filter_by,'like','%'.$search.'%');
                }
                if($request->input('filter_status')){
                    $filter_status = $request->input('filter_status');
                    $orders = $orders->where('order_status',$filter_status);
                }
                
                if($request->input('code') || $request->input('size') || $request->input('color')
                    || $request->input('start_delv') || $request->input('end_delv')){
                    $orders = $orders->join('order_line', function($q){
                        $q->on('orders.order_no','order_line.order_no');
                    })->groupBy('orders.order_no');
                    
                    if($request->input('code')){
                        $orders = $orders->where('order_line.design_code','like','%'.$request->input('code').'%');
                    }
                    
                    if($request->input('size')){
                        $orders = $orders->where('order_line.size','like','%'.$request->input('size').'%');
                    }
                    
                    if($request->input('color')){
                        $orders = $orders->where('order_line.color','like','%'.$request->input('color').'%');
                    }
                    
                    if($request->input('start_delv') && $request->input('end_delv')){
                        $orders = $orders->whereBetween('delivered_date',[$request->input('start_delv'), $request->input('end_delv')]);
                    }
                }
                
                
                $orders = $orders->paginate(50);
        
        return view('orders/index',compact('search','orders','type','filter_by','request'));
    }

    public function hawavee_pending(Request $request)
    {  
        $orders = \App\Order::orderBy('order_no', 'desc');
        $orders = $orders->where( function($query){
            $query->where('order_channel',null);
            $query->orWhere('order_channel','old_hawavee_order');
        });
        $orders = $orders->join('customers', function($query){
             $query->on('orders.customer_id','customers.customer_id');
        });
        $filter_by = '';
        $filter_status = '';
        if(\Entrust::hasRole('salesman')){
            $orders = $orders->where('sale_person','!=','elam')->where('sale_person','!=','shahzadmn');
        }elseif(\Entrust::hasRole('dropshipper')){
            $orders = $orders->where('customers.customer_id',Auth::user()->assign_customer);
        }elseif(\Auth::User()->username == 'elam'){
            $orders = $orders->where('sale_person','elam')->orWhere('sale_person','shahzadmn');
        }
        if($request->get('ostatus') == 'dispatched'){
            $orders = $orders->where('order_status','dispatched' );
        }else{
            $orders = $orders->where( function($query){
                $query->where('order_status','placed');
                $query->orWhere('order_status','filled');
            });            
        }
        $search = '';
        $type = 'pending';
        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $orders = $orders->where($filter_by,'like','%'.$search.'%');
        }
        $orders = $orders->paginate(50);
        
        return view('orders/index',compact('search','orders','type','filter_by','request'));
    }

    public function commission(Request $r){

        $sub_sql = " AND (sale_person != 'elam' AND sale_person != 'shahzadmn')";
        if($r->get('start_date') != ''){
            $start_date  = $r->get('start_date');            
            $start_date  = date('Y-m-d',strtotime($start_date));      
        }            
        else
            $start_date  = date('Y-m-01');

        if($r->get('end_date') != ''){
            $end_date  = $r->get('end_date');     
            $end_date  = date('Y-m-d',strtotime($end_date));      
        }       
        else
            $end_date  = date('Y-m-d');
        if(\Entrust::hasRole('owner')){
            if($r->get('saleman') != ''){
                $d_s  = $r->get('saleman');
                $sub_sql .= ' AND sale_person = "'.$r->get('saleman').'"';
            }else
                $d_s  = '';
        }else{
            $sub_sql .= ' AND sale_person = "'.\Auth::User()->username.'"';
        }

         $comms = \DB::select("SELECT oc.id,i.invoice_id as gflinv,bi.invoice_id  as b2sinv,i.paid as gflp,bi.paid as b2sp,o.order_no,o.amount,o.vat,o.sale_person,o.order_date,sum(oc.commission) as comm,oc.paid 
            FROM orders o  
            RIGHT JOIN orders_commissions oc ON o.order_no=oc.order_no
            LEFT JOIN invoice i ON i.order_id=o.order_no 
            LEFT JOIN b2s_invoice bi ON bi.order_id=o.order_no
            WHERE o.order_status = 'delivered' $sub_sql
            AND (i.invoice_id is Null AND bi.paid = 1
            OR bi.invoice_id is Null AND i.paid = 1)
            AND order_date BETWEEN  '".$start_date."' AND '".$end_date."'
            group by oc.order_no");
         if(\Entrust::hasRole('owner'))
            return view('orders/commission',compact('comms','start_date','end_date','d_s'));
         else
            return view('orders/scommission',compact('comms','start_date','end_date','d_s'));
    }

    public function post_comm(Request $r){
        if($r->get('make_payment') != ''){
            foreach($r->get('make_payment') as $d){
                $oc = \App\OrderCommission::find($d);
                $oc->paid = 1;
                $oc->save();
            }
        }
        return redirect('/commission')->with('success','Commissions Updated Successfully');
    }

    public function change_status($order_no){
        $order = \App\Order::where('order_no',$order_no)->first();
        return view('orders/status',compact('order'));
    }

    public function update_status(Request $r){
        //
        $order = \App\Order::where('order_no',$r->get('order_no'))->where('order_status','!=','canceled')->first();

        if($order == null ){
            $r->session()->flash('error','Order not found , either status is changed already or invoice not created');
            return redirect('hawavee_orders/'.$r->get('order_no'));                        
        }
        if($order->order_status != 'filled' && $r->get('status') == 'dispatched'){
            $r->session()->flash('error','Order cannot be dispatched as its not filled yet !');
            return redirect('hawavee_orders/'.$r->get('order_no'));                        
        }
        if($order->invoice() == "" && $r->get('status') == 'delivered' ){
            $r->session()->flash('error', 'Order status cannot be changed to delivered as invoice is not created yet!');
            return redirect('hawavee_orders/'.$r->get('order_no'));            
        }else if($order->invoice() != "" && $r->get('status') == 'canceled' ){
            $r->session()->flash('error', 'Order status cannot be CANCELED as invoice is already generated!');
            return redirect('hawavee_orders/'.$r->get('order_no'));            
        }else{
            $n = 0;
            if($r->get('status') == 'canceled'){
                $order->cancelOrder();                
            }
            if($r->get('status') == 'delivered'){
                $order->orderCommission();                
            }
            if($r->get('status') == 'dispatched'){
                $n = $order->orderReplace();                
            }

            $str = $r->get('day').' '.$r->get('month').' '.$r->get('year');
            $time = strtotime($str);

            $order->delivered_date = date('Y-m-d',$time);
            $order->order_status = $r->get('status');
            $order->save();
            if($n > 0){
                $note = "New order  <a href='".url("/hawavee_orders/$n")."'>$n</a> has been placed of the missing items";
            }else{
                $note = 'Order status has been updated successfully';
            }
            $r->session()->flash('success', $note);
            return redirect('hawavee_orders/'.$r->get('order_no'));            
        }
    }

    public function fill_order(Request $request){
        if($request->input('fill') != ''){
            foreach($request->input('fill') as $k=>$v){
                $ol = \App\Orderline::where('entry_id',$k)->first();
                $ol->filled_qty = $v;
                $ol->save();
            }
            $o = \App\Order::where('order_no',$request->input('order_no'))->first();
            $o->order_status = 'filled';
            $o->save();
            $request->session()->flash('success', 'Order Has Been Filled Successfully');
            return back();
        }
    }

    public function hawavee_detail($id)
    {  
        $order = \App\Order::findOrFail($id);

        if(\Entrust::hasRole('dropshipper') && Auth::user()->assign_customer != $order->customer_id){
           abort(403, 'Unauthorized action.');
        }

      //@php
      // $avilable = \App\ItemSizeColor::getqty1($line->item_no);
      //@endphp
        // get previous user id
        $previous = \App\Order::where('order_no', '<', $id)->where('sale_person', '!=', 'elam')->where('sale_person', '!=', 'shahzadmn')->max('order_no');

        // get next user id
        $next = \App\Order::where('order_no', '>', $id)->where('sale_person', '!=', 'elam')->where('sale_person', '!=', 'shahzadmn')->min('order_no');

        return view('orders/detail',compact('order','previous','next'));
    }

    public function update_note(Request $request){
        if($request->input('note') != ''){
            $order = Order::find($request->input('order_no'));
            if($order != null){
               $order->note =  $request->input('note');
               if($order->save() ){
                return redirect('/hawavee_orders/'.$request->input('order_no'));
               }
            }
        }
    }


    public function fws()
    {

        $orders = \App\Order::where('order_channel','fws')->orderBy('order_no', 'desc')->paginate();

        return view('orders/index')->with('orders', $orders);
    }

    public function update_fws_order(){
        if(!empty( Input::get('status')) && Input::get('status') == 2){
            Bigcommerce::configure(array(
                'store_url' => 'https://www.fashion-wholesalers.co.uk',
                'username'  => 'aqib026',
                'api_key'   => 'b1a2f6f047278164164c9f74414c490ede4f03c7'
                ));
            $id = Input::get('order_id');
            $fws_odetail = Bigcommerce::getOrder($id);

            $order_address_id = Bigcommerce::getOrderShippingAddresses($id);
            $order_address_id = $order_address_id[0]->id;

            $comments          = Input::get('service');
            $tracking_number   = Input::get('tracking_id');

            $items_arr = array();
            $items = Bigcommerce::getOrderProducts($id);
            foreach($items as $i){
                $items_arr[] = array('order_product_id'=>$i->id,'quantity'=>$i->quantity);
            }

            $arr = array('tracking_number'=>$tracking_number,
                'comments'=>$comments,
                'order_address_id'=>$order_address_id,
                'shipping_provider'=>'',
                'items'=>$items_arr,
                        );

            \App\Order::where('order_ref', $id)->where('order_channel', 'fws')->update(['order_status' => 'delivered']);

            $ship = Bigcommerce::createShipment($id,$arr);
            return redirect('/fws_detail/'.$id);

        }
    }

    public function fws_detail($id)
    {

        Bigcommerce::configure(array(
            'store_url' => 'https://www.fashion-wholesalers.co.uk',
            'username'  => 'aqib026',
            'api_key'   => 'b1a2f6f047278164164c9f74414c490ede4f03c7'
            ));

        Bigcommerce::failOnError();

        $order = Bigcommerce::getOrder($id);
        //echo "<pre>"; print_r($order); die('<br>************************************<br>');
       

        $shipping_address = Bigcommerce::getOrderShippingAddresses($id);

        //echo "<pre>"; print_r($order->billing_address->first_name); die('');

        $products = Bigcommerce::getOrderProducts($id);
        $prods = array();
        foreach($products as $p){
            //echo "<pre>"; print_r($p->product_options[1]->display_value); die('');
            $images = Bigcommerce::getProductImages($p->product_id);  
            $prods[$p->id]['sku']      = $p->sku;
            $prods[$p->id]['size']     = $p->product_options[1]->display_value;
            $prods[$p->id]['color']    = $p->product_options[0]->display_value;
            $prods[$p->id]['quantity'] = $p->quantity;
            $prods[$p->id]['image']    = $images[0]->thumbnail_url;
        }
        $products = Bigcommerce::getOrderProducts($id);
        //echo "<pre>"; print_r($products); die('');

        return view('orders/fws_detail')->with(compact('order','id','shipping_address','prods','products'));
    }

    public function ebay()
    {
        $orders = \App\Order::where('order_channel','ebay')->paginate(50);

        return view('orders/index')->with('orders', $orders);
    }
}
