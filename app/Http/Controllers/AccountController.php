<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Customer;
use Auth;

class AccountController extends Controller
{
    //

    public function index($id){
        if(!Auth::user()->can('view_account'))
            abort(403, 'Unauthorized action.');

        if(\Entrust::hasRole('dropshipper') && Auth::user()->assign_customer != $id){
           abort(403, 'Unauthorized action.');
        }

    	$c = \App\Customer::find($id);
        $inv_sum = 0;
        $payments = $c->total_payment()->payment;
        foreach($c->all_invoices() as $inv){
            $inv_sum += ($inv->amount + $inv->vat);

            if($inv_sum <= $payments + 0.01){
                $inv->paid = 1;
                $inv->save();
            }
        }

    	return view('accounts.index',compact('c'));
    }

    public function update_credit_limit(Request $request){
        $c = \App\Customer::find($request->get('customer_id'));
        $c->credit_limit = $request->get('credit_limit');
        $c->credit_limit_percent = $request->get('credit_limit_percent');
        $c->save();
        return back()->with('success','Credit Limit Updated SuccessFully');
    }

    public function makepayment(Request $r){
    	$receipt = new \App\Receipt;
    	if($receipt->add($r)){
    		$r->session()->flash('success','Payment Has Been Added SuccessFully');
    		return back();
    	}
    }

    public function voucher_detail($id,$st){
        if($st == 1)
            $v = \App\Voucher::find($id);
        else
            $v = \App\Bvoucher::find($id);
        return view('accounts.vd',compact('v','st'));
    }
}
