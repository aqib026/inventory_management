<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer as Customer;
use \App\Category as Category;
use \App\TempOrder as TempOrder;
use \App\TempOrderLine as TempOrderLine;
use \App\ItemSizeColor as ItemSizeColor;
use \App\Item as Item;
use Auth;
use Carbon\Carbon as Carbon;

class SalesController extends Controller
{
    //
    public function showlisting(){
        $order_no = $this->createTempOrder(Auth::user()->assign_customer,'UK','');
        session(['co_cust_id' => Auth::user()->assign_customer]);
        session(['warehouse' => 'PK']);
    }
    public function index(Request $request){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if(\Entrust::hasRole('dropshipper')){
            $this->showlisting();
            return redirect('/listing');

            }
    	if (\Session::has('co_cust_id')){
    		\Session::pull('co_cust_id');
    	}
        $customers = \App\Customer::orderBy('customer_id', 'desc');
        $search = '';
        $filter_by = '';

        if( $request->get('search') != '' ){
            $search    = $request->get('search');
            $filter_by = $request->get('filter_by');
            $customers = $customers->where($filter_by,'like','%'.$search.'%');
        }
        if(\Auth::User()->username == 'elam'){
        	$customers = $customers->where('user','elam')->orWhere('user','shahzadmn');
        }else{
            $customers = $customers->where('user','!=','elam')->where('user','!=','shahzadmn');
        }

        $customers = $customers->where( function($query){
            //$query->where('r_date','0000-00-00');
            //$query->orWhere('r_date','>=',date('Y-m-d'));
        });
        $customers = $customers->where('active',1);
        $customers = $customers->paginate(20);

    	return view('sales.index',compact('customers','search','filter_by'));

    }

    public function selectCustomer(){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

    	if( isset($_POST['customer_id'] )){
    		session(['co_cust_id' => $_POST['customer_id']]);
	        return redirect('/select_warehouses');
    	}else{
			\Session::flash('message', 'Please select the customer first');
			\Session::flash('alert-class', 'alert-danger'); 
	        return redirect('/sales');
    	}

    }

    public function selectWarehouses(){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if (!\Session::has('co_cust_id')){
            \Session::flash('message', 'Customer is not defined,Please select the customer first!');
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/sales');
        }
        return view('sales.warehouse');
    }

    public function selectWarehouse(){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if (!\Session::has('co_cust_id')){
            \Session::flash('message', 'Customer is not defined,Please select the customer first!');
            \Session::flash('alert-class', 'alert-danger'); 
            return redirect('/sales');
        }

        if( isset($_POST['warehouse'] )){
            session(['warehouse' => $_POST['warehouse']]);
            $this->createTempOrder(session('co_cust_id'),$_POST['warehouse']);            
            return redirect('/listing');
        }

    }

    public function listing(Request $request){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if (!\Session::has('co_cust_id') || !\Session::has('warehouse')){
            \Session::flash('message', 'Customer OR warehouse is not selected properly !');
            \Session::flash('alert-class', 'alert-danger');         
            return redirect('/sales');  
        }

        $customer = $this->validateSess();


        $items = \App\Item::where('continue1','yes')->orderBy('id','desc');//->paginate(12);

    
        //$items = \App\ItemSizeColor::join('items', function($q){ 
        //            $q->on('items.design_code','item_size_color.design_code');
        //            })->where('items.continue1','yes')->groupby('item_size_color.design_code')->orderBy('items.id','desc');//->paginate(12);*/ //->having(\DB::raw('sum(aqty)'),'>',0)

        if(\Session::has('warehouse')){
            $items = $items->where('warehouse',\Session('warehouse'));
        }

            $items = $items->where('gfl_p','!=',0.00);
            $items = $items->where('b2s_p','!=',0.00);
        $search = '';
        if( $request->input('search') ){
            $search = $request->input('search');
            $items = $items->where('items.design_code','like','%'.$search.'%');
        }
        $sel_cat_name = '';
        if( $request->input('cat_id') ){
            $catid = $request->input('cat_id');
            $items = $items->where('category_id',$catid);
            $sel_cat_name = Category::where('cat_id',$catid)->first();
        }
        $items = $items->paginate(30);

        $cats = Category::where('cat_parent',0)->get();
    	
        return view('sales.listing',compact('cats','items','sel_cat_name','customer','search'));
    }

    public function item_detail($design_code){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');
        if (!\Session::has('co_cust_id') || !\Session::has('warehouse')){
            \Session::flash('message', 'Customer OR warehouse is not selected properly !');
            \Session::flash('alert-class', 'alert-danger');         
            return redirect('/sales');  
        }

        $customer = $this->validateSess();

        $item = \App\Item::where('design_code',$design_code)->first();
        foreach($item->sizeAndColors as $isc){
            $isc->getqty1($isc->item_sc_code);            
        }
        $item = \App\Item::where('design_code',$design_code)->first();

        $price = \App\Item::price($item,\Session('co_cust_id'));

        return view('sales.detail',compact('item','price','customer'));

    }

    public function AddtoBucket(Request $request){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if (!\Session::has('co_cust_id') || !\Session::has('warehouse')){
            \Session::flash('message', 'Customer OR warehouse is not selected properly !');
            \Session::flash('alert-class', 'alert-danger');         
            return redirect('/sales');  
        }

        $this->validateSess();

        foreach($request->input('rqty') as $k=>$i){
            if(!empty($i)){
                Item::add_temp_order_line($k,$i,$this->createTempOrder(session('co_cust_id'),session('warehouse')),$request->input('c_price'));
            }
        }
        return redirect('/viewbucket'); 
        //
    }

    public function viewBucket(){
        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');

        if (!\Session::has('co_cust_id') || !\Session::has('warehouse')){
            \Session::flash('message', 'Customer OR warehouse is not selected properly !');
            \Session::flash('alert-class', 'alert-danger');         
            return redirect('/sales');  
        }

        $customer = $this->validateSess();
        $bucket = TempOrder::where('order_no',$this->createTempOrder(session('co_cust_id'),session('warehouse')))->first();
        $terms  = \App\PaymentTerm::pluck('term','term');   
        return view('sales.bucket',compact('bucket','customer','address','terms'));
    }

    public function complete_order(Request $request){
        if($request['expec_pay_date'] != ''){
            Item::complete_order($request,$this->createTempOrder(session('co_cust_id'),session('warehouse')));            
        }
        $request->session()->flash('success', 'Order Has been placed successfully !, For new order select the user below');
        return redirect('/sales');    
    }

    public function remove_line($id){

        if(!Auth::user()->can('make_sales'))
            abort(403, 'Unauthorized action.');
        
        $line = TempOrderLine::where('entry_id', $id)->first();
        $item = ItemSizeColor::where('item_sc_code',$line->item_no)->first();
        $item->aqty = $item->aqty + $line->require_qty;
        $item->save();
        $line->delete();
        return redirect('/viewbucket');
    }


    public function add_address(Request $request){
        $add = new \App\DeliveryAddress;
        $add->fname       = $request->input('fname');
        $add->mname       = '';
        $add->lname       = $request->input('lname');
        $add->address     = $request->input('address');
        $add->city        = $request->input('city');
        $add->country     = $request->input('country');
        $add->postcode    = $request->input('postcode');
        $add->mobile_no   = $request->input('mobile_no');
        $add->office_no   = $request->input('office_no');
        $add->customer_id = $request->input('customer_id');
        if($add->save()){
            return redirect('/viewbucket');            
        }else{
            $request->session()->flash('error', 'Address submission failed!');
            return redirect('/viewbucket');
        }
    }


    public function createTempOrder($customer_id,$type=null,$ctype=null){
        if(\Entrust::hasRole('dropshipper')){
            $temp_order = TempOrder::where('customer_id',$customer_id)->where('order_status','pending')->where('order_type',$type)->where('sale_person','elam')->first();
        }else{            
            $temp_order = TempOrder::where('customer_id',$customer_id)->where('order_type',$type)->where('order_status','pending')->where('sale_person',Auth::User()->username)->first();
        }
        if(empty($temp_order)){
            $now = Carbon::now();
            $temp_order = new TempOrder;
            $temp_order->customer_id = $customer_id;
            $temp_order->order_date  = date('Y-m-d');
            $temp_order->order_time  = $now->format('g:i A');
            $temp_order->expected_delivery_date = Carbon::now()->addDays(7)->format('Y-m-d');
            
            if(\Entrust::hasRole('dropshipper'))
                $temp_order->sale_person = 'elam';
            else
                $temp_order->sale_person = Auth::User()->username;

            $temp_order->order_status = 'pending';
            if($type != null){
               $temp_order->order_type = $type;
            }
            if($temp_order->save() ){
                if($ctype == null)
                   return $temp_order->order_no;
                elseif($temp_order->order_type != null){
                   return  $temp_order->order_type;
                }
            }
        }else{
            if($type != null){
               $temp_order->order_type = $type;
               $temp_order->save();
            }
            if($ctype == null)
               return $temp_order->order_no;
            elseif($temp_order->order_type != null){
               return  $temp_order->order_type;
            }
        }

        return '';
    }
    public function validateSess(){

        $customer = Customer::find(\Session('co_cust_id'));
        return $customer;        

    }
}
