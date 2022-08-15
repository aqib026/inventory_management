<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    //
	protected $table = 'p_orders1';
    public $primaryKey = 'p_order_no';
    public $timestamps = false;


    protected $fillable = ['supplier_id', 'p_order_date', 'p_order_time','prepaired_by','buyer','supplier_id','order_status'];

    public function order_list()
    {
        return $this->hasMany('App\Purchaseorderline','p_order_no','p_order_no');
    }    

    public function supplier()
    {
          return $this->belongsTo('App\Supplier','supplier_id','supplier_id');
    }


    public static function findPendingOrder($supplier_id){

    	$pending_order = Purchaseorder::where('supplier_id',$supplier_id)->where('order_status','pending')->first();

    	if($pending_order == null)
    		$pending_order = Purchaseorder::createPendingOrder($supplier_id);

    	return $pending_order;

    }

    public static function createPendingOrder($supplier_id){
    		$data = array(
    			'supplier_id'=>$supplier_id,
    			'p_order_date'=>date('Y-m-d'),
    			'p_order_time'=>date('h:i A'),
    			'prepaired_by'=>\Auth::user()->username,
    			'buyer'=>\Auth::user()->username,
    			'supplier_id'=>$supplier_id,
    			'order_status'=>'pending',
    			);
    		$pending_order = Purchaseorder::create($data);
    		return $pending_order;

    }

    public static function Sizes(){
        $size = \App\Size::groupby('category')->pluck('category','category');
        $str = '';
        foreach($size as $k => $s){
            $str .= '<option value="'.$k.'">'.$k.'</option>';
        }
        return $str;

    }

    public function get_quantity_information(){

            $orders = \App\Order::select(\DB::raw('SUM(require_qty) as rqty,design_code'))->join('order_line', function($q){   $q->on('orders.order_no','order_line.order_no');
                        })->where('orders.order_status','!=','delivered')->where('orders.order_status','!=','canceled')->groupby('order_line.design_code')->paginate(5);
            return $orders;
    }
}


?>