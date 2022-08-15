<?php

namespace App\Http\Controllers;
use App\Purchaseorder as Purchaseorder;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Input;
use Auth;
class PurchaseController extends Controller
{
    //

    public function index(){
        if(!Auth::user()->can('add_purchase_order'))
            abort(403, 'Unauthorized action.');

        $suppliers = \App\Supplier::all();
        $user      = \Auth::user()->username;
        $supplier_id = '';
        $designs = \App\Item::where('continue1','yes')->get()->sortByDesc("id");
        $colors  = \App\Color::get();
        
        if( isset($_GET['supplier_id']) && $_GET['supplier_id'] != ''){
            $supplier_id = $_GET['supplier_id'];
            $pending_order = Purchaseorder::findPendingOrder($_GET['supplier_id']);
        }
        return view('purchase/index')->with(compact('suppliers','user','supplier_id','designs','colors','pending_order'));
    }

    public function listc(){

        $purchase_orders = \App\Purchaseorder::all()->sortByDesc("p_order_no");
        
        return view('purchase/list')->with(compact('purchase_orders'));
    }

    public function placed(){

        $purchase_orders = \App\Purchaseorder::where('order_status','placed')->get()->sortByDesc("p_order_no");
        
        return view('purchase/list')->with(compact('purchase_orders'));
    }

    public function detail($id){

        $order = \App\Purchaseorder::where('p_order_no',$id)->first();
        
        return view('purchase/detail')->with(compact('order'));
    }


    public function update(Request $r ,$id){

        if(!Auth::user()->can('edit_purchase_order'))
            abort(403, 'Unauthorized action.');

        $order = \App\Purchaseorder::where('p_order_no',$id)->first();

        if($order->order_status == 'placed'){

            $recevied_qty = $r->get('recevied');

            foreach($recevied_qty as $k=>$p){
                $pmodel = \App\Purchaseorderline::where('entry_id',$k)->first();
                if($pmodel != null){
                    $pmodel->received_qty = $p;
                    $pmodel->save();            
                }
            }
            $order->order_status = 'marked';
            $order->arrival_date = date('Y-m-d');
            $order->authorized_by = \Auth::User()->username;
            $order->save();
        }elseif($order->order_status == 'marked'){
        
        $order = \App\Purchaseorder::where('p_order_no',$id)->first();

        foreach($order->order_list as $isc){
           
            $model = \App\ItemSizeColor::where('design_code',$isc->design_code)->where('color',$isc->color)->where('size',$isc->size)->first();

            if($model == null){
                $model = new \App\ItemSizeColor;
            }
            
            $model->design_code   = $isc->design_code;
            $model->item_sku_code = $isc->design_code.'-'.$isc->color.'-'.$isc->size;
            $model->color         = $isc->color;
            $model->size          = $isc->size;
            $model->no_in_stock   = $model->no_in_stock + $isc->received_qty;
            $model->last_stock_in = $isc->received_qty;
            $model->qty           = $model->qty + $isc->received_qty;
            $model->aqty          = $model->aqty + $isc->received_qty;
            $model->loc           = $isc->loc;
            $model->save();
        }

            $order->order_status = 'received';
            $order->received_on = date('Y-m-d');
            $order->save();

    }
        return redirect('/purchase_detail/'.$id);
    }
    

    public function makePurchase(){

        if(!Auth::user()->can('add_purchase_order'))
            abort(403, 'Unauthorized action.');

    	if(!empty(Input::get('cost_price'))):	
    		$cost_price = Input::get('cost_price');
	    	$other_cost = Input::get('other_cost');

    		foreach($cost_price as $key=>$cp){
    			\App\Purchaseorderline::where('design_code', $key)->update(['cost_price' => $cp,'other_cost' => $other_cost[$key]]);
    		}
    	if(!empty(Input::get('place_order_id'))):	    		
    		\App\Purchaseorder::where('p_order_no', Input::get('place_order_id'))->update(['order_status' => 'placed']);
    	endif;
        return redirect('/purchase_detail/'.Input::get('place_order_id'));
		endif;
    }

    public function add_prows(Request $request){
        if($request->get('size') != ''){
            $size = \App\Size::where('category',$request->get('size'))->orderby('id','ASC')->pluck('size');
            return view('purchase/rows',compact('size'));
        }
    }

    public function removeItem(){

        if(!empty(Input::get('entry_id'))):
            $model = \App\Purchaseorderline::where('entry_id',Input::get('entry_id'));
            $model->forceDelete();
            return $this->purchase_item_list(Input::get('p_order_no'));
        endif;
        

    }

    public function addItem(){

    	if(!empty(Input::get('design_code'))):

    	// setup designcode by number
        $poderid = Input::get('p_order_no');
        $size =  (array) json_decode(Input::get('size'));
        $dc = Input::get('design_code');  
        $porderid = Input::get('p_order_no');
        $color   = Input::get('color');
        $w   = Input::get('weight');
        foreach($size as $s=>$k){
            if($k == '') $k = 0;
            if($k > 0)
                $this->additemrow($poderid,$dc,$s,$color,$k,$w);
        }    
        endif;

    	return $this->purchase_item_list(Input::get('p_order_no'));
    }

    public function additemrow($poderid,$dc,$size,$color,$qty,$w){

        $item_count = \App\Item::where('design_code',$dc)->first();

        $porder_line = \App\Purchaseorderline::where('p_order_no',$poderid)->where('design_code',$dc)->where('color',$color)->where('size',$size)->first();
        if($porder_line != null && $porder_line->count() > 0){
            $nqty = $qty + $porder_line->order_qty;
            //if(!\Entrust::hasRole('owner')){
            //    if($nqty > 40 ) $nqty = 40;
            //}
            $porder_line->order_qty = $nqty;
            $p_line->weight = $w;
            $porder_line->received_qty = 0;
            $porder_line->save();
        }else{
            $p_line = new \App\Purchaseorderline;
            $p_line->design_code = $dc;
            $p_line->p_order_no = $poderid;
            $p_line->color = $color;
            $p_line->size = $size;
            $p_line->weight = $w;
            $nqty = $qty;
            //if(!\Entrust::hasRole('owner')){
            //    if($nqty > 40 ) $nqty = 40;
            //}            
            $p_line->order_qty = $nqty;
            $p_line->received_qty = 0;
            $p_line->weight = $w;
            $p_line->save();
        }


    }

    public function purchase_item_list($p_order_no){
    	$purchase_order = \App\Purchaseorder::where('p_order_no',$p_order_no)->first();

    	return view('purchase/purchase_order')->with(compact('purchase_order'));
    }
}
