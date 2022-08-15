<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    public function pending_payments(Request $r){
        if(!\Auth::user()->can('manage_payment'))
            abort(403, 'Unauthorized action.');

    	$receipts = \App\Receipt::where('status','pending')->orderby('receipt_id','desc');
    	if($r->get('user') != ''){
    		$receipts = $receipts->where('user',$r->get('user'));
    	}

        if(\Auth::User()->username == 'elam')
            $receipts = $receipts->where('user','elam')->orwhere('user','shahzadmn');
        else
            $receipts = $receipts->where('user','!=','elam')->where('user','!=','shahzadmn');

    	$receipts = $receipts->paginate(20);
    	$users    = \App\User::all();
    	return view('payments.pending',compact('receipts','users') );
    }

    public function received($receipt_id){
        if(!\Auth::user()->can('manage_payment'))
            abort(403, 'Unauthorized action.');

    	$r = \App\Receipt::find($receipt_id);
    	$r->status = 'received';
    	$r->confirm_date = date('Y-m-d');
    	$r->confirm_by = \Auth::User()->username;
        if($r->st == 0){
            $resp = \App\Bvoucher::generate_voucher($receipt_id);
        }else{
            $resp = \App\Voucher::generate_voucher($receipt_id);
        }
    	$r->save();
        if($resp == 'done')
        	return redirect('/pending_payments')->with('success','Payment received successfully');
        else
    	   return redirect('/pending_payments')->with('error',$resp);
    }

    public function received_payments(Request $r){
        if(!\Auth::user()->can('manage_payment'))
            abort(403, 'Unauthorized action.');

        $receipts = \App\Receipt::where('status','received')->orderby('receipt_id','desc');
        if($r->get('user') != ''){
            $receipts = $receipts->where('user',$r->get('user'));
        }
        if(\Auth::User()->username == 'elam')
            $receipts = $receipts->where('user','elam')->orwhere('user','shahzadmn');
        else
            $receipts = $receipts->where('user','!=','elam')->where('user','!=','shahzadmn');
        
        $receipts = $receipts->paginate(50);
        $users    = \App\User::all();
        return view('payments.received',compact('receipts','users') );        
    }

    public function markunmark(Request $r){

        if($r->get('rid') != ""){
            $receipt = \App\Receipt::find($r->get('rid'));
            $receipt->mark = $r->get('m');
            $receipt->save();
        }
    }

}
