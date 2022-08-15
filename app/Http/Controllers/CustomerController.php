<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;
use \App\User;
use Auth;
class CustomerController extends Controller
{

    public function generate_code(Request $request, $id){
        //
        if(!Auth::user()->can('create_account'))
            abort(403, 'Unauthorized action.');

        $c = \App\Customer::where('customer_id',$id)->first();

        if($c->vat == 1){
            $acc_code = \App\Account::where('cat','customer')->orderBy('acc_code','desc')->first();
            $a = new \App\Account;
            $a->acc_code   = $acc_code->acc_code + 1;
            $a->ref_id     = $id;
            $a->head_title = 'RECEIVABLE';
            $a->acc_title  = $c->customer_name.$id;
            $a->cat        = 'customer';
            $a->pk_uk      = $c->country;
            $a->date_created = date('Y-m-d');
            $a->opening_balance = 0.00;
            $a->save();
            $c->acc_code = $acc_code->acc_code + 1;
            if(!$c->save()){
                dd( $c->getErrors() );
            }
        }else{
            $acc_code = \App\Baccount::where('cat','customer')->orderBy('acc_code','desc')->first();
            $a = new \App\Baccount;
            $a->acc_code   = $acc_code->acc_code + 1;
            $a->ref_id     = $id;
            $a->head_title = 'RECEIVABLE';
            $a->acc_title  = $c->customer_name.$id;
            $a->cat        = 'customer';
            $a->pk_uk      = $c->country;
            $a->date_created = date('Y-m-d');
            $a->opening_balance = 0.00;
            $a->save();

            $c->acc_code = $acc_code->acc_code + 1;
            if(!$c->save()){
                dd( $c->getErrors() );
            }
        }
        $request->session()->flash('success', 'Account Has been created Successfully');
        return redirect('/customers');
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if(!Auth::user()->can('manage_customer'))
            abort(403, 'Unauthorized action.');


        $customers = new Customer; //::orderBy('customer_id', 'desc')->paginate(50);
        $search = '';
        $filter_by = '';
        $country = 'UK';
        if( $request->input('c') ){
            $country = $request->input('c');
            $customers = $customers->where('country',$country);
        }else{
            $customers = $customers->where('country','UK');
        }

        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $customers = $customers->where($filter_by,'like','%'.$search.'%');
        }
        if(\Entrust::hasRole('dropshipper')){
            $customers = $customers->where('customer_id',Auth::user()->assign_customer);
        }elseif(\Auth::User()->username == 'elam'){
            $customers = $customers->where( function($query){
                $query->where('user','elam');
                $query->orWhere('user','shahzadmn');
            });            
        }else{
            $customers = $customers->where('user','!=','elam')->where('user','!=','shahzadmn');
        }

        $customers = $customers->where('active',1)->orderBy('customer_id','desc')->paginate(50);
         $active = 'yes';   
        
        return view('customer.index',compact('customers','search','filter_by','active','country'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nonactive(Request $request)
    {
        if(!Auth::user()->can('manage_customer'))
            abort(403, 'Unauthorized action.');

        $customers = new Customer; //::orderBy('customer_id', 'desc')->paginate(50);
        $customers = $customers->where('active',0);
        $search = '';
        $filter_by = '';
        $country = 'UK';
        if( $request->input('c') ){
            $country = $request->input('c');
            $customers = $customers->where('country',$country);
        }else{
            $customers = $customers->where('country','UK');
        }
        if( $request->input('search') ){
            $search = $request->input('search');
            $filter_by = $request->input('filter_by');
            $customers = $customers->where($filter_by,'like','%'.$search.'%');
        }
        $customers = $customers->orderBy('customer_id','desc')->paginate(50);   
        $active = 'no';
        return view('customer.index',compact('customers','search','filter_by','active','country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('add_customer'))
            abort(403, 'Unauthorized action.');
        $model = new Customer;
        $users  = User::pluck('username','username');
        return view('customer.create',compact('model','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('add_customer'))
            abort(403, 'Unauthorized action.');
        $validation = $this->validate($request, [
             'customer_name' => 'required|max:255',                  
        ]);

        $cat = new Customer;
        $cat->customer_name     = $request->get('customer_name');
        $cat->middle_name     = $request->get('middle_name');
        $cat->last_name = $request->get('last_name');
        $cat->business_name   = $request->get('business_name');
        $cat->customer_add   = $request->get('customer_add');
        $cat->city   = $request->get('city');
        $cat->country   = $request->get('country');        
        $cat->postcode   = $request->get('postcode');        
        $cat->mob_no   = $request->get('mob_no');        
        $cat->office_no   = $request->get('office_no');        
        $cat->email   = $request->get('email');  
        $cat->user   = $request->get('user');  
        $cat->vat   = $request->get('vat');        
        $cat->created_by  =  Auth::User()->username;    
        $cat->save();            
        return redirect('/customers');

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->can('view_customer'))
            abort(403, 'Unauthorized action.');
        $c = Customer::find($id);
        return view('customer.show',compact('c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('edit_customer'))
            abort(403, 'Unauthorized action.');
        $model = Customer::find($id);
        $users  = User::pluck('username','username');
        return view('customer.edit',compact('model','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Auth::user()->can('edit_customer'))
            abort(403, 'Unauthorized action.');
        $validation = $this->validate($request, [
             'customer_name' => 'required|max:255',                  
        ]);

        $cat = Customer::find($id);
        $cat->customer_name = $request->get('customer_name');
        $cat->middle_name   = $request->get('middle_name');
        $cat->last_name     = $request->get('last_name');
        $cat->business_name = $request->get('business_name');
        $cat->customer_add  = $request->get('customer_add');
        $cat->city          = $request->get('city');
        $cat->country       = $request->get('country');        
        $cat->postcode      = $request->get('postcode');        
        $cat->mob_no        = $request->get('mob_no');        
        $cat->office_no     = $request->get('office_no');        
        $cat->email         = $request->get('email');  
        $cat->user          = $request->get('user');
        $cat->active        = $request->get('active');
        $cat->type        = $request->get('type');        
        $cat->save();            

        return back()->with('success', 'Customer Has Been Updated Successfully');
    }

}
