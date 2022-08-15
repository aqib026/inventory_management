<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackingController extends Controller
{
    //
   public function cumulative(){
   	 $orders = \App\Order::where('order_status','placed')->where('order_date','>','2017-09-19')->get();

   	 $cumulative_elo = \DB::select( \DB::raw("SELECT o.order_no ono, o.order_status os, o.order_date od, ol.order_no, ol.design_code dc, ol.item_no ino, ol.size s, ol.color c, sum(ol.require_qty) rq from orders o, order_line ol where o.order_no = ol.order_no AND o.order_status = 'placed' AND order_date > '2017-09-19' GROUP BY ol.item_no ORDER BY ol.design_code, ol.color, ol.size") );

	/*$cumulative_elo = \App\Order::select(\DB::raw('item_size_color.aqty aqty'),\DB::raw('orders.order_no ono'),\DB::raw('orders.order_status os'),\DB::raw('orders.order_date od'),\DB::raw('order_line.order_no'),\DB::raw('order_line.design_code dc'),\DB::raw('order_line.item_no ino'),\DB::raw('order_line.size s'),\DB::raw('order_line.color c'), \DB::raw('sum(order_line.require_qty) rq')
	       )
	        ->join('order_line','order_line.order_no', 'orders.order_no')
	        ->join('item_size_color','order_line.item_no', 'item_size_color.item_sc_code')
	        ->where('orders.order_status', 'placed')
	        ->where('order_date','>','2017-09-19')
	        ->groupBy('order_line.item_no')
	        ->orderBy('order_line.design_code')
	        ->get();*/
   	return view('packing/cumulative',compact('orders','cumulative_elo'));
   }
}
