<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use \App\Customer as customer;
use \App\User;
use \App\Messages;
use \App\MessageCustomers;
use \App\BlockedUsers;
use Auth;

class messageController extends Controller
{
    public function index(){

        $user = Auth::user();
        $c_date = date('Y-m-d');
        $p_date = date('Y-m-d',strtotime('-7 days',strtotime(date('Y-m-d'))));
        $performance_d=null;
        $performance_w=null;

        $p = DB::select("SELECT DATE_FORMAT(created_at,'%H:%i:%S') as by_date, customer_id from messages where created_at >= '".$c_date." 00:00:00' and created_at <= '".$c_date." 24:00:00' and user_id = '".$user->member_id."' ORDER BY by_date ASC");
        if($p!=null){
            $Seconds = 0;
            $Seconds_prev = 0;
            $sumSeconds = 0;
            foreach($p as $time) 
            {
                $explodedTime = explode(':', $time->by_date);
                $seconds = $explodedTime[0]*3600 + $explodedTime[1]*60 + $explodedTime[2];
                $diff = $seconds - $Seconds_prev;
                $hours = floor($diff/3600);
                //var_dump($seconds);
                if( $hours < 1 )
                {
                    $sumSeconds = $sumSeconds + $diff;
                }
                $Seconds_prev=$seconds;
            }
            $hours = floor($sumSeconds/3600);
            $minutes = floor(($sumSeconds % 3600)/60);
            $seconds = (($sumSeconds%3600)%60);
            $performance_d = $hours.':'.$minutes.':'.$seconds;
            //var_dump($per);
        }  
      
        $performance_w = DB::select("SELECT DATE_FORMAT(created_at,'%H:%i:%S') as by_time, DATE_FORMAT(created_at,'%Y-%m-%d') as by_date, customer_id from messages where created_at >= '".$p_date." 00:00:00' and created_at <= '".$c_date." 24:00:00' and user_id = '".$user->member_id."' ORDER BY created_at ASC");
       if($performance_w!=null){
            $Seconds = 0;
            $Seconds_prev = 0;
            $date_prev=0;
            $sumSeconds = 0;
            foreach($performance_w as $time) 
            {
                $explodedTime = explode(':', $time->by_time);
                $seconds = $explodedTime[0]*3600 + $explodedTime[1]*60 + $explodedTime[2];                
                //var_dump($date_prev);
                if($date_prev == $time->by_date)
                {   
                    $diff = $seconds - $Seconds_prev;
                    $hours = floor($diff/3600);
                    
                    //var_dump($hours);
                    if( $hours < 1 )
                    {
                        $sumSeconds = $sumSeconds + $diff;
                       
                    }
                }
                $Seconds_prev=$seconds;
                $date_prev=$time->by_date;
            }
            $hours = floor($sumSeconds/3600)-1;
            $minutes = floor(($sumSeconds % 3600)/60);
            $seconds = (($sumSeconds%3600)%60);
            if($hours < 0)
                {$hours=0;}
            $performance_w = $hours.':'.$minutes.':'.$seconds;
            //var_dump($per);
        }  
        
        $customers = DB::select("SELECT customers.customer_id, customers.customer_name, customers.middle_name, customers.last_name, message_customers.visited, message_customers.unblock_on, message_customers.status FROM customers LEFT JOIN message_customers on message_customers.customer_id = customers.customer_id ORDER BY customers.customer_id ASC");


        return view('message/index')->with(compact('customers','performance_d','performance_w'));
       //$date = date('Y-m-d H:i:s');
    }
	

	public function save_message(Request $request){
         $user = Auth::user();
         $blocked_user = \App\BlockedUsers::where('user_id',$user->member_id)->first();

        $last = DB::table('messages')->where('user_id',$user->member_id)->orderBy('created_at', 'desc')->first();
        $d = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($last->created_at)));
        
        /*$l = DB::table('messages')->where('user_id',$user->member_id)->where('created_at', '>=' , date('Y-m-d')." 10:00:00" )->where('created_at', '<=' , date('Y-m-d')." 20:30:00" )->orderBy('created_at', 'desc')->first();
        if($l != null){
        $user_time = date('Y-m-d H:i:s',strtotime('+60 minutes',strtotime($l->created_at)));
        if( date('Y-m-d H:i:s') > $user_time &&  date('Y-m-d H:i:s') > $blocked_user->active_for )
        {
            if($blocked_user==null)
            {
                DB::select("INSERT INTO blocked_users (user_id, user_name, status, status_changed_by, created_at, updated_at) VALUES ('".$user->member_id."','".$user->username."','Blocked', 'Auto','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
            }
            else
            {
                $ddd = date('Y-m-d H:i:s',strtotime('+180 minutes',strtotime(date('Y-m-d H:i:s'))));
                DB::select("UPDATE blocked_users SET status = 'Blocked', status_changed_by = 'Auto', active_for = '".$ddd."' WHERE user_id = '".$user->member_id."'");
            }
        }}*/
        $blocked_user = \App\BlockedUsers::where('user_id',$user->member_id)->first();
        //var_dump($blocked_user);
        if($blocked_user!=null){
        if($blocked_user->status == "Blocked")
        {
            return redirect('/message')->withErrors(['Your ID is Blocked, because you have not visited any customer within an hour..!','Please Contact your Owner to become an active User after providing proof of where were you?']);
        }}

        if( date('H:i:s') > "10:00:00" && date('H:i:s') < "20:30:00" && date('Y-m-d H:i:s') > $d  && $blocked_user->status == "Active") 
        {
		  $message = new Messages();    
            $customers = customer::where( 'customer_id',$request->get('customer_id') )->first();
            $message->type  = $request->get('sale_type');
            if($request->get('sale_type') == "email")
            {
                $message->email = $request->get('email');
            }
            else if($request->get('sale_type') == "watsapp")
            {
                $message->watsapp  = $request->get('watsapp');
            }
		  $message->customer_id  = $request->get('customer_id');
		  if($request->get('customer_id') == 0)
            {
                $message->customer_name = $request->get('customer_name');
                $message->phone =  $request->get('phone');
            }
            else
            {
                $message->customer_name  = $customers->customer_name ." ". $customers->middle_name ." ". $customers->last_name;
                $message->phone =  $customers->mob_no;

                $mcc = \App\MessageCustomers::where('customer_id', $request->get('customer_id'))->first();
                if($mcc == null)
                {
                    $mc = new MessageCustomers();
                    $mc->customer_id = $request->get('customer_id');
                    $mc->customer_name = $customers->customer_name ." ". $customers->middle_name ." ". $customers->last_name;
                    $mc->visited = "yes";
                    $mc->block_days = '5';
                    $mc->unblock_on = date('Y-m-d H:i:s',strtotime('+5 days',strtotime(date('Y-m-d H:i:s'))));
                    $mc->status= "blocked";
                    $mc->save();
                }
                else
                {
                    $cc = \App\MessageCustomers::where('customer_id', $request->input('customer_id'))->first();
                    DB::table('message_customers')->where('customer_id', $request->get('customer_id'))->update(['visited' => "yes", 'unblock_on' => date('Y-m-d H:i:s',strtotime('+'.$cc->block_days.' days',strtotime(date('Y-m-d H:i:s')))), 'status' => "blocked"]);
                }
            }

            $message->message = $request->get('message');
            $message->orders_recieved = $request->get('orders_recieved');
		    $message->payment_recieved = $request->get('payment_recieved');
		    $message->amount = $request->get('amount');
		    $message->time = $request->get('time');
            $message->user_id = $user->member_id;
            $message->save();

            return redirect('/message')->with('success','Message Saved successfully');
        }
        else 
        {
            if( date('Y-m-d H:i:s') < $d ) {
                return redirect('/message')->withErrors(['Message not Saved..!','You are not Allowed to enter another message with in 5 minutes']);
            }else{
                return redirect('/message')->withErrors(['Message not Saved..!','Come back Later Between 10:00 - 20:30']);
            }
        }


    }


public function view_messages(Request $request)
    {  
        $messages = \App\Messages::orderBy('message_id', 'dsc');
        
        $search = '';
        $type = 'all';
        $filter_by = '';
        $date= '';

        if( $request->input('search') || $request->input('date') ||  $request->input('user_id') || $request->input('type') ){
            
            if($request->input('search')){
            	$search = $request->input('search');
            }

            $filter_by = $request->input('filter_by');
            $date = $request->input('date');
            $users = $request->input('user_id');
            $type = $request->input('type');

            if($filter_by == 'message_id')
                $messages = $messages->where('messages.message_id','like','%'.$search.'%');
            else if($filter_by == 'customer_id')
                $messages = $messages->where('messages.customer_id','like','%'.$search.'%');
            else if($filter_by == 'customer_name')
                $messages = $messages->where('messages.customer_name','like','%'.$search.'%');
             else if($filter_by == 'date')
                $messages = $messages->where('messages.created_at','like','%'.$date.'%');
            else if($filter_by == 'user')
                $messages = $messages->where('messages.user_id',$users);
            else if($filter_by == 'type')
                $messages = $messages->where('messages.type',$type);
            else
                $messages = $messages->where($filter_by,'like','%'.$search.'%');
        }
        $users = User::all();

        $messages = $messages->get();
        
        return view('message/view_messages',compact('search','messages','type','filter_by','date','users'));
    }


    public function message_id($id)
    {  
        $messages = \App\Messages::where('message_id', $id)->first();
    
        return view('message/view_detail_messages',compact('messages'));
    }
    



    public function report(Request $request)
    {  
        $users = User::all();
       
        
        if(  $request->input('date_from') &&  $request->input('user_id') && $request->input('type') && $request->input('date_to')){
            
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $users = $request->input('user_id');
            $type = $request->input('type');

            $messages = DB::select("SELECT customer_id,customer_name, Count(message_id) as trips, Sum(time) as time, Sum(orders_recieved) as orders, Sum(amount) as cash, Sum(amount)/Count(message_id) as per_cash, Sum(orders_recieved)/Count(message_id) as per_order, Sum(time)/Count(message_id) as per_time  FROM messages where user_id='".$users."' and type='".$type."' and created_at >='".$date_from." 00:00:00' and created_at <= '".$date_to." 24:00:00' GROUP BY customer_name");

                $payments = DB::select("SELECT DISTINCT(messages.customer_id), messages.customer_name, receipt.date, SUM(receipt.amount) as amount FROM `messages` Inner JOIN receipt on DATE_FORMAT(messages.created_at,'%Y-%m-%d') = receipt.date where messages.customer_id=receipt.customer_id GROUP BY receipt.customer_id");

                 $orders = DB::select("SELECT DISTINCT(orders.customer_id), messages.customer_name, SUM(DISTINCT CASE WHEN orders.order_no THEN orders.amount END) as amount, COUNT(DISTINCT CASE WHEN orders.customer_id THEN orders.order_no END) as no_of_orders, orders.order_date FROM `messages` INNER JOIN orders on DATE_FORMAT(messages.created_at,'%Y-%m-%d') = orders.order_date WHERE orders.customer_id = messages.customer_id GROUP BY orders.customer_id ORDER BY `orders`.`customer_id` ASC");
                //var_dump($orders);
                //$messages = \App\Messages::where('messages.user_id',$users)->where('created_at','>',$date_from)->where('created_at','<',$date_to)->groupBy('customer_name')->get();
                //var_dump($payments);
                
        }
        $users = User::all();
        
        return view('message/report',compact('users','messages','type','payments', 'orders'));
    }



 public function user_report(Request $request)
    {  
        $users = User::all();
       
        
        if(  $request->input('date_from') &&  $request->input('user_id') && $request->input('type') && $request->input('date_to')){
            
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');
            $users = $request->input('user_id');
            $type = $request->input('type');

            $messages = DB::select("SELECT DATE_FORMAT(created_at,'%Y-%m-%d') as by_date, timediff(MAX(created_at),MIN(created_at)) as working_time, COUNT(DISTINCT(customer_name)) as customers_visited, Count(message_id) as trips, SUM(time) as time, SUM(orders_recieved) as orders, SUM(amount) as cash, ROUND(SUM(amount)/Count(message_id),2) as per_cash, ROUND(SUM(orders_recieved)/Count(message_id),2) as per_order, ROUND(SUM(time)/Count(message_id),2) as per_time, count(watsapp) as watsapp, count(email) as email FROM messages where user_id='".$users."' and type='".$type."' and created_at >='".$date_from." 00:00:00' and created_at <= '".$date_to."24:00:00' GROUP BY by_date");

             $orders = DB::select("SELECT COUNT(DISTINCT CASE WHEN orders.order_no THEN orders.order_no END) as no_of_orders, SUM(DISTINCT CASE WHEN orders.order_no THEN orders.amount END) as amount, orders.order_date FROM `messages` INNER JOIN orders on DATE_FORMAT(messages.created_at,'%Y-%m-%d') = orders.order_date WHERE messages.user_id = orders.user_id and messages.user_id = '".$request->input('user_id')."' GROUP BY orders.order_date");
             //var_dump($orders);

             $payments = DB::select("SELECT SUM(DISTINCT CASE WHEN receipt.receipt_id THEN receipt.amount END) as payment, receipt.date FROM `messages` INNER JOIN receipt on DATE_FORMAT(messages.created_at,'%Y-%m-%d') = receipt.date WHERE messages.customer_id=receipt.customer_id GROUP BY receipt.date");
            //var_dump($payments);

        }
        $users = User::all();
        
        return view('message/user_report',compact('users','messages', 'type','orders','payments','date_from','date_to'));
    }


 public function show_blocked_customers(Request $request)
    {  

        $customers = DB::select("SELECT id, customer_id, customer_name, block_days, DATE_FORMAT(unblock_on,'%Y-%m-%d') as date_unblock, status, created_at FROM message_customers WHERE status = 'blocked'");

        if($request->input('days'))
        {
            $cc = \App\MessageCustomers::where('customer_id', $request->input('customer_id'))->first();
            $days = $request->input('days') - $cc->block_days ;
            if($days > 0)
                $unblock_on = date('Y-m-d H:i:s',strtotime('+'.$days.' days',strtotime($cc->unblock_on)));
            else if($days < 0)
                $unblock_on = date('Y-m-d H:i:s',strtotime($days.' days',strtotime($cc->unblock_on)));
            else
                return redirect('/blocked_customers')->withErrors(['Nothing Changed..!']);
            //var_dump($cc->block_days);
            DB::select("UPDATE message_customers SET block_days = '".$request->input('days')."', unblock_on = '".$unblock_on."' WHERE customer_id = '".$request->input('customer_id')."'");
            //return redirect('/blocked_customers')->with('success','Successfully Edited Unblock Date');
        }
       
 
        return view( 'message/blocked_customers',compact('customers') );
    }


    public function show_blocked_users(Request $request)
    {  
        
        $users = DB::select("SELECT * FROM blocked_users");
        

        if($request->input('status')  )
        {
            $d = date('Y-m-d H:i:s',strtotime('+180 minutes',strtotime(date('Y-m-d H:i:s'))));
            DB::update("UPDATE blocked_users SET status = '".$request->input('status')."', status_changed_by = 'Owner', active_for = '".$d."' WHERE user_id = '".$request->input('user_id')."'");
            return redirect('/blocked_users')->with('success','Successfully Edited Status');
        }
        
 
        return view( 'message/blocked_users',compact('users') );
    }






}
