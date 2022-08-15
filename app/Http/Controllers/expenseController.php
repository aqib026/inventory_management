<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\expense;


class expenseController extends Controller
{
    //
    public function index(){

        return view('expense/index');
        //return view('message/index');
    }

    public function save_expense(Request $request){

       	$record = DB::table('expense')->where('date', $request->get('date'))->first();
		 if(!($record))
		 {
		  	$expense = new expense();
                       
            $expense->date = $request->get('date');
            $expense->expense_detail = $request->get('expense_detail');
		    $expense->expense_amount = $request->get('expense_amount');
            $expense->save();

            return redirect('/expenses')->with('success','Expense added successfully');
        }
        else
        {
            return redirect('/expenses')->withErrors(['Expense not Saved..!','You have already Entered expenses for '.$request->get('date')]);
        }


    }


    public function report(Request $request)
    {  
       
        
        if(  $request->input('date') ){
            
            $date = $request->input('date');
            

            $report = DB::select("SELECT count(orders.order_no) as no_of_orders, orders.delivered_date, orders.order_status, order_line.design_code, sum(order_line.filled_qty) as quantity, sum(order_line.charged_price) as price, sum(items.cost_price) as cost, sum(order_line.charged_price)-sum(items.cost_price) as profit FROM orders INNER JOIN order_line on orders.order_no = order_line.order_no INNER JOIN items on order_line.design_code = items.design_code where orders.order_status = 'delivered' and orders.delivered_date >='".$date." 00:00:00' and orders.delivered_date <= '".$date." 24:00:00' group by orders.delivered_date, order_line.design_code");

            $expenses = expense::where('date' , $date)->first();
            //var_dump($expenses);
            
                
        }

        
        return view('expense/report',compact('report','expenses'));
    }






}
